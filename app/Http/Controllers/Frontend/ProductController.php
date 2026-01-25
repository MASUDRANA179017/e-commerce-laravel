<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display product details
     */
    public function show($slug)
    {
        // Find product by slug or ID
        $product = Product::where('slug', $slug)
            ->orWhere('id', $slug)
            ->with(['images', 'categories', 'brand', 'variants'])
            ->where('status', 'Active')
            ->first();

        // If not found with 'Active', try 'active' (case insensitive)
        if (!$product) {
            $product = Product::where(function($q) use ($slug) {
                    $q->where('slug', $slug)->orWhere('id', $slug);
                })
                ->whereRaw('LOWER(status) = ?', ['active'])
                ->with(['images', 'categories', 'brand', 'variants'])
                ->first();
        }

        // If still not found, abort
        if (!$product) {
            abort(404, 'Product not found');
        }

        $purchaseMin = null;
        $purchaseMax = null;
        try {
            if ($product->variants && $product->variants->count() > 0) {
                // For variants, we only fetch purchase price range if we don't have variant-specific manual prices?
                // Or maybe we should check if the main product has a price?
                // For now, let's keep variant logic as is, or maybe apply similar logic if needed.
                // But usually variants are complex. Let's focus on simple products first which is the most common issue.
                
                $vids = $product->variants->pluck('id')->all();
                $range = \Illuminate\Support\Facades\DB::table('purchase_items')
                    ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                    ->whereIn('purchase_items.variant_id', $vids)
                    ->where('purchases.status', 'received')
                    ->selectRaw('MIN(purchase_items.sell_price) AS min_price, MAX(purchase_items.sell_price) AS max_price')
                    ->first();
                if ($range) {
                    $purchaseMin = $range->min_price !== null ? (float) $range->min_price : null;
                    $purchaseMax = $range->max_price !== null ? (float) $range->max_price : null;
                }
            } else {
                // For simple products, ONLY fetch purchase price if manual price is not set
                $manualPrice = $product->sale_price > 0 ? $product->sale_price : $product->price;
                
                if ($manualPrice <= 0) {
                    $range = \Illuminate\Support\Facades\DB::table('purchase_items')
                        ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                        ->where('purchase_items.product_id', $product->id)
                        ->whereNull('purchase_items.variant_id')
                        ->where('purchases.status', 'received')
                        ->selectRaw('MIN(purchase_items.sell_price) AS min_price, MAX(purchase_items.sell_price) AS max_price')
                        ->first();
                    if ($range) {
                        $purchaseMin = $range->min_price !== null ? (float) $range->min_price : null;
                        $purchaseMax = $range->max_price !== null ? (float) $range->max_price : null;
                    }
                }
            }
        } catch (\Exception $e) {
        }

        // Get related products from same category
        $relatedProducts = collect();
        try {
            if ($product->categories && $product->categories->count() > 0) {
                $categoryIds = $product->categories->pluck('id')->toArray();
                $relatedProducts = Product::whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('product_categories.id', $categoryIds);
                })
                ->where('id', '!=', $product->id)
                ->where(function($q) {
                    $q->where('status', 'Active')
                      ->orWhereRaw('LOWER(status) = ?', ['active']);
                })
                ->with(['images', 'brand'])
                ->inRandomOrder()
                ->limit(4)
                ->get();
            }

            // If no related products from category, get random products
            if ($relatedProducts->isEmpty()) {
                $relatedProducts = Product::where('id', '!=', $product->id)
                    ->where(function($q) {
                        $q->where('status', 'Active')
                          ->orWhereRaw('LOWER(status) = ?', ['active']);
                    })
                    ->with(['images', 'brand'])
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();
            }
        } catch (\Exception $e) {
            // If query fails, use empty collection
        }

        return view('frontend.product-details', compact('product', 'relatedProducts', 'purchaseMin', 'purchaseMax'));
    }

    public function variants($id)
    {
        $variants = ProductVariant::with(['options.attribute', 'options.term', 'product'])
            ->where('product_id', $id)
            ->get()
            ->map(function ($variant) {
                $name = $variant->options->map(function ($opt) {
                    $an = $opt->attribute->name ?? 'Option';
                    $tn = $opt->term->name ?? '';
                    return $an . ': ' . $tn;
                })->join(' | ');
                $base = $variant->price;
                if ($base === null || $base <= 0) {
                    $purchaseSell = \Illuminate\Support\Facades\DB::table('purchase_items')
                        ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                        ->where('purchase_items.variant_id', $variant->id)
                        ->where('purchases.status', 'received')
                        ->orderByDesc('purchases.purchase_date')
                        ->value('purchase_items.sell_price');
                    $base = $purchaseSell ?? ($variant->product->sale_price ?? $variant->product->price);
                }
                return [
                    'id' => $variant->id,
                    'name' => $name ?: 'Default',
                    'sku' => $variant->sku,
                    'price' => $base,
                ];
            });
        return response()->json(['variants' => $variants]);
    }

    public function quickView($id)
    {
        $product = Product::with(['images', 'categories', 'brand', 'variants.options.attribute', 'variants.options.term'])
            ->where('id', $id)
            ->firstOrFail();

        $purchaseMin = null;
        $purchaseMax = null;
        try {
            if ($product->variants && $product->variants->count() > 0) {
                $vids = $product->variants->pluck('id')->all();
                $range = \Illuminate\Support\Facades\DB::table('purchase_items')
                    ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                    ->whereIn('purchase_items.variant_id', $vids)
                    ->where('purchases.status', 'received')
                    ->selectRaw('MIN(purchase_items.sell_price) AS min_price, MAX(purchase_items.sell_price) AS max_price')
                    ->first();
                if ($range) {
                    $purchaseMin = $range->min_price !== null ? (float) $range->min_price : null;
                    $purchaseMax = $range->max_price !== null ? (float) $range->max_price : null;
                }
            } else {
                $manualPrice = $product->sale_price > 0 ? $product->sale_price : $product->price;
                if ($manualPrice <= 0) {
                    $range = \Illuminate\Support\Facades\DB::table('purchase_items')
                        ->join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
                        ->where('purchase_items.product_id', $product->id)
                        ->whereNull('purchase_items.variant_id')
                        ->where('purchases.status', 'received')
                        ->selectRaw('MIN(purchase_items.sell_price) AS min_price, MAX(purchase_items.sell_price) AS max_price')
                        ->first();
                    if ($range) {
                        $purchaseMin = $range->min_price !== null ? (float) $range->min_price : null;
                        $purchaseMax = $range->max_price !== null ? (float) $range->max_price : null;
                    }
                }
            }
        } catch (\Exception $e) {
        }

        return view('frontend.partials.quick-view-content', compact('product', 'purchaseMin', 'purchaseMax'));
    }

    /**
     * Store a product review
     */
    public function storeReview(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $product = Product::findOrFail($productId);
        $user = auth()->user();

        // Check if user already reviewed this product
        $existingReview = \App\Models\ProductReview::where('product_id', $productId)
            ->where('user_id', $user->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        // Check if user purchased this product (verified purchase)
        $verifiedPurchase = \App\Models\Order::where('user_id', $user->id)
            ->whereHas('items', function ($q) use ($productId) {
                $q->where('product_id', $productId);
            })
            ->where('status', 'delivered')
            ->exists();

        \App\Models\ProductReview::create([
            'product_id' => $productId,
            'user_id' => $user->id,
            'reviewer_name' => $user->name,
            'reviewer_email' => $user->email,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'status' => 'pending',
            'verified_purchase' => $verifiedPurchase,
        ]);

        return back()->with('success', 'Thank you for your review! It will be visible after approval.');
    }
}
