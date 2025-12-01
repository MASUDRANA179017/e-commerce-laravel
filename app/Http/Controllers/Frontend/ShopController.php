<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Admin\Product\ProductCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the shop page with products
     */
    public function index(Request $request)
    {
        // Get all categories for sidebar
        $categories = collect();
        try {
            $categories = ProductCategory::whereNull('parent_id')
                ->orderBy('name')
                ->get();
        } catch (\Exception $e) {
            // If query fails, use empty collection
        }

        // Build products query
        $query = Product::where('status', 'active')
            ->with(['images', 'categories', 'brand', 'variants']);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $categorySlug = $request->category;
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('name', 'like', "%{$categorySlug}%");
            });
        }

        // Filter by search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_desc', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by brand
        if ($request->has('brand') && $request->brand) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->brand}%");
            });
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        // Paginate results
        $products = $query->paginate(12);

        return view('frontend.shop', compact('products', 'categories'));
    }
}
