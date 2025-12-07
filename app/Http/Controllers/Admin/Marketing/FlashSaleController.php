<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FlashSaleController extends Controller
{
    /**
     * Display flash sales list
     */
    public function index()
    {
        // Update statuses based on time
        $this->updateFlashSaleStatuses();
        
        $flashSales = FlashSale::withCount('products')
            ->orderByDesc('created_at')
            ->get();
        
        $activeFlashSale = FlashSale::active()->featured()->with('products')->first()
            ?? FlashSale::active()->with('products')->first();
        
        $products = Product::whereIn('status', ['active', 'Active'])
            ->select('id', 'title', 'price', 'sale_price')
            ->orderBy('title')
            ->get();
        
        return view('admin.marketing.flash-sales', compact('flashSales', 'activeFlashSale', 'products'));
    }

    /**
     * Store a new flash sale
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'is_featured' => 'nullable|boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
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

    /**
     * Update flash sale
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'is_featured' => 'nullable|boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
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
            if ($request->has('products')) {
                $flashSale->products()->sync($request->products ?? []);
            }

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

    /**
     * Delete flash sale
     */
    public function destroy($id)
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

    /**
     * Toggle flash sale status
     */
    public function toggleStatus($id)
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

    /**
     * Get active flash sale data for frontend API
     */
    public function getActive()
    {
        $this->updateFlashSaleStatuses();
        
        $flashSale = FlashSale::active()
            ->orderByDesc('is_featured')
            ->with(['products' => function($q) {
                $q->whereIn('status', ['active', 'Active'])
                  ->with('images')
                  ->limit(12);
            }])
            ->first();

        if (!$flashSale) {
            return response()->json([
                'success' => false,
                'message' => 'No active flash sale',
            ]);
        }

        return response()->json([
            'success' => true,
            'flash_sale' => [
                'id' => $flashSale->id,
                'title' => $flashSale->title,
                'description' => $flashSale->description,
                'end_time' => $flashSale->end_time->toIso8601String(),
                'end_timestamp' => $flashSale->end_time->timestamp * 1000,
                'discount_percent' => $flashSale->discount_percent,
                'products_count' => $flashSale->products->count(),
                'products' => $flashSale->products->map(function($product) {
                    $image = $product->images->where('is_cover', true)->first() 
                        ?? $product->images->first();
                    return [
                        'id' => $product->id,
                        'title' => $product->title,
                        'slug' => $product->slug,
                        'price' => $product->price,
                        'sale_price' => $product->sale_price,
                        'flash_price' => $product->pivot->flash_price,
                        'image' => $image ? '/storage/' . $image->path : null,
                    ];
                }),
            ],
        ]);
    }

    /**
     * Update flash sale statuses based on time
     */
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
}

