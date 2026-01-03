<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MarketingController extends Controller
{
    public function coupons()
    {
        $coupons = Coupon::orderByDesc('created_at')->get();
        $total = $coupons->count();
        $active = $coupons->where('is_active', true)->count();
        $timesUsed = $coupons->sum('used_count');
        $totalSavings = $coupons->sum(function ($c) {
            return $c->type === 'fixed' ? ($c->value * $c->used_count) : 0;
        });
        return view('admin.marketing.coupons', compact('coupons', 'total', 'active', 'timesUsed', 'totalSavings'));
    }

    public function couponsData(Request $request)
    {
        $coupons = Coupon::orderByDesc('created_at')->get();
        return response()->json(['data' => $coupons]);
    }

    public function storeCoupon(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date',
        ]);

        Coupon::create([
            'code' => strtoupper(trim($validated['code'])),
            'type' => $validated['type'],
            'value' => $validated['value'],
            'min_purchase' => $validated['min_purchase'] ?? null,
            'usage_limit' => $validated['usage_limit'] ?? null,
            'expiry_date' => $validated['expiry_date'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.marketing.coupons')->with('success', 'Coupon created');
    }

    public function showCoupon($coupon)
    {
        $coupon = Coupon::findOrFail($coupon);
        return response()->json(['coupon' => $coupon]);
    }

    public function updateCoupon(Request $request, $coupon)
    {
        $coupon = Coupon::findOrFail($coupon);
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'expiry_date' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $coupon->update([
            'code' => strtoupper(trim($validated['code'])),
            'type' => $validated['type'],
            'value' => $validated['value'],
            'min_purchase' => $validated['min_purchase'] ?? null,
            'usage_limit' => $validated['usage_limit'] ?? null,
            'expiry_date' => $validated['expiry_date'] ?? null,
            'is_active' => $request->has('is_active') ? (bool)$validated['is_active'] : $coupon->is_active,
        ]);

        return redirect()->route('admin.marketing.coupons')->with('success', 'Coupon updated');
    }

    public function destroyCoupon($coupon)
    {
        $coupon = Coupon::findOrFail($coupon);
        $coupon->delete();
        return redirect()->back()->with('success', 'Coupon deleted');
    }

    public function toggleCoupon($coupon)
    {
        $coupon = Coupon::findOrFail($coupon);
        $coupon->update(['is_active' => !$coupon->is_active]);
        return redirect()->back()->with('success', 'Coupon status updated');
    }

    public function flashSales()
    {
        // Update statuses based on time
        $this->updateFlashSaleStatuses();
        
        $flashSales = FlashSale::withCount('products')
            ->orderByDesc('created_at')
            ->get();
        
        $activeFlashSale = FlashSale::active()->where('is_featured', true)->with('products')->first()
            ?? FlashSale::active()->with('products')->first();
        
        $products = Product::whereIn('status', ['active', 'Active'])
            ->select('id', 'title', 'price', 'sale_price')
            ->orderBy('title')
            ->get();
        
        return view('admin.marketing.flash-sales', compact('flashSales', 'activeFlashSale', 'products'));
    }

    public function showFlashSale($id)
    {
        $flashSale = FlashSale::with('products')->findOrFail($id);
        return response()->json(['flash_sale' => $flashSale]);
    }

    public function storeFlashSale(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'is_featured' => 'nullable|boolean',
            'products' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $status = 'draft';
            $now = now();
            $startTime = \Carbon\Carbon::parse($request->start_time);
            $endTime = \Carbon\Carbon::parse($request->end_time);
            
            if ($startTime <= $now && $endTime >= $now) {
                $status = 'active';
            } elseif ($startTime > $now) {
                $status = 'scheduled';
            } elseif ($endTime < $now) {
                $status = 'ended';
            }

            // If this is featured, remove featured from others
            if ($request->is_featured) {
                FlashSale::where('is_featured', true)->update(['is_featured' => false]);
            }

            $flashSale = FlashSale::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'discount_percent' => $request->discount_percent ?? 0,
                'status' => $status,
                'is_featured' => $request->is_featured ?? false,
            ]);

            // Attach products
            if ($request->has('products') && is_array($request->products)) {
                $flashSale->products()->attach($request->products);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Flash sale created successfully!',
                'flash_sale' => $flashSale->load('products'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Flash sale creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create flash sale: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateFlashSale(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'is_featured' => 'nullable|boolean',
            'products' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $flashSale = FlashSale::findOrFail($id);

            $status = $flashSale->status;
            $now = now();
            $startTime = \Carbon\Carbon::parse($request->start_time);
            $endTime = \Carbon\Carbon::parse($request->end_time);
            
            if ($startTime <= $now && $endTime >= $now) {
                $status = 'active';
            } elseif ($startTime > $now) {
                $status = 'scheduled';
            } elseif ($endTime < $now) {
                $status = 'ended';
            }

            // If this is featured, remove featured from others
            if ($request->is_featured) {
                FlashSale::where('id', '!=', $id)->where('is_featured', true)->update(['is_featured' => false]);
            }

            $flashSale->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'discount_percent' => $request->discount_percent ?? 0,
                'status' => $status,
                'is_featured' => $request->is_featured ?? false,
            ]);

            // Sync products
            $flashSale->products()->sync($request->products ?? []);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Flash sale updated successfully!',
                'flash_sale' => $flashSale->load('products'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Flash sale update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update flash sale: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyFlashSale($id)
    {
        try {
            $flashSale = FlashSale::findOrFail($id);
            $flashSale->delete();

            return response()->json([
                'success' => true,
                'message' => 'Flash sale deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete flash sale: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function toggleFlashSale($id)
    {
        try {
            $flashSale = FlashSale::findOrFail($id);
            
            if ($flashSale->status === 'active') {
                $flashSale->status = 'draft';
            } elseif (in_array($flashSale->status, ['draft', 'scheduled'])) {
                $now = now();
                if ($flashSale->start_time <= $now && $flashSale->end_time >= $now) {
                    $flashSale->status = 'active';
                } else {
                    $flashSale->status = 'scheduled';
                }
            }
            
            $flashSale->save();

            return response()->json([
                'success' => true,
                'message' => 'Flash sale status updated!',
                'status' => $flashSale->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function updateFlashSaleStatuses()
    {
        $now = now();
        
        // Activate scheduled sales that have started
        FlashSale::where('status', 'scheduled')
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->update(['status' => 'active']);
        
        // End active sales that have passed end time
        FlashSale::where('status', 'active')
            ->where('end_time', '<', $now)
            ->update(['status' => 'ended']);
    }

    public function newsletters()
    {
        return view('admin.marketing.newsletters');
    }

    public function subscribers()
    {
        return response()->json(['subscribers' => collect()]);
    }

    public function sendNewsletter(Request $request)
    {
        // Send newsletter logic
        return response()->json(['success' => true, 'message' => 'Newsletter sent']);
    }

    public function deleteSubscriber($subscriber)
    {
        // Delete subscriber logic
        return response()->json(['success' => true]);
    }
}

