<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Get orders with stats
        $orders = Order::with('items', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        // Calculate stats
        $stats = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::whereIn('status', ['processing', 'shipped'])->count(),
            'completed' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function getData(Request $request)
    {
        // Return orders data for DataTable
        $orders = Order::with('items', 'user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json(['data' => $orders]);
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        // Store order logic
        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully');
    }

    public function show($id)
    {
        $order = Order::with('items', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::with('items', 'user')->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $order->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        
        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        return response()->json(['success' => true, 'message' => 'Status updated']);
    }

    public function abandoned()
    {
        return view('admin.orders.abandoned');
    }

    public function returns()
    {
        return view('admin.orders.returns');
    }

    public function invoice($id)
    {
        $order = Order::with('items', 'user')->findOrFail($id);
        return view('admin.orders.invoice', compact('order'));
    }

    public function printOrder($id)
    {
        $order = Order::with('items', 'user')->findOrFail($id);
        return view('admin.orders.print', compact('order'));
    }
}
