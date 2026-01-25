<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new product review
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10|max:1000',
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'nullable|email|max:255',
        ]);

        $userId = Auth::id();
        $verifiedPurchase = false;

        // Check if user has purchased this product
        if ($userId) {
            $hasPurchased = Order::where('user_id', $userId)
                ->whereHas('items', function ($q) use ($request) {
                    $q->where('product_id', $request->product_id);
                })
                ->where('status', 'delivered')
                ->exists();
            
            $verifiedPurchase = $hasPurchased;
        }

        // Check if user already reviewed this product
        $existingReview = ProductReview::where('product_id', $request->product_id)
            ->where(function ($q) use ($userId, $request) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('reviewer_email', $request->reviewer_email);
                }
            })
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product.'
            ], 422);
        }

        $review = ProductReview::create([
            'product_id' => $request->product_id,
            'user_id' => $userId,
            'reviewer_name' => $request->reviewer_name,
            'reviewer_email' => $request->reviewer_email ?? (Auth::user()->email ?? null),
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'status' => 'pending', // Admin needs to approve
            'verified_purchase' => $verifiedPurchase,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your review! It will be visible after approval.'
        ]);
    }

    /**
     * Get reviews for a product
     */
    public function getProductReviews($productId)
    {
        $reviews = ProductReview::where('product_id', $productId)
            ->approved()
            ->with('user:id,name')
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json($reviews);
    }
}

