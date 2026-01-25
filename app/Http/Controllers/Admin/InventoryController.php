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
        $products = Product::with(['categories', 'brand', 'coverImage', 'variants.options.term'])->paginate(20);
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
    
    public function adjustVariantStock(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer',
            'type' => 'required|in:add,subtract,set',
        ]);
        $variant = \App\Models\ProductVariant::find($request->variant_id);
        if (!$variant) {
            return response()->json(['success' => false], 404);
        }
        $before = (int) $variant->stock_quantity;
        switch ($request->type) {
            case 'add':
                $variant->increment('stock_quantity', $request->quantity);
                $variant->product->increment('stock_quantity', $request->quantity);
                break;
            case 'subtract':
                $variant->decrement('stock_quantity', $request->quantity);
                $variant->product->decrement('stock_quantity', $request->quantity);
                break;
            case 'set':
                $new = (int) $request->quantity;
                $delta = $new - $before;
                $variant->update(['stock_quantity' => $new]);
                $variant->product->increment('stock_quantity', $delta);
                break;
        }
        return response()->json([
            'success' => true,
            'new_variant_stock' => $variant->fresh()->stock_quantity,
            'new_product_stock' => $variant->product->fresh()->stock_quantity,
        ]);
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
        $purchases = Purchase::with([
            'vendor',
            'items.product',
            'items.variant.options.term'
        ])->latest()->paginate(15);
        return view('admin.inventory.purchases', compact('purchases'));
    }

    public function createPurchase()
    {
        $vendors = Vendor::where('status', 'active')->orderBy('name')->get();
        $products = Product::with(['variants.options.term'])
            ->where('status', 'active')
            ->orderBy('title')
            ->get();
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
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'items.*.sell_price' => 'required|numeric|min:0',
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
                'variant_id' => $item['variant_id'] ?? null,
                'quantity' => $item['quantity'],
                'unit_cost' => $item['unit_cost'],
                'sell_price' => $item['sell_price'],
                'total_cost' => $item['quantity'] * $item['unit_cost'],
            ]);
        }

        return redirect()->route('admin.inventory.purchases')->with('success', 'Purchase order created successfully');
    }

    public function showPurchase($purchase)
    {
        $purchase = Purchase::with([
            'vendor',
            'items.product',
            'items.variant.options.term'
        ])->findOrFail($purchase);
        return view('admin.inventory.purchases-show', compact('purchase'));
    }

    public function updatePurchase(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,ordered,received,cancelled',
        ]);

        $purchase = Purchase::with('items')->findOrFail($id);
        $oldStatus = $purchase->status;
        $newStatus = $request->status;

        // If status is the same, just update notes
        if ($oldStatus === $newStatus) {
            $purchase->update(['notes' => $request->notes]);
            return redirect()->back()->with('success', 'Purchase order updated successfully');
        }

        // Update purchase - Observer will handle stock adjustments automatically
        $purchase->update([
            'status' => $newStatus,
            'notes' => $request->has('notes') ? $request->notes : $purchase->notes,
        ]);

        return redirect()->back()->with('success', 'Purchase order updated successfully');
    }

    public function destroyPurchase($id)
    {
        try {
            $purchase = Purchase::findOrFail($id);
            $purchase->delete(); // Soft delete
            return redirect()->route('admin.inventory.purchases')->with('success', 'Purchase order moved to trash');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.inventory.purchases')->with('error', 'Purchase order not found or already deleted');
        } catch (\Exception $e) {
            return redirect()->route('admin.inventory.purchases')->with('error', 'Failed to delete purchase order: ' . $e->getMessage());
        }
    }

    public function trashedPurchases()
    {
        $purchases = Purchase::onlyTrashed()->latest()->paginate(15);
        return view('admin.inventory.purchases-trash', compact('purchases'));
    }

    public function restorePurchase($id)
    {
        try {
            $purchase = Purchase::onlyTrashed()->findOrFail($id);
            $purchase->restore();
            return redirect()->route('admin.inventory.purchases')->with('success', 'Purchase order restored successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.inventory.purchases')->with('error', 'Failed to restore purchase order');
        }
    }

    public function forceDeletePurchase($id)
    {
        try {
            $purchase = Purchase::onlyTrashed()->findOrFail($id);
            $purchase->forceDelete();
            return redirect()->route('admin.inventory.purchases.trash')->with('success', 'Purchase order permanently deleted');
        } catch (\Exception $e) {
            return redirect()->route('admin.inventory.purchases.trash')->with('error', 'Failed to permanently delete purchase order');
        }
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

