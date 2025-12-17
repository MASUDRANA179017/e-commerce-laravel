<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales()
    {
        return view('admin.reports.sales');
    }

    public function salesData(Request $request)
    {
        // Get sales data for charts and tables
        $data = [
            'total_sales' => 0,
            'total_orders' => 0,
            'average_order_value' => 0,
            'chart_data' => [],
        ];
        return response()->json($data);
    }

    public function inventory()
    {
        $total_products = Product::count();
        $low_stock = Product::where('stock_quantity', '<', 10)->count();
        $out_of_stock = Product::where('stock_quantity', '<=', 0)->count();
        $in_stock = Product::where('stock_quantity', '>', 0)->count();
        $products = Product::select('id', 'title', 'sku', 'stock_quantity', 'price', 'status')->latest()->get();

        return view('admin.reports.inventory', compact('total_products', 'low_stock', 'out_of_stock', 'in_stock', 'products'));
    }

    public function inventoryData(Request $request)
    {
        // Get inventory data
        $data = [
            'total_products' => Product::count(),
            'low_stock' => Product::where('stock', '<', 10)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'products' => Product::select('id', 'name', 'stock', 'price')->get(),
        ];
        return response()->json($data);
    }

    public function customers()
    {
        return view('admin.reports.customers');
    }

    public function customersData(Request $request)
    {
        // Get customer analytics data
        $data = [
            'total_customers' => 0,
            'new_customers' => 0,
            'returning_customers' => 0,
            'chart_data' => [],
        ];
        return response()->json($data);
    }

    public function export($type)
    {
        // Export report as PDF/Excel
        return response()->json(['message' => 'Export functionality']);
    }
}

