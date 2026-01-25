<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    /**
     * Display list of discounts
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $discounts = Discount::latest();

            return DataTables::of($discounts)
                ->addIndexColumn()
                ->addColumn('type_badge', function ($row) {
                    $badges = [
                        'percentage' => '<span class="badge bg-info">Percentage</span>',
                        'fixed' => '<span class="badge bg-success">Fixed</span>',
                        'buy_x_get_y' => '<span class="badge bg-warning">Buy X Get Y</span>',
                    ];
                    return $badges[$row->type] ?? '';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                    </div>';
                })
                ->addColumn('validity', function ($row) {
                    if ($row->valid_from && $row->valid_until) {
                        return $row->valid_from->format('Y-m-d') . ' to ' . $row->valid_until->format('Y-m-d');
                    }
                    return 'Always active';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="btn-group">
                        <a href="' . route('admin.discounts.edit', $row->id) . '" class="btn btn-sm btn-outline-primary">
                            <i class="bx bxs-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-discount" data-id="' . $row->id . '">
                            <i class="bx bxs-trash"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['type_badge', 'status', 'action'])
                ->make(true);
        }

        return view('admin.marketing.discounts.index');
    }

    /**
     * Show create discount form
     */
    public function create()
    {
        $products = Product::select('id', 'title')->get();
        return view('admin.marketing.discounts.create', compact('products'));
    }

    /**
     * Store new discount
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|unique:discounts,code',
            'type' => 'required|in:percentage,fixed,buy_x_get_y',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'applies_to' => 'required|in:all_products,specific_products,specific_categories',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'customer_type' => 'required|in:all,new,existing',
            'is_flash_sale' => 'boolean',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'boolean',
        ]);

        Discount::create($validated);

        return redirect()->route('admin.discounts.index')->with('success', 'Discount created successfully');
    }

    /**
     * Show edit discount form
     */
    public function edit(Discount $discount)
    {
        $products = Product::select('id', 'title')->get();
        return view('admin.marketing.discounts.edit', compact('discount', 'products'));
    }

    /**
     * Update discount
     */
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|unique:discounts,code,' . $discount->id,
            'type' => 'required|in:percentage,fixed,buy_x_get_y',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'applies_to' => 'required|in:all_products,specific_products,specific_categories',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'customer_type' => 'required|in:all,new,existing',
            'is_flash_sale' => 'boolean',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'is_active' => 'boolean',
        ]);

        $discount->update($validated);

        return redirect()->route('admin.discounts.index')->with('success', 'Discount updated successfully');
    }

    /**
     * Delete discount
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Toggle discount status
     */
    public function toggleStatus(Request $request)
    {
        $discount = Discount::findOrFail($request->id);
        $discount->update(['is_active' => !$discount->is_active]);
        return response()->json(['success' => true]);
    }
}
