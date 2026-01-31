<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PosOrder; // We need to create this model
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::with(['variants', 'images'])->where('status', 'Active')->get();
        $customers = Customer::all();
        return view('admin.pos.index', compact('products', 'customers'));
    }

    public function searchProducts(Request $request)
    {
        $term = $request->term;
        $products = Product::with(['variants', 'images'])
            ->where('status', 'Active')
            ->where(function($q) use ($term) {
                $q->where('title', 'like', "%$term%")
                  ->orWhere('id', 'like', "%$term%"); // Can add SKU search if needed
            })
            ->limit(20)
            ->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required',
            'cart.*.variant_id' => 'nullable',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'cash_received' => 'nullable|numeric',
        ]);

        try {
            DB::beginTransaction();

            // 1. Create Order
            $order = new Order();
            $order->order_number = 'POS-' . strtoupper(Str::random(10));
            $order->user_id = $request->customer_id ?? null; // If customer selected

            // Basic customer info (Guest if not selected)
            if ($request->customer_id) {
                $customer = Customer::find($request->customer_id);

                // Split name into first and last name
                $nameParts = explode(' ', $customer->name, 2);
                $order->first_name = $nameParts[0];
                $order->last_name = $nameParts[1] ?? ''; // valid even if empty string if column allows, otherwise maybe use '.'

                // Fallback if last name is empty and DB requires it (common issue)
                if (empty($order->last_name)) {
                    $order->last_name = '.';
                }

                $order->email = $customer->email;
                $order->phone = $customer->phone;
                $order->address = $customer->address ?? 'POS Sale';
            } else {
                $order->first_name = 'Walk-in';
                $order->last_name = 'Customer';
                $order->email = 'pos@store.com';
                $order->phone = '0000000000';
                $order->address = 'Store Counter';
            }

            $order->city = 'Dhaka'; // Default store location
            $order->zip_code = '1000';
            $order->country = 'Bangladesh';

            $order->payment_method = 'cash';
            $order->payment_status = 'paid';
            $order->status = 'delivered'; // Instant delivery
            $order->order_source = 'pos';

            $order->subtotal = $request->subtotal;
            $order->discount = $request->discount ?? 0;
            $order->tax = $request->tax ?? 0;
            $order->total = $request->total;
            $order->save();

            // 2. Create Order Items & Deduct Stock
            foreach ($request->cart as $item) {
                if (!empty($item['variant_id'])) {
                    // Handle Variant Product
                    $variant = ProductVariant::find($item['variant_id']);

                    if (!$variant) {
                        throw new \Exception("Product variant not found for " . $item['name']);
                    }

                    if ($variant->stock_quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for " . $item['name']);
                    }

                    // Deduct Stock
                    $variant->decrement('stock_quantity', $item['quantity']);

                    $productSku = $variant->sku ?? $variant->product->sku;
                    $variantName = $variant->combination_key;
                } else {
                    // Handle Simple Product
                    $product = Product::find($item['id']);

                    if (!$product) {
                         throw new \Exception("Product not found for " . $item['name']);
                    }

                    if ($product->stock_quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for " . $item['name']);
                    }

                    // Deduct Stock
                    $product->decrement('stock_quantity', $item['quantity']);

                    $productSku = $product->sku;
                    $variantName = null;
                }

                // Create Item
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item['id'];
                $orderItem->variant_id = !empty($item['variant_id']) ? $item['variant_id'] : null;
                $orderItem->product_name = $item['name']; // Contains "Title (Variant)"
                $orderItem->product_sku = $productSku;
                $orderItem->variant_name = $variantName;
                $orderItem->price = $item['price'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->subtotal = $item['price'] * $item['quantity'];
                $orderItem->save();
            }

            // 3. Create POS Record
            $posOrder = new PosOrder();
            $posOrder->order_id = $order->id;
            $posOrder->served_by = Auth::id();
            $posOrder->cash_received = $request->cash_received ?? $request->total;
            $posOrder->change_returned = ($request->cash_received ?? $request->total) - $request->total;
            $posOrder->note = $request->note;
            $posOrder->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Sale completed successfully!', 'order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
