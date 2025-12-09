<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::published()->with('author')->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->paginate(12);

        // Get categories for filter
        $categories = Blog::published()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('frontend.blog.index', compact('blogs', 'categories'));
    }

    public function show($slug)
    {
        $blog = Blog::published()
            ->with('author')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $blog->incrementViews();

        // Get related blogs
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where(function ($query) use ($blog) {
                if ($blog->category) {
                    $query->where('category', $blog->category);
                }
            })
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.blog.show', compact('blog', 'relatedBlogs'));
    }
}
