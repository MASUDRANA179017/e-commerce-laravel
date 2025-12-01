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
            $message = 'Thank you for your feedback! Reviews feature coming soon.';
        }

        return back()->with('success', $message);
    }
}
