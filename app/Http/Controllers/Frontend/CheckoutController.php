<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $shipping = $subtotal >= 50 ? 0 : 5;
        $total = $subtotal - $discount + $shipping;

        // Convert cart items to collection
        $cartItems = collect($cartItems)->map(function ($item, $rowId) {
            return (object) array_merge($item, [
                'rowId' => $rowId,
                'options' => (object) ($item['options'] ?? [])
            ]);
        });

        return view('frontend.checkout', compact('cartItems', 'subtotal', 'discount', 'shipping', 'total'));
    }

    /**
     * Process the checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer,card,bkash',
            'terms' => 'required|accepted',
        ]);

        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = $this->calculateSubtotal($cartItems);
        $discount = session()->get('discount', 0);
        $shipping = $subtotal >= 50 ? 0 : 5;
        $total = $subtotal - $discount + $shipping;

        // Generate order number
        $orderNumber = 'ORD-' . strtoupper(Str::random(8));

        // Here you would typically:
        // 1. Create the order in database
        // 2. Create order items
        // 3. Process payment (if applicable)
        // 4. Send confirmation email
        // 5. Clear cart

        // For now, we'll just create a simple order record
        // You can extend this with your Order model

        /*
        $order = Order::create([
            'user_id' => auth()->id(),
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
            'notes' => $request->notes,
            'payment_method' => $request->payment_method,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['qty'],
                'subtotal' => $item['price'] * $item['qty'],
            ]);
        }
        */

        // Clear cart
        session()->forget('cart');
        session()->forget('discount');
        session()->forget('coupon_code');

        // Store order number in session for success page
        session()->put('last_order_number', $orderNumber);

        return redirect()->route('checkout.success', ['order' => $orderNumber]);
    }

    /**
     * Display order success page
     */
    public function success($order)
    {
        $orderNumber = $order;

        // You would typically fetch the order from database here
        // $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return view('frontend.checkout-success', compact('orderNumber'));
    }

    /**
     * Calculate cart subtotal
     */
    private function calculateSubtotal($cartItems)
    {
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        return $subtotal;
    }
}

