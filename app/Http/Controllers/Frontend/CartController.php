<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $shipping = $subtotal >= 5000 ? 0 : 100; // Free shipping over ৳5000
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
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'sometimes|integer|min:1',
            ]);

        // Get product with image
        $product = DB::table('products')
            ->leftJoin('product_images', function ($join) {
                $join->on('products.id', '=', 'product_images.product_id')
                    ->where('product_images.is_cover', true);
            })
            ->where('products.id', $request->product_id)
            ->select('products.*', 'product_images.path as cover_image')
            ->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $quantity = $request->quantity ?? 1;
        $cart = session()->get('cart', []);
        $variantId = $request->variant_id ?? null;
        $rowId = 'product_' . $product->id . ($variantId ? '_v_' . $variantId : '');

        // Determine price
        $price = $product->sale_price && $product->sale_price < $product->price 
            ? $product->sale_price 
            : $product->price;

        $variantLabel = $request->variant ?? null;
        if ($variantId) {
            $v = \App\Models\ProductVariant::with(['options.attribute', 'options.term'])->find($variantId);
            if ($v) {
                $variantLabel = $v->options->map(function ($opt) {
                    $an = $opt->attribute->name ?? 'Option';
                    $tn = $opt->term->name ?? '';
                    return $an . ': ' . $tn;
                })->join(' | ');
            }
        }

        // Check if product already in cart
        if (isset($cart[$rowId])) {
            $cart[$rowId]['qty'] += $quantity;
        } else {
            $cart[$rowId] = [
                'id' => $product->id,
                'name' => $product->title,
                'price' => $price ?? 0,
                'original_price' => $product->price ?? 0,
                'qty' => $quantity,
                'options' => [
                    'image' => $product->cover_image ?? null,
                    'slug' => $product->slug ?? $product->id,
                    'variant' => $variantLabel,
                    'sku' => $product->sku ?? null,
                ]
            ];
        }

        session()->put('cart', $cart);

        // Check if buy now
        if ($request->buy_now) {
            return redirect()->route('checkout.index');
        }

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cartCount' => array_sum(array_column($cart, 'qty')),
                'cartTotal' => $this->calculateSubtotal($cart),
                'addedItem' => array_merge($cart[$rowId], ['rowId' => $rowId]),
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()['product_id'][0] ?? 'Validation failed',
            ], 422);
        }
        throw $e;
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Add to cart error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
        throw $e;
    }
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

        $subtotal = $this->calculateSubtotal($cart);
        $discount = session()->get('discount', 0);
        $shipping = $subtotal >= 5000 ? 0 : 100;
        $total = $subtotal - $discount + $shipping;

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'cartCount' => array_sum(array_column($cart, 'qty')),
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'itemTotal' => isset($cart[$rowId]) ? $cart[$rowId]['price'] * $cart[$rowId]['qty'] : 0,
            ]);
        }

        return back()->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request, $rowId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$rowId])) {
            unset($cart[$rowId]);
            session()->put('cart', $cart);
        }

        if ($request->ajax()) {
            $subtotal = $this->calculateSubtotal($cart);
            $discount = session()->get('discount', 0);
            $shipping = $subtotal >= 5000 ? 0 : 100;
            $total = $subtotal - $discount + $shipping;

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cartCount' => array_sum(array_column($cart, 'qty')),
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
            ]);
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

        // Simple coupon logic - you can extend this with database lookup
        $validCoupons = [
            'SAVE10' => 10,
            'SAVE20' => 20,
            'WELCOME' => 15,
            'FIRST50' => 50,
        ];

        $code = strtoupper($request->coupon_code);

        if (isset($validCoupons[$code])) {
            $cart = session()->get('cart', []);
            $subtotal = $this->calculateSubtotal($cart);
            $discountPercent = $validCoupons[$code];
            $discount = ($subtotal * $discountPercent) / 100;

            session()->put('discount', $discount);
            session()->put('coupon_code', $code);

            if ($request->ajax()) {
                $shipping = $subtotal >= 5000 ? 0 : 100;
                return response()->json([
                    'success' => true,
                    'message' => "Coupon applied! {$discountPercent}% off",
                    'discount' => $discount,
                    'total' => $subtotal - $discount + $shipping,
                ]);
            }

            return back()->with('success', "Coupon applied! You saved ৳{$discount}");
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code!',
            ], 400);
        }

        return back()->with('error', 'Invalid coupon code!');
    }

    /**
     * Get cart count (for AJAX header update)
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        return response()->json([
            'count' => array_sum(array_column($cart, 'qty')),
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
