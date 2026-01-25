<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display reviews list
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = ProductReview::with(['product:id,title', 'user:id,name'])
            ->orderByDesc('created_at');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $reviews = $query->paginate(20);
        
        $counts = [
            'all' => ProductReview::count(),
            'pending' => ProductReview::pending()->count(),
            'approved' => ProductReview::approved()->count(),
            'featured' => ProductReview::featured()->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'counts', 'status'));
    }

    /**
     * Approve a review
     */
    public function approve($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->update(['status' => 'approved']);

        return response()->json(['success' => true, 'message' => 'Review approved successfully']);
    }

    /**
     * Reject a review
     */
    public function reject($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->update(['status' => 'rejected']);

        return response()->json(['success' => true, 'message' => 'Review rejected']);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->update(['featured' => !$review->featured]);

        return response()->json([
            'success' => true,
            'featured' => $review->featured,
            'message' => $review->featured ? 'Review added to testimonials' : 'Review removed from testimonials'
        ]);
    }

    /**
     * Delete a review
     */
    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->delete();

        return response()->json(['success' => true, 'message' => 'Review deleted']);
    }

    /**
     * Update reviewer image (for testimonials)
     */
    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'reviewer_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $review = ProductReview::findOrFail($id);

        if ($request->hasFile('reviewer_image')) {
            // Delete old image if exists
            if ($review->reviewer_image) {
                deleteFile($review->reviewer_image);
            }
            $review->reviewer_image = uploadFile($request->file('reviewer_image'), 'reviews');
            $review->save();
        }

        return response()->json([
            'success' => true,
            'image_url' => asset('storage/' . $review->reviewer_image),
            'message' => 'Image updated successfully'
        ]);
    }
}

