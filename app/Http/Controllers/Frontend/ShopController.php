<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Admin\Product\ProductCategory;
use App\Models\Admin\Brand\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * Display the shop page with products
     */
    public function index(Request $request)
    {
        // Get total count of all active products
        $totalProducts = Product::where('status', 'Active')->count();

        // Get all categories with active product counts using raw query for reliability
        $categories = collect();
        try {
            $categories = ProductCategory::whereNull('parent_id')
                ->orderBy('name')
                ->get()
                ->map(function ($category) {
                    // Count products using raw query for reliability
                    $category->products_count = DB::table('product_category_map')
                        ->join('products', 'product_category_map.product_id', '=', 'products.id')
                        ->where('product_category_map.category_id', $category->id)
                        ->where('products.status', 'Active')
                        ->count();
                    
                    // Generate slug if not exists
                    if (empty($category->slug)) {
                        $category->slug = \Str::slug($category->name);
                    }
                    
                    return $category;
                });
        } catch (\Exception $e) {
            // Use empty collection
        }

        // Get brands for filter with product counts
        $brands = collect();
        try {
            $brands = Brand::where('status', 'active')
                ->orderBy('name')
                ->get()
                ->map(function ($brand) {
                    $brand->products_count = Product::where('status', 'Active')
                        ->where('brand_id', $brand->id)
                        ->count();
                    
                    if (empty($brand->slug)) {
                        $brand->slug = \Str::slug($brand->name);
                    }
                    
                    return $brand;
                })
                ->filter(function ($brand) {
                    return $brand->products_count > 0;
                });
        } catch (\Exception $e) {
            // Use empty collection
        }

        // Build products query
        $query = Product::where('status', 'Active')
            ->with(['images', 'brand', 'categories']);

        // Filter by category
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug)
                    ->orWhere('name', $categorySlug)
                    ->orWhereRaw("LOWER(REPLACE(name, ' ', '-')) = ?", [strtolower($categorySlug)]);
            });
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_desc', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $brandSlug = $request->brand;
            $query->whereHas('brand', function ($q) use ($brandSlug) {
                $q->where('slug', $brandSlug)
                    ->orWhere('name', 'like', "%{$brandSlug}%");
            });
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('price', '>=', $request->min_price)
                    ->orWhere('sale_price', '>=', $request->min_price);
            });
        }

        if ($request->filled('max_price')) {
            $query->where(function ($q) use ($request) {
                $q->where(function ($inner) use ($request) {
                    $inner->whereNotNull('sale_price')
                        ->where('sale_price', '<=', $request->max_price);
                })->orWhere(function ($inner) use ($request) {
                    $inner->whereNull('sale_price')
                        ->where('price', '<=', $request->max_price);
                });
            });
        }

        // Filter by availability
        if ($request->filled('in_stock') && $request->in_stock) {
            $query->where(function ($q) {
                $q->where('stock_quantity', '>', 0)
                    ->orWhere('allow_backorder', true);
            });
        }

        // Filter by sale items
        if ($request->filled('on_sale') && $request->on_sale) {
            $query->whereNotNull('sale_price')
                ->whereColumn('sale_price', '<', 'price');
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'popular':
                $query->where('featured', true)->latest();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        // Paginate results
        $products = $query->paginate(12)->withQueryString();

        // Get min/max prices for filter
        $priceRange = DB::table('products')
            ->where('status', 'Active')
            ->selectRaw('MIN(COALESCE(sale_price, price)) as min_price, MAX(price) as max_price')
            ->first();

        return view('frontend.shop', compact('products', 'categories', 'brands', 'priceRange', 'totalProducts'));
    }
}
