<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Helpers\ShippingHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);

        // Redirect if cart is empty
        if (empty($cartItems)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = $this->calculateSubtotal($cartItems);
        $discount = session()->get('discount', 0);
        
        // Default shipping - will be calculated based on address
        $shipping = ShippingHelper::calculateShippingCost($subtotal);
        $total = $subtotal - $discount + $shipping;

        // Get scout discount settings
        $scoutDiscountEnabled = \App\Models\SystemSetting::scoutDiscountEnabled();
        $scoutDiscountPercent = \App\Models\SystemSetting::scoutDiscountPercent();
        $scoutDiscountCode = \App\Models\SystemSetting::scoutDiscountCode();

        // Convert cart items to collection
        $cartItems = collect($cartItems)->map(function ($item, $rowId) {
            return (object) array_merge($item, [
                'rowId' => $rowId,
                'options' => (object) ($item['options'] ?? [])
            ]);
        });

        // Get user's previous order info for auto-fill
        $user = auth()->user();
        $lastOrder = null;
        if ($user) {
            $lastOrder = Order::where('user_id', $user->id)->latest()->first();
        }

        return view('frontend.checkout', compact('cartItems', 'subtotal', 'discount', 'shipping', 'total', 'lastOrder', 'user', 'scoutDiscountEnabled', 'scoutDiscountPercent', 'scoutDiscountCode'));
    }

    /**
     * Process the checkout
     */
    public function process(Request $request)
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer,card,bkash,nagad,rocket',
        ];

        if (!auth()->check()) {
            $rules['email'] = 'required|email|max:255|unique:users,email';
            $rules['password'] = 'required|string|min:8';
        }

        $request->validate($rules);

        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = $this->calculateSubtotal($cartItems);
        $discount = session()->get('discount', 0);
        
        // Calculate shipping based on customer address
        $address = $request->city . ' ' . $request->address;
        $shipping = ShippingHelper::calculateShippingCost($subtotal, $address);
        $total = $subtotal - $discount + $shipping;

        try {
            DB::beginTransaction();

            $userId = auth()->id();

            if (!$userId) {
                // Create user
                $user = User::create([
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'username' => explode('@', $request->email)[0] . rand(1000, 9999),
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'password' => Hash::make($request->password),
                    'is_active' => true,
                ]);

                // Auto-verify email so they can access dashboard immediately
                $user->email_verified_at = now();
                $user->save();

                // Assign role if possible (assuming 'User' or 'Customer' role exists, checking existing roles)
                // For now, we will just login the user.
                
                Auth::login($user);
                $userId = $user->id;
            }

            // Generate unique order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Get scout info from session if available
            $scoutInfo = session()->get('scout_info', []);

            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'address2' => $request->address2,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country ?? 'Bangladesh',
                'notes' => $request->notes,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $shipping,
                'tax' => 0,
                'total' => $total,
                'coupon_code' => session()->get('coupon_code'),
                'status' => 'pending',
                'scout_full_name' => $scoutInfo['scout_full_name'] ?? null,
                'scout_bs_id' => $scoutInfo['scout_bs_id'] ?? null,
                'scout_unit_name' => $scoutInfo['scout_unit_name'] ?? null,
                'scout_leader_name' => $scoutInfo['scout_leader_name'] ?? null,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'] ?? null,
                    'variant_id' => $item['options']['variant_id'] ?? null,
                    'product_name' => $item['name'],
                    'product_sku' => $item['options']['sku'] ?? null,
                    'variant_name' => $item['options']['variant'] ?? null,
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty'],
                    'options' => $item['options'] ?? null,
                ]);

                // Update stock: decrement variant (if present) and product
                $qty = (int) ($item['qty'] ?? 0);
                if ($qty > 0) {
                    $pid = $item['id'] ?? null;
                    $vid = $item['options']['variant_id'] ?? null;
                    if ($vid) {
                        DB::table('product_variants')->where('id', $vid)->decrement('stock_quantity', $qty);
                    }
                    if ($pid) {
                        DB::table('products')->where('id', $pid)->decrement('stock_quantity', $qty);
                    }
                }
            }

            // Increment coupon usage if applied
            if (session()->has('coupon_code')) {
                $coupon = Coupon::where('code', session()->get('coupon_code'))->first();
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            DB::commit();

            // Notify Admins
            try {
                $admins = User::role(['Admin', 'Super Admin'])->get();
                \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewOrderNotification($order));
            } catch (\Exception $e) {
                \Log::error('Failed to send order notification: ' . $e->getMessage());
            }

            // Clear cart
            session()->forget('cart');
            session()->forget('discount');
            session()->forget('coupon_code');
            session()->forget('scout_info');

            // Store order info for success page
            session()->put('last_order', [
                'order_number' => $orderNumber,
                'total' => $total,
                'payment_method' => $request->payment_method,
            ]);

            return redirect()->route('checkout.success', ['order' => $orderNumber]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    /**
     * Display order success page
     */
    public function success($order)
    {
        $orderData = Order::where('order_number', $order)->with('items')->first();
        
        // Also get from session if order not found (for guest users before migration)
        $sessionOrder = session()->get('last_order');

        if (!$orderData && !$sessionOrder) {
            return redirect()->route('home');
        }

        return view('frontend.checkout-success', [
            'order' => $orderData,
            'orderNumber' => $order,
            'sessionOrder' => $sessionOrder,
        ]);
    }

    /**
     * Calculate shipping cost based on address
     */
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $address = $request->address;
        $subtotal = $request->subtotal;

        // Calculate shipping using helper
        $shipping = ShippingHelper::calculateShippingCost($subtotal, $address);

        return response()->json([
            'success' => true,
            'shipping' => $shipping,
            'formatted' => ShippingHelper::getShippingCostText($subtotal, ShippingHelper::isAddressInDhaka($address)),
        ]);
    }

    /**
     * Apply Scout Member Discount
     */
    public function applyScoutDiscount(Request $request)
    {
        $request->validate([
            'scout_full_name' => 'required|string|max:255',
            'scout_bs_id' => 'required|string|max:255',
            'scout_unit_name' => 'required|string|max:255',
            'scout_leader_name' => 'required|string|max:255',
        ]);

        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty!'
            ]);
        }

        $subtotal = $this->calculateSubtotal($cartItems);
        $discountPercent = \App\Models\SystemSetting::scoutDiscountPercent() ?? 10;
        $discountAmount = ($subtotal * $discountPercent) / 100;

        session()->put('discount', $discountAmount);
        session()->put('scout_info', [
            'scout_full_name' => $request->scout_full_name,
            'scout_bs_id' => $request->scout_bs_id,
            'scout_unit_name' => $request->scout_unit_name,
            'scout_leader_name' => $request->scout_leader_name,
        ]);
        session()->put('coupon_code', 'SCOUT'); // Optional, to mark as coupon used

        // Recalculate total for response
        $shipping = 0; // Can't calculate accurately without address here, but client handles it
        // Or fetch current shipping if available in session? No.
        // We return subtotal and discount, client updates total.
        
        return response()->json([
            'success' => true,
            'message' => 'Scout Discount Applied Successfully!',
            'discount' => $discountAmount,
            'total' => $subtotal - $discountAmount // Excluding shipping for now
        ]);
    }

    /**
     * Calculate cart subtotal
     */
    private function calculateSubtotal($cartItems)
    {
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += ($item['price'] ?? 0) * ($item['qty'] ?? 1);
        }
        return $subtotal;
    }
}
