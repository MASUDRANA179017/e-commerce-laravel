<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Admin\Product\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Get categories for display
        $categories = collect();
        try {
            $categories = ProductCategory::whereNull('parent_id')
                ->where('show_on_menu', true)
                ->orderBy('order')
                ->limit(8)
                ->get();
        } catch (\Exception $e) {
            // If query fails, use empty collection
        }

        // Get featured products
        $featuredProducts = collect();
        try {
            $featuredProducts = Product::where('status', 'active')
                ->where('featured', true)
                ->with(['images', 'categories', 'brand', 'variants'])
                ->latest()
                ->limit(8)
                ->get();
        } catch (\Exception $e) {
            // If query fails, use empty collection
        }

        // Get new arrivals (products created in last 30 days)
        $newArrivals = collect();
        try {
            $newArrivals = Product::where('status', 'active')
                ->where('created_at', '>=', now()->subDays(30))
                ->with(['images', 'categories', 'brand', 'variants'])
                ->latest()
                ->limit(8)
                ->get();
        } catch (\Exception $e) {
            // If query fails, use empty collection
        }

        return view('frontend.home', compact('categories', 'featuredProducts', 'newArrivals'));
    }
}
