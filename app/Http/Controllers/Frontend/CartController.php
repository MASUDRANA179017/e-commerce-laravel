<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
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

        // Convert cart items to collection for easier handling with product details
        $cartItems = collect($cartItems)->map(function ($item, $rowId) {
            $product = \App\Models\Product::find($item['id']);
            return (object) array_merge($item, [
                'rowId' => $rowId,
                'options' => (object) ($item['options'] ?? []),
                'price_range' => $product ? $product->formatted_price_range : null,
                'original_price' => $item['original_price'] ?? ($product ? $product->price : ($item['price'] ?? 0)),
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

        // Get product with image using Eloquent
        $product = \App\Models\Product::with('coverImage')->find($request->product_id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $quantity = $request->quantity ?? 1;
        $cart = session()->get('cart', []);
        $variantId = $request->variant_id ?? null;
        $rowId = 'product_' . $product->id . ($variantId ? '_v_' . $variantId : '');

        // Determine price (variant-aware with purchase sell price fallback)
        $price = $product->effective_price;
        
        // Fallback: If price is 0, try to find the latest purchase price for this product
        if ($price <= 0) {
            $lastPurchaseItem = \Illuminate\Support\Facades\DB::table('purchase_items')
                ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                ->where('purchase_items.product_id', $product->id)
                ->where('purchases.status', 'received')
                ->orderByDesc('purchases.purchase_date')
                ->select('purchase_items.sell_price')
                ->first();
                
            if ($lastPurchaseItem && $lastPurchaseItem->sell_price > 0) {
                $price = $lastPurchaseItem->sell_price;
            }
        }

        $variantLabel = $request->variant ?? null;
        $variantSku = $product->sku ?? null;
        if ($variantId) {
            $v = \App\Models\ProductVariant::with(['options.attribute', 'options.term', 'product'])->find($variantId);
            if ($v) {
                $variantSku = $v->sku ?? $variantSku;
                $variantLabel = $v->options->map(function ($opt) {
                    $an = $opt->attribute->name ?? 'Option';
                    $tn = $opt->term->name ?? '';
                    return $an . ': ' . $tn;
                })->join(' | ');

                $price = $v->effective_price;
                
                // Fallback for variant: if 0, try specific variant purchase, then product purchase
                if ($price <= 0) {
                     $vLastPurchase = \Illuminate\Support\Facades\DB::table('purchase_items')
                        ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                        ->where('purchase_items.variant_id', $v->id)
                        ->where('purchases.status', 'received')
                        ->orderByDesc('purchases.purchase_date')
                        ->select('purchase_items.sell_price')
                        ->first();
                        
                     if ($vLastPurchase && $vLastPurchase->sell_price > 0) {
                         $price = $vLastPurchase->sell_price;
                     } else {
                         // If variant has no price, fall back to product base price (already calculated above)
                         // But we need to recalculate if we overwrote $price above
                         $baseProductPrice = $product->effective_price;
                         if ($baseProductPrice <= 0 && isset($lastPurchaseItem) && $lastPurchaseItem->sell_price > 0) {
                             $baseProductPrice = $lastPurchaseItem->sell_price;
                         }
                         $price = $baseProductPrice;
                     }
                }
            }
        }

        $originalPrice = $price;

        // Check for active flash sale and override price
        if ($product->active_flash_sale) {
            $flashSale = $product->active_flash_sale;
            $pivot = $flashSale->pivot;
            // Check stock limit
            if ($pivot->stock_limit === null || $pivot->sold_count < $pivot->stock_limit) {
                if ($pivot->flash_price !== null && $pivot->flash_price > 0) {
                    $price = $pivot->flash_price;
                } elseif ($flashSale->discount_percent > 0) {
                     // Fallback calculation if pivot price is missing
                     $price = $price - ($price * $flashSale->discount_percent / 100);
                     $price = max(0, $price);
                }
            }
        }

        // Check if product already in cart
        if (isset($cart[$rowId])) {
            $cart[$rowId]['qty'] += $quantity;
        } else {
            $imagePath = $product->coverImage ? $product->coverImage->path : null;

            $cart[$rowId] = [
                'id' => $product->id,
                'name' => $product->title,
                'price' => $price ?? 0,
                'original_price' => $originalPrice ?? 0,
                'qty' => $quantity,
                'options' => [
                    'image' => $imagePath,
                    'slug' => $product->slug ?? $product->id,
                    'variant' => $variantLabel,
                    'sku' => $variantSku,
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
        session()->forget('coupon_id');

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

        $code = strtoupper($request->coupon_code);
        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);

        // Special check for Scout Discount
        if ($code === 'SCOUT') {
            $discountPercent = 10;
            $discount = round(($subtotal * $discountPercent) / 100, 2);
            session()->put('discount', $discount);
            session()->put('coupon_code', 'SCOUT');
            session()->put('coupon_id', null); // No ID for special scout discount

            $shipping = $subtotal >= 5000 ? 0 : 100;
            $message = "Scout Discount applied! 10% off";

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'discount' => $discount,
                    'total' => $subtotal - $discount + $shipping,
                ]);
            }
            return back()->with('success', "Scout Discount applied! You saved ৳" . number_format($discount, 2));
        }

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return $this->couponError($request, 'Invalid coupon code!');
        }

        if (!$coupon->is_active) {
            return $this->couponError($request, 'This coupon is inactive.');
        }

        if ($coupon->expiry_date && $coupon->expiry_date->isPast()) {
            return $this->couponError($request, 'This coupon has expired.');
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return $this->couponError($request, 'This coupon usage limit has been reached.');
        }

        if ($coupon->min_purchase !== null && $subtotal < $coupon->min_purchase) {
            return $this->couponError($request, 'Minimum purchase not met for this coupon.');
        }

        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = round(($subtotal * $coupon->value) / 100, 2);
        } else { // fixed
            $discount = min(round($coupon->value, 2), $subtotal);
        }

        session()->put('discount', $discount);
        session()->put('coupon_code', $coupon->code);
        session()->put('coupon_id', $coupon->id);

        $shipping = $subtotal >= 5000 ? 0 : 100;
        $message = $coupon->type === 'percentage'
            ? "Coupon applied! {$coupon->value}% off"
            : "Coupon applied! ৳" . number_format($coupon->value, 2) . " off";

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'discount' => $discount,
                'total' => $subtotal - $discount + $shipping,
            ]);
        }

        return back()->with('success', "Coupon applied! You saved ৳" . number_format($discount, 2));
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

    private function couponError(Request $request, string $message)
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 400);
        }
        return back()->with('error', $message);
    }
}
