<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Admin\Product\ProductCategory;
use App\Models\Admin\Brand\Brand;
use App\Models\FlashSale;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Get categories with active product counts
        $categories = collect();
        try {
            $categories = ProductCategory::whereNull('parent_id')
                ->withCount([
                    'products' => function ($query) {
                        $query->where('status', 'Active');
                    }
                ])
                ->orderBy('order')
                ->limit(8)
                ->get();
        } catch (\Exception $e) {
            // Fallback: manually count products
            try {
                $categories = ProductCategory::whereNull('parent_id')
                    ->orderBy('order')
                    ->limit(8)
                    ->get()
                    ->map(function ($category) {
                        $category->products_count = DB::table('product_category_map')
                            ->join('products', 'product_category_map.product_id', '=', 'products.id')
                            ->where('product_category_map.category_id', $category->id)
                            ->where('products.status', 'Active')
                            ->count();
                        return $category;
                    });
            } catch (\Exception $e2) {
                // Use empty collection
            }
        }

        // Get featured products
        $featuredProducts = collect();
        try {
            $featuredProducts = Product::where('status', 'Active')
                ->where('featured', true)
                ->with(['images', 'brand'])
                ->latest()
                ->limit(8)
                ->get();
        } catch (\Exception $e) {
            // Try alternative query
            try {
                $featuredProducts = DB::table('products')
                    ->leftJoin('product_images', function ($join) {
                        $join->on('products.id', '=', 'product_images.product_id')
                            ->where('product_images.is_cover', true);
                    })
                    ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                    ->where('products.status', 'Active')
                    ->where('products.featured', true)
                    ->select(
                        'products.*',
                        'product_images.path as cover_image',
                        'brands.name as brand_name'
                    )
                    ->orderBy('products.created_at', 'desc')
                    ->limit(8)
                    ->get();
            } catch (\Exception $e2) {
                // Use empty collection
            }
        }

        // Get new arrivals (products created in last 30 days)
        $newArrivals = collect();
        try {
            $newArrivals = Product::where('status', 'Active')
                ->where('created_at', '>=', now()->subDays(30))
                ->with(['images', 'brand'])
                ->latest()
                ->limit(8)
                ->get();
        } catch (\Exception $e) {
            // Try alternative query
            try {
                $newArrivals = DB::table('products')
                    ->leftJoin('product_images', function ($join) {
                        $join->on('products.id', '=', 'product_images.product_id')
                            ->where('product_images.is_cover', true);
                    })
                    ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                    ->where('products.status', 'Active')
                    ->where('products.created_at', '>=', now()->subDays(30))
                    ->select(
                        'products.*',
                        'product_images.path as cover_image',
                        'brands.name as brand_name'
                    )
                    ->orderBy('products.created_at', 'desc')
                    ->limit(8)
                    ->get();
            } catch (\Exception $e2) {
                // Use empty collection
            }
        }

        // Get best selling / popular products (for now, just active products)
        $bestSellers = collect();
        try {
            $bestSellers = Product::where('status', 'Active')
                ->with(['images', 'brand'])
                ->inRandomOrder()
                ->limit(8)
                ->get();
        } catch (\Exception $e) {
            // Use empty collection
        }

        // Get brands for display
        $brands = collect();
        try {
            $brands = Brand::where('status', 'active')
                ->orderBy('name')
                ->limit(12)
                ->get();
        } catch (\Exception $e) {
            // Use empty collection
        }

        // Get active or upcoming flash sale
        $flashSale = null;
        $flashSaleProducts = collect();
        try {
            // Update statuses first
            $now = now();
            FlashSale::where('status', 'scheduled')
                ->where('start_time', '<=', $now)
                ->where('end_time', '>=', $now)
                ->update(['status' => 'active']);
            FlashSale::where('status', 'active')
                ->where('end_time', '<', $now)
                ->update(['status' => 'ended']);

            // Prefer an active flash sale; if none, use the next scheduled one
            $flashSale = FlashSale::whereIn('status', ['active', 'scheduled'])
                ->where('end_time', '>=', $now)
                ->orderByRaw("FIELD(status, 'active', 'scheduled', 'draft', 'ended')")
                ->orderByDesc('is_featured')
                ->orderBy('start_time')
                ->first();

            if ($flashSale) {
                $flashSaleProducts = $flashSale->products()
                    ->whereIn('status', ['active', 'Active'])
                    ->with('images')
                    ->limit(8)
                    ->get();
            }
        } catch (\Exception $e) {
            // Flash sale table might not exist yet
        }

        // Get latest 3 published blogs
        $latestBlogs = collect();
        try {
            $latestBlogs = Blog::published()
                ->with('author')
                ->latest()
                ->limit(3)
                ->get();
        } catch (\Exception $e) {
            // Blog table might not exist yet or error occurred
        }

        return view('frontend.home', compact(
            'categories',
            'featuredProducts',
            'newArrivals',
            'bestSellers',
            'brands',
            'flashSale',
            'flashSaleProducts',
            'latestBlogs'
        ));
    }
}
