<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    public function getData(Request $request)
    {
        // Return orders data for DataTable
        $orders = collect(); // Order::query()
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

    public function show($order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function edit($order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $order)
    {
        // Update order logic
        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy($order)
    {
        // Delete order logic
        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request, $order)
    {
        // Update order status
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

    public function invoice($order)
    {
        return view('admin.orders.invoice', compact('order'));
    }

    public function printOrder($order)
    {
        return view('admin.orders.print', compact('order'));
    }
}

