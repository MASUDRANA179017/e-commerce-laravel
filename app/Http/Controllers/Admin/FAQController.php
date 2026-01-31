<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FAQController extends Controller
{
    /**
     * Display FAQs list
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $faqs = FAQ::with('product')->latest();

            if ($request->filled('type')) {
                $faqs->where('type', $request->type);
            }

            return DataTables::of($faqs)
                ->addIndexColumn()
                ->addColumn('type_badge', function ($row) {
                    return $row->type === 'product'
                        ? '<span class="badge bg-info">Product FAQ</span>'
                        : '<span class="badge bg-success">Website FAQ</span>';
                })
                ->addColumn('product', function ($row) {
                    return $row->product ? $row->product->title : 'N/A';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="btn-group">
                        <a href="' . route('admin.storefront.faqs.edit', $row->id) . '" class="btn btn-sm btn-outline-primary">
                            <i class="bx bxs-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-faq" data-id="' . $row->id . '">
                            <i class="bx bxs-trash"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['type_badge', 'status', 'action'])
                ->make(true);
        }

        return view('admin.faqs.index');
    }

    /**
     * Show create FAQ form
     */
    public function create()
    {
        $products = Product::select('id', 'title')->get();
        return view('admin.faqs.create', compact('products'));
    }

    /**
     * Store new FAQ
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:product,website',
            'product_id' => 'nullable|required_if:type,product|exists:products,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        FAQ::create($validated);

        return redirect()->route('admin.storefront.faqs.index')->with('success', 'FAQ created successfully');
    }

    /**
     * Show edit FAQ form
     */
    public function edit(FAQ $faq)
    {
        $products = Product::select('id', 'title')->get();
        return view('admin.faqs.edit', compact('faq', 'products'));
    }

    /**
     * Update FAQ
     */
    public function update(Request $request, FAQ $faq)
    {
        $validated = $request->validate([
            'type' => 'required|in:product,website',
            'product_id' => 'nullable|required_if:type,product|exists:products,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $faq->update($validated);

        return redirect()->route('admin.storefront.faqs.index')->with('success', 'FAQ updated successfully');
    }

    /**
     * Delete FAQ
     */
    public function destroy(FAQ $faq)
    {
        $faq->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Toggle FAQ status
     */
    public function toggleStatus(Request $request)
    {
        $faq = FAQ::findOrFail($request->id);
        $faq->update(['is_active' => !$faq->is_active]);
        return response()->json(['success' => true]);
    }
}
