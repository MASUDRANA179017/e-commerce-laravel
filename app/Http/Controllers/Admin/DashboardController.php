<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_orders' => 0, // Order::count() when Order model exists
            'total_revenue' => 0, // Order::sum('total') when Order model exists
            'pending_orders' => 0,
            'processing_orders' => 0,
            'completed_orders' => 0,
            'cancelled_orders' => 0,
        ];

        // Recent orders
        $recentOrders = collect(); // Order::latest()->limit(10)->get() when Order model exists

        // Top selling products
        $topProducts = Product::latest()->limit(5)->get();

        // Low stock products
        $lowStockProducts = Product::where('stock', '<', 10)->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'lowStockProducts'));
    }
}

