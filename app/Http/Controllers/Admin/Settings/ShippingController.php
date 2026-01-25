<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShippingController extends Controller
{
    /**
     * Display shipping zones list
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $zones = ShippingZone::latest();

            return DataTables::of($zones)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="btn-group">
                        <a href="' . route('admin.shipping.edit', $row->id) . '" class="btn btn-sm btn-outline-primary">
                            <i class="bx bxs-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-zone" data-id="' . $row->id . '">
                            <i class="bx bxs-trash"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.settings.shipping.index');
    }

    /**
     * Show create shipping zone form
     */
    public function create()
    {
        return view('admin.settings.shipping.create');
    }

    /**
     * Store new shipping zone
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:region,country,postal_code',
            'base_charge' => 'required|numeric|min:0',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        ShippingZone::create($validated);

        return redirect()->route('admin.shipping.index')->with('success', 'Shipping zone created successfully');
    }

    /**
     * Show edit shipping zone form
     */
    public function edit(ShippingZone $zone)
    {
        return view('admin.settings.shipping.edit', compact('zone'));
    }

    /**
     * Update shipping zone
     */
    public function update(Request $request, ShippingZone $zone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:region,country,postal_code',
            'base_charge' => 'required|numeric|min:0',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $zone->update($validated);

        return redirect()->route('admin.shipping.index')->with('success', 'Shipping zone updated successfully');
    }

    /**
     * Delete shipping zone
     */
    public function destroy(ShippingZone $zone)
    {
        $zone->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Toggle shipping zone status
     */
    public function toggleStatus(Request $request)
    {
        $zone = ShippingZone::findOrFail($request->id);
        $zone->update(['is_active' => !$zone->is_active]);
        return response()->json(['success' => true]);
    }
}
