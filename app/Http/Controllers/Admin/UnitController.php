<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = Unit::select(['id', 'name', 'status'])->latest();

            return DataTables::of($units)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input toggle-status" data-id="' . $row->id . '" ' . $checked . '>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-primary edit-unit" data-id="' . $row->id . '"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger delete-unit" data-id="' . $row->id . '"><i class="fas fa-trash"></i></button>
                    ';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.units.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:units,name',
            'status' => 'required|boolean',
        ]);

        Unit::create($request->only('name', 'status'));

        return response()->json(['success' => 'Unit created successfully.']);
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return response()->json($unit);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:units,name,' . $id,
            'status' => 'required|boolean',
        ]);

        $unit = Unit::findOrFail($id);
        $unit->update($request->only('name', 'status'));

        return response()->json(['success' => 'Unit updated successfully.']);
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return response()->json(['success' => 'Unit deleted successfully.']);
    }

    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $unit = Unit::findOrFail($id);
        $unit->status = $request->status;
        $unit->save();

        return response()->json(['success' => 'Status updated successfully.']);
    }
}
