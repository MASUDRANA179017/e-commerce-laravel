<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        // Date filters
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfYear();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        // Base query
        $ordersQuery = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled');

        // Stats
        $totalSales = $ordersQuery->sum('total');
        $totalOrders = $ordersQuery->count();
        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
        
        $productsSold = OrderItem::whereHas('order', function($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate])
              ->where('status', '!=', 'cancelled');
        })->sum('quantity');

        // Sales Chart Data (Monthly for the selected range)
        $salesChart = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'),
            DB::raw('SUM(total) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('status', '!=', 'cancelled')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Prepare chart data for ApexCharts
        $months = [];
        $salesData = [];
        
        // Fill in missing months if range is within a year
        $period = \Carbon\CarbonPeriod::create($startDate, '1 month', $endDate);
        foreach ($period as $dt) {
            $key = $dt->format('Y-m');
            $months[] = $dt->format('M Y');
            $record = $salesChart->firstWhere('date', $key);
            $salesData[] = $record ? $record->total : 0;
        }

        // Top Selling Products
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id') // Assuming products exist
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'products.title as name',
                'products.slug', // Assuming product has slug
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.title', 'products.slug')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Top Categories
        $topCategories = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_category_map', 'products.id', '=', 'product_category_map.product_id')
            ->join('product_categories', 'product_category_map.category_id', '=', 'product_categories.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'product_categories.name',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('product_categories.id', 'product_categories.name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        return view('admin.reports.sales', compact(
            'totalSales',
            'totalOrders',
            'avgOrderValue',
            'productsSold',
            'months',
            'salesData',
            'topProducts',
            'topCategories',
            'startDate',
            'endDate'
        ));
    }

    public function salesData(Request $request)
    {
        // Reuse logic if needed for AJAX, or just return JSON of above
        // For now, the view will be static with page reload for filters
        return $this->sales($request); 
    }

    public function inventory()
    {
        $products = Product::latest()->paginate(20);
        $total_products = Product::count();
        $low_stock = Product::where('stock_quantity', '<', 10)->where('stock_quantity', '>', 0)->count();
        $out_of_stock = Product::where('stock_quantity', '<=', 0)->count();
        $in_stock = Product::where('stock_quantity', '>', 0)->count();

        return view('admin.reports.inventory', compact(
            'products',
            'total_products',
            'low_stock',
            'out_of_stock',
            'in_stock'
        ));
    }

    public function inventoryData(Request $request)
    {
         return response()->json([]);
    }

    public function customers()
    {
        $totalCustomers = User::role('Customer')->count();
        $newCustomers = User::role('Customer')->whereMonth('created_at', Carbon::now()->month)->count();
        
        // Returning customers (more than 1 order)
        $returningCustomers = Order::select('user_id')
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();
            
        // Chart data (Monthly growth this year)
        $growthData = User::role('Customer')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $months = [];
        $customerCounts = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::create(null, $i, 1);
            $months[] = $date->format('M');
            $key = $date->format('Y-m');
            $record = $growthData->firstWhere('date', $key);
            $customerCounts[] = $record ? $record->count : 0;
        }

        return view('admin.reports.customers', compact(
            'totalCustomers', 
            'newCustomers', 
            'returningCustomers',
            'months',
            'customerCounts'
        ));
    }

    public function customersData(Request $request)
    {
         return response()->json([]);
    }
    
    public function export(Request $request, $type)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfYear();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $type . '-report-' . date('Y-m-d') . '.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $callback = function() use ($type, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            if ($type === 'sales') {
                fputcsv($file, ['Order ID', 'Date', 'Customer', 'Items', 'Total', 'Status']);
                
                Order::with('user')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', '!=', 'cancelled')
                    ->chunk(100, function($orders) use ($file) {
                        foreach ($orders as $order) {
                            fputcsv($file, [
                                $order->order_number ?? $order->id,
                                $order->created_at->format('Y-m-d H:i'),
                                $order->user ? $order->user->name : ($order->first_name . ' ' . $order->last_name),
                                $order->items()->count(),
                                $order->total,
                                $order->status
                            ]);
                        }
                    });
            } elseif ($type === 'inventory') {
                fputcsv($file, ['ID', 'Product Name', 'SKU', 'Stock', 'Price', 'Status']);
                
                Product::chunk(100, function($products) use ($file) {
                    foreach ($products as $product) {
                        fputcsv($file, [
                            $product->id,
                            $product->title,
                            $product->sku,
                            $product->stock_quantity,
                            $product->price,
                            $product->status
                        ]);
                    }
                });
            } elseif ($type === 'customers') {
                fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Total Orders', 'Total Spent', 'Joined Date']);
                
                User::role('Customer')
                    ->withCount('orders')
                    ->withSum('orders', 'total')
                    ->chunk(100, function($customers) use ($file) {
                        foreach ($customers as $customer) {
                            fputcsv($file, [
                                $customer->id,
                                $customer->name,
                                $customer->email,
                                $customer->phone,
                                $customer->orders_count,
                                $customer->orders_sum_total ?? 0,
                                $customer->created_at->format('Y-m-d')
                            ]);
                        }
                    });
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
