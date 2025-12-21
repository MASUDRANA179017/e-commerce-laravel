<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
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
        $shipping = $subtotal >= 5000 ? 0 : 100;
        $total = $subtotal - $discount + $shipping;

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

        return view('frontend.checkout', compact('cartItems', 'subtotal', 'discount', 'shipping', 'total', 'lastOrder', 'user'));
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
            'terms' => 'required|accepted',
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
        $shipping = $subtotal >= 5000 ? 0 : 100;
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

                // Update product stock (optional)
                if (isset($item['id'])) {
                    DB::table('products')
                        ->where('id', $item['id'])
                        ->decrement('stock_quantity', $item['qty']);
                }
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');
            session()->forget('discount');
            session()->forget('coupon_code');

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
