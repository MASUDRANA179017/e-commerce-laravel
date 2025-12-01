<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function stock()
    {
        $products = Product::with('category', 'brand')->paginate(20);
        return view('admin.inventory.stock', compact('products'));
    }

    public function stockData(Request $request)
    {
        $products = Product::select('id', 'name', 'stock', 'price', 'sku')->get();
        return response()->json(['data' => $products]);
    }

    public function adjustStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'type' => 'required|in:add,subtract,set',
        ]);

        $product = Product::find($request->product_id);
        
        switch ($request->type) {
            case 'add':
                $product->increment('stock', $request->quantity);
                break;
            case 'subtract':
                $product->decrement('stock', $request->quantity);
                break;
            case 'set':
                $product->update(['stock' => $request->quantity]);
                break;
        }

        return response()->json(['success' => true, 'new_stock' => $product->fresh()->stock]);
    }

    public function lowStock()
    {
        $products = Product::where('stock', '<', 10)->paginate(20);
        return view('admin.inventory.low-stock', compact('products'));
    }

    public function purchases()
    {
        return view('admin.inventory.purchases');
    }

    public function createPurchase()
    {
        return view('admin.inventory.purchases-create');
    }

    public function storePurchase(Request $request)
    {
        // Store purchase order logic
        return redirect()->route('admin.inventory.purchases')->with('success', 'Purchase order created');
    }

    public function showPurchase($purchase)
    {
        return view('admin.inventory.purchases-show', compact('purchase'));
    }

    public function updatePurchase(Request $request, $purchase)
    {
        // Update purchase order logic
        return response()->json(['success' => true]);
    }

    public function destroyPurchase($purchase)
    {
        // Delete purchase order logic
        return response()->json(['success' => true]);
    }

    public function vendors()
    {
        return view('admin.inventory.vendors');
    }

    public function storeVendor(Request $request)
    {
        // Store vendor logic
        return response()->json(['success' => true, 'message' => 'Vendor created']);
    }

    public function showVendor($vendor)
    {
        return response()->json(['vendor' => $vendor]);
    }

    public function updateVendor(Request $request, $vendor)
    {
        // Update vendor logic
        return response()->json(['success' => true]);
    }

    public function destroyVendor($vendor)
    {
        // Delete vendor logic
        return response()->json(['success' => true]);
    }
}

