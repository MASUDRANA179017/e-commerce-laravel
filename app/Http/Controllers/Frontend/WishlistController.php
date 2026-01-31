<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    /**
     * Display the wishlist page
     */
    public function index()
    {
        $wishlistItems = session()->get('wishlist', []);

        // Get product details for wishlist items
        $productIds = array_keys($wishlistItems);
        $products = collect();

        if (!empty($productIds)) {
            $products = Product::whereIn('id', $productIds)
                ->with(['images', 'brand', 'variants'])
                ->get();
        }

        return view('frontend.wishlist', compact('products'));
    }

    /**
     * Add item to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->product_id;
        $wishlist = session()->get('wishlist', []);

        // Toggle wishlist item
        if (isset($wishlist[$productId])) {
            // Remove from wishlist
            unset($wishlist[$productId]);
            session()->put('wishlist', $wishlist);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'added' => false,
                    'message' => 'Product removed from wishlist!',
                    'wishlistCount' => count($wishlist),
                ]);
            }

            return back()->with('success', 'Product removed from wishlist!');
        }

        // Add to wishlist
        $wishlist[$productId] = [
            'id' => $productId,
            'added_at' => now()->toDateTimeString(),
        ];

        session()->put('wishlist', $wishlist);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'added' => true,
                'message' => 'Product added to wishlist!',
                'wishlistCount' => count($wishlist),
            ]);
        }

        return back()->with('success', 'Product added to wishlist!');
    }

    /**
     * Remove item from wishlist
     */
    public function remove(Request $request, $productId)
    {
        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$productId])) {
            unset($wishlist[$productId]);
            session()->put('wishlist', $wishlist);
        }

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist!',
                'wishlistCount' => count($wishlist),
            ]);
        }

        return back()->with('success', 'Product removed from wishlist!');
    }

    /**
     * Clear all items from wishlist
     */
    public function clear()
    {
        session()->forget('wishlist');

        return back()->with('success', 'Wishlist cleared!');
    }

    /**
     * Get wishlist count (for AJAX header update)
     */
    public function count()
    {
        $wishlist = session()->get('wishlist', []);
        return response()->json([
            'count' => count($wishlist),
        ]);
    }

    /**
     * Move item from wishlist to cart
     */
    public function moveToCart(Request $request, $productId)
    {
        // Get product using Eloquent
        $product = \App\Models\Product::with('coverImage')->find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Add to cart
        $cart = session()->get('cart', []);
        $rowId = 'product_' . $product->id;

        // Determine price
        $price = $product->effective_price;

        // Check for active flash sale
        if ($product->active_flash_sale) {
             $flashSale = $product->active_flash_sale;
             $pivot = $flashSale->pivot;
             if ($pivot->stock_limit === null || $pivot->sold_count < $pivot->stock_limit) {
                 if ($pivot->flash_price !== null && $pivot->flash_price > 0) {
                     $price = $pivot->flash_price;
                 } elseif ($flashSale->discount_percent > 0) {
                      // Fallback calculation
                      $price = $product->price - ($product->price * $flashSale->discount_percent / 100);
                      $price = max(0, $price);
                 }
             }
        }

        if (isset($cart[$rowId])) {
            $cart[$rowId]['qty'] += 1;
        } else {
            $imagePath = $product->coverImage ? $product->coverImage->path : null;

            $cart[$rowId] = [
                'id' => $product->id,
                'name' => $product->title,
                'price' => $price ?? 0,
                'original_price' => $product->price ?? 0,
                'qty' => 1,
                'options' => [
                    'image' => $imagePath,
                    'slug' => $product->slug ?? $product->id,
                    'variant' => null,
                    'sku' => $product->sku ?? null,
                ]
            ];
        }

        session()->put('cart', $cart);

        // Remove from wishlist
        $wishlist = session()->get('wishlist', []);
        if (isset($wishlist[$productId])) {
            unset($wishlist[$productId]);
            session()->put('wishlist', $wishlist);
        }

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product moved to cart!',
                'cartCount' => array_sum(array_column($cart, 'qty')),
                'wishlistCount' => count($wishlist),
            ]);
        }

        return back()->with('success', 'Product moved to cart!');
    }
}

