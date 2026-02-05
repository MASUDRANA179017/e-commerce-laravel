<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Admin\Product\ProductCategory;
use App\Models\Admin\Brand\Brand;
use App\Models\FlashSale;
use App\Models\Blog;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Cache Duration Constants
        $LONG_CACHE = 3600; // 1 hour
        $SHORT_CACHE = 1800; // 30 minutes
        $TINY_CACHE = 300;   // 5 minutes

        // Common eager loads for products to prevent N+1 queries
        $productEagerLoads = [
            'images',
            'brand',
            'categories',
            'flashSales' => function($q) {
                $q->where('status', 'active')
                  ->where('start_time', '<=', now())
                  ->where('end_time', '>=', now());
            },
            'approvedReviews'
        ];

        // Determine active theme (for filtering banners)
        $activeTheme = 'theme1';
        if (request()->has('theme_preview')) {
            $activeTheme = request()->get('theme_preview');
        } else {
            $settings = Cache::remember('theme_settings_active_theme', 3600, function() {
                return DB::table('business_setups')->select('active_theme')->first();
            });
            $activeTheme = $settings->active_theme ?? 'theme1';
        }

        // Get active hero sliders
        $sliders = Cache::remember('home_sliders_' . $activeTheme, $LONG_CACHE, function () use ($activeTheme) {
            try {
                return Banner::where('type', 'hero_slider')
                    ->where('status', true)
                    ->where(function($q) use ($activeTheme) {
                        $q->where('theme', 'all')
                          ->orWhere('theme', $activeTheme)
                          ->orWhereNull('theme');
                    })
                    ->orderBy('position')
                    ->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Get ads sections
        $ads_sections = Cache::remember('home_ads_sections_' . $activeTheme, $LONG_CACHE, function () use ($activeTheme) {
            try {
                return Banner::where('type', 'ads_section')
                    ->where('status', true)
                    ->where(function($q) use ($activeTheme) {
                        $q->where('theme', 'all')
                          ->orWhere('theme', $activeTheme)
                          ->orWhereNull('theme');
                    })
                    ->orderBy('position')
                    ->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Get ALL parent categories with children relationship
        $categories = Cache::remember('home_categories', $LONG_CACHE, function () {
            try {
                return ProductCategory::whereNull('parent_id')
                    ->with('children')
                    ->orderBy('order')
                    ->get();
            } catch (\Exception $e) {
                try {
                    return ProductCategory::whereNull('parent_id')
                        ->orderBy('order')
                        ->get();
                } catch (\Exception $e2) {
                    return collect();
                }
            }
        });

        // Get featured products
        $featuredProducts = Cache::remember('home_featured_products', $SHORT_CACHE, function () use ($productEagerLoads) {
            try {
                return Product::where('status', 'Active')
                    ->where('featured', true)
                    ->with($productEagerLoads)
                    ->latest()
                    ->limit(8)
                    ->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Get new arrivals (products created in last 30 days)
        $newArrivals = Cache::remember('home_new_arrivals', $SHORT_CACHE, function () use ($productEagerLoads) {
            try {
                return Product::where('status', 'Active')
                    ->where('created_at', '>=', now()->subDays(30))
                    ->with($productEagerLoads)
                    ->latest()
                    ->limit(8)
                    ->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Get best selling / popular products
        // Using inRandomOrder is heavy, caching it makes it efficient while still "random" per cache cycle
        $bestSellers = Cache::remember('home_best_sellers', $SHORT_CACHE, function () use ($productEagerLoads) {
            try {
                return Product::where('status', 'Active')
                    ->with($productEagerLoads)
                    ->inRandomOrder()
                    ->limit(8)
                    ->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Get brands for display
        $brands = Cache::remember('home_brands', $LONG_CACHE, function () {
            try {
                return Brand::where('status', 'active')
                    ->orderBy('name')
                    ->limit(12)
                    ->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Update Flash Sale Status (Only once every 5 minutes to reduce DB writes on GET request)
        if (!Cache::has('flash_sale_status_updated_recently')) {
            try {
                $now = now();
                FlashSale::where('status', 'scheduled')
                    ->where('start_time', '<=', $now)
                    ->where('end_time', '>=', $now)
                    ->update(['status' => 'active']);

                FlashSale::where('status', 'active')
                    ->where('end_time', '<', $now)
                    ->update(['status' => 'ended']);

                Cache::put('flash_sale_status_updated_recently', true, $TINY_CACHE);
            } catch (\Exception $e) {
                // Ignore table missing errors
            }
        }

        // Get active or upcoming flash sale
        $flashSaleData = Cache::remember('home_flash_sale_data', $TINY_CACHE, function () use ($productEagerLoads) {
            try {
                $now = now();
                $flashSale = FlashSale::whereIn('status', ['active', 'scheduled'])
                    ->where('end_time', '>=', $now)
                    ->orderByRaw("FIELD(status, 'active', 'scheduled', 'draft', 'ended')")
                    ->orderByDesc('is_featured')
                    ->orderBy('start_time')
                    ->first();

                $products = collect();
                if ($flashSale) {
                    $products = $flashSale->products()
                        ->whereIn('status', ['active', 'Active'])
                        ->with($productEagerLoads)
                        ->limit(8)
                        ->get();
                }
                return ['flashSale' => $flashSale, 'products' => $products];
            } catch (\Exception $e) {
                return ['flashSale' => null, 'products' => collect()];
            }
        });

        $flashSale = $flashSaleData['flashSale'];
        $flashSaleProducts = $flashSaleData['products'];

        // Get latest 3 published blogs
        $latestBlogs = Cache::remember('home_latest_blogs', $LONG_CACHE, function () {
            try {
                return Blog::published()
                    ->with('author')
                    ->latest()
                    ->limit(3)
                    ->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Get promotional banners
        $promotional_banners = Cache::remember('home_promotional_banners_' . $activeTheme, $LONG_CACHE, function () use ($activeTheme) {
            try {
                return Banner::where('type', 'promotional_banner')
                    ->where('status', true)
                    ->where(function($q) use ($activeTheme) {
                        $q->where('theme', 'all')
                          ->orWhere('theme', $activeTheme)
                          ->orWhereNull('theme');
                    })
                    ->orderBy('position')
                    ->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        // Get store sections
        $store_sections = Cache::remember('home_store_sections_' . $activeTheme, $LONG_CACHE, function () use ($activeTheme) {
            try {
                return Banner::where('type', 'store_section')
                    ->where('status', true)
                    ->where(function($q) use ($activeTheme) {
                        $q->where('theme', 'all')
                          ->orWhere('theme', $activeTheme)
                          ->orWhereNull('theme');
                    })
                    ->orderBy('position')
                    ->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        return view('frontend.home', compact(
            'sliders',
            'categories',
            'featuredProducts',
            'newArrivals',
            'bestSellers',
            'brands',
            'flashSale',
            'flashSaleProducts',
            'latestBlogs',
            'promotional_banners',
            'store_sections',
            'ads_sections'
        ));
    }
}
