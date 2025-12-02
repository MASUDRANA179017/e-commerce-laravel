<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Admin\Product\ProductCategory;
use App\Models\Admin\Brand\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Date ranges
        $today = Carbon::today();
        $thisWeekStart = Carbon::now()->startOfWeek();
        $thisMonthStart = Carbon::now()->startOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Main Statistics
        $stats = [
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::whereIn('status', ['processing', 'shipped'])->count(),
            'completed_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_categories' => ProductCategory::count(),
            'total_brands' => Brand::count(),
        ];

        // Today's Stats
        $todayStats = [
            'orders' => Order::whereDate('created_at', $today)->count(),
            'revenue' => Order::whereDate('created_at', $today)->where('status', '!=', 'cancelled')->sum('total'),
            'new_customers' => User::whereDate('created_at', $today)->count(),
        ];

        // This Week Stats
        $weekStats = [
            'orders' => Order::where('created_at', '>=', $thisWeekStart)->count(),
            'revenue' => Order::where('created_at', '>=', $thisWeekStart)->where('status', '!=', 'cancelled')->sum('total'),
        ];

        // This Month Stats
        $monthStats = [
            'orders' => Order::where('created_at', '>=', $thisMonthStart)->count(),
            'revenue' => Order::where('created_at', '>=', $thisMonthStart)->where('status', '!=', 'cancelled')->sum('total'),
        ];

        // Last Month Stats (for comparison)
        $lastMonthRevenue = Order::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->where('status', '!=', 'cancelled')
            ->sum('total');
        
        // Calculate growth percentage
        $revenueGrowth = $lastMonthRevenue > 0 
            ? round((($monthStats['revenue'] - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : 0;

        // Recent orders
        $recentOrders = Order::with('items')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Top selling products (by order count)
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // If no sales data, get latest products
        if ($topProducts->isEmpty()) {
            $topProducts = Product::latest()->limit(5)->get();
        }

        // Low stock products
        $lowStockProducts = Product::where('stock_quantity', '<', 10)
            ->orWhere('stock_quantity', null)
            ->orderBy('stock_quantity', 'asc')
            ->limit(5)
            ->get();

        // Monthly sales data for chart (last 12 months)
        $monthlySales = [];
        $monthlyOrders = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlySales[] = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', '!=', 'cancelled')
                ->sum('total');
            $monthlyOrders[] = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Weekly sales data for chart (last 7 days)
        $dailySales = [];
        $dailyLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $dailyLabels[] = $day->format('D');
            $dailySales[] = Order::whereDate('created_at', $day)
                ->where('status', '!=', 'cancelled')
                ->sum('total');
        }

        // Order status distribution for pie chart
        $ordersByStatus = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        // Top categories by sales
        $topCategories = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_category_product', 'products.id', '=', 'product_category_product.product_id')
            ->join('product_categories', 'product_category_product.product_category_id', '=', 'product_categories.id')
            ->select('product_categories.name', DB::raw('SUM(order_items.quantity * order_items.price) as total_sales'))
            ->groupBy('product_categories.id', 'product_categories.name')
            ->orderBy('total_sales', 'desc')
            ->limit(5)
            ->get();

        // Recent activities
        $recentActivities = collect();
        
        // Add recent orders to activities
        $recentOrderActivities = Order::latest()->limit(5)->get()->map(function($order) {
            return [
                'type' => 'order',
                'icon' => 'bx-cart',
                'color' => 'primary',
                'title' => 'New order #' . $order->order_number,
                'description' => '৳' . number_format($order->total, 2) . ' by ' . $order->full_name,
                'time' => $order->created_at,
            ];
        });

        // Add recent users to activities
        $recentUserActivities = User::latest()->limit(3)->get()->map(function($user) {
            return [
                'type' => 'user',
                'icon' => 'bx-user-plus',
                'color' => 'success',
                'title' => 'New customer registered',
                'description' => $user->name . ' (' . $user->email . ')',
                'time' => $user->created_at,
            ];
        });

        $recentActivities = $recentOrderActivities->merge($recentUserActivities)
            ->sortByDesc('time')
            ->take(8)
            ->values();

        return view('admin.dashboard', compact(
            'stats',
            'todayStats',
            'weekStats',
            'monthStats',
            'revenueGrowth',
            'recentOrders',
            'topProducts',
            'lowStockProducts',
            'monthlySales',
            'monthlyOrders',
            'dailySales',
            'dailyLabels',
            'ordersByStatus',
            'topCategories',
            'recentActivities'
        ));
    }
}
