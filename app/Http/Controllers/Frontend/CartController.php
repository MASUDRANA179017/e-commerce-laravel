<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cartItems);
        $discount = session()->get('discount', 0);
        $shipping = $subtotal >= 50 ? 0 : 5; // Free shipping over $50
        $total = $subtotal - $discount + $shipping;

        // Convert cart items to collection for easier handling
        $cartItems = collect($cartItems)->map(function ($item, $rowId) {
            return (object) array_merge($item, [
                'rowId' => $rowId,
                'options' => (object) ($item['options'] ?? [])
            ]);
        });

        return view('frontend.cart', compact('cartItems', 'subtotal', 'discount', 'shipping', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        $product = Product::with('images')->findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        $cart = session()->get('cart', []);
        $rowId = 'product_' . $product->id;

        // Check if product already in cart
        if (isset($cart[$rowId])) {
            $cart[$rowId]['qty'] += $quantity;
        } else {
            $cart[$rowId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'qty' => $quantity,
                'options' => [
                    'image' => $product->images->first()->image ?? 'product/default.png',
                    'slug' => $product->slug ?? $product->id,
                    'variant' => $request->variant ?? null,
                ]
            ];
        }

        session()->put('cart', $cart);

        // Check if buy now
        if ($request->buy_now) {
            return redirect()->route('checkout.index');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cartCount' => count($cart),
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $rowId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$rowId])) {
            $cart[$rowId]['qty'] = $request->quantity;
            session()->put('cart', $cart);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
            ]);
        }

        return back()->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart
     */
    public function remove($rowId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$rowId])) {
            unset($cart[$rowId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed from cart!');
    }

    /**
     * Clear all items from cart
     */
    public function clear()
    {
        session()->forget('cart');
        session()->forget('discount');
        session()->forget('coupon_code');

        return back()->with('success', 'Cart cleared!');
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        // Simple coupon logic - you can extend this
        $validCoupons = [
            'SAVE10' => 10,
            'SAVE20' => 20,
            'WELCOME' => 15,
        ];

        $code = strtoupper($request->coupon_code);

        if (isset($validCoupons[$code])) {
            $cart = session()->get('cart', []);
            $subtotal = $this->calculateSubtotal($cart);
            $discount = ($subtotal * $validCoupons[$code]) / 100;

            session()->put('discount', $discount);
            session()->put('coupon_code', $code);

            return back()->with('success', "Coupon applied! You saved \${$discount}");
        }

        return back()->with('error', 'Invalid coupon code!');
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

