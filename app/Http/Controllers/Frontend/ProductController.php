<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
            ->where('status', 'active')
            ->firstOrFail();

        // Get related products from same category
        $relatedProducts = collect();
        try {
            if ($product->categories && $product->categories->count() > 0) {
                $categoryIds = $product->categories->pluck('id')->toArray();
                $relatedProducts = Product::whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('product_categories.id', $categoryIds);
                })
                ->where('id', '!=', $product->id)
                ->where('status', 'active')
                ->with(['images', 'categories', 'variants'])
                ->limit(4)
                ->get();
            }
        } catch (\Exception $e) {
            // If query fails, use empty collection
        }

        return view('frontend.product-details', compact('product', 'relatedProducts'));
    }

    /**
     * Store a product review
     */
    public function storeReview(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $product = Product::findOrFail($productId);

        // Check if product has reviews relationship
        if (method_exists($product, 'reviews')) {
            // Check if user already reviewed this product
            $existingReview = $product->reviews()
                ->where('user_id', auth()->id())
                ->first();

            if ($existingReview) {
                // Update existing review
                $existingReview->update([
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ]);
                $message = 'Your review has been updated!';
            } else {
                // Create new review
                $product->reviews()->create([
                    'user_id' => auth()->id(),
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ]);
                $message = 'Thank you for your review!';
            }
        } else {
            $message = 'Reviews feature is not available yet.';
        }

        return back()->with('success', $message);
    }
}
