<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    public function stock()
    {
        $products = Product::with('categories', 'brand', 'coverImage')->paginate(20);
        return view('admin.inventory.stock', compact('products'));
    }

    public function stockData(Request $request)
    {
        $products = Product::select('id', 'title', 'stock_quantity', 'price', 'sku')->get();
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
                $product->increment('stock_quantity', $request->quantity);
                break;
            case 'subtract':
                $product->decrement('stock_quantity', $request->quantity);
                break;
            case 'set':
                $product->update(['stock_quantity' => $request->quantity]);
                break;
        }

        return response()->json(['success' => true, 'new_stock' => $product->fresh()->stock_quantity]);
    }

    public function lowStock()
    {
        $products = Product::with('categories', 'brand', 'coverImage')
            ->where('stock_quantity', '<', 10)
            ->paginate(20);
        return view('admin.inventory.low-stock', compact('products'));
    }

    public function purchases()
    {
        $purchases = Purchase::with('vendor', 'items')->latest()->paginate(15);
        return view('admin.inventory.purchases', compact('purchases'));
    }

    public function createPurchase()
    {
        $vendors = Vendor::where('status', 'active')->orderBy('name')->get();
        $products = Product::select('id', 'title', 'sku')->where('status', 'active')->orderBy('title')->get();
        return view('admin.inventory.purchases-create', compact('vendors', 'products'));
    }

    public function storePurchase(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'purchase_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        $totalAmount = 0;
        foreach ($request->items as $item) {
            $totalAmount += $item['quantity'] * $item['unit_cost'];
        }

        $purchase = Purchase::create([
            'purchase_number' => 'PO-' . strtoupper(Str::random(8)),
            'vendor_id' => $request->vendor_id,
            'purchase_date' => $request->purchase_date,
            'expected_delivery_date' => $request->expected_delivery_date,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $item) {
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_cost' => $item['unit_cost'],
                'total_cost' => $item['quantity'] * $item['unit_cost'],
            ]);
        }

        return redirect()->route('admin.inventory.purchases')->with('success', 'Purchase order created successfully');
    }

    public function showPurchase($purchase)
    {
        $purchase = Purchase::with('vendor', 'items.product')->findOrFail($purchase);
        return view('admin.inventory.purchases-show', compact('purchase'));
    }

    public function updatePurchase(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,ordered,received,cancelled',
        ]);

        $purchase = Purchase::findOrFail($id);
        $purchase->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        if ($request->status == 'received') {
            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock_quantity', $item->quantity);
                }
            }
        }

        return redirect()->back()->with('success', 'Purchase order updated successfully');
    }

    public function destroyPurchase($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();
        return redirect()->route('admin.inventory.purchases')->with('success', 'Purchase order deleted successfully');
    }

    public function vendors()
    {
        $vendors = Vendor::latest()->paginate(15);
        return view('admin.inventory.vendors', compact('vendors'));
    }

    public function storeVendor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        Vendor::create($request->all());

        return redirect()->back()->with('success', 'Vendor created successfully');
    }

    public function updateVendor(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->update($request->all());

        return redirect()->back()->with('success', 'Vendor updated successfully');
    }

    public function destroyVendor($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
        return redirect()->back()->with('success', 'Vendor deleted successfully');
    }
}

