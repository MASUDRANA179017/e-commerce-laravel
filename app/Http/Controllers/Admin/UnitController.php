<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = Unit::latest()->get();
            return Datatables::of($units)
                ->addIndexColumn() // SL column
                ->addColumn('status', function($row){
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input type="checkbox" class="form-check-input toggle-status" data-id="'.$row->id.'" '.$checked.'></div>';
                })
                ->addColumn('action', function($row){
                    $edit = '<button class="btn btn-sm btn-primary edit-unit" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                    $delete = '<button class="btn btn-sm btn-danger delete-unit" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                    return $edit.' '.$delete;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('admin.units.index');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:units,name']);
        Unit::create(['name' => $request->name, 'status' => true]);
        return response()->json(['success' => 'Unit created successfully.']);
    }

    public function edit($id)
    {
        $unit = Unit::find($id);
        return response()->json($unit);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:units,name,'.$id]);
        $unit = Unit::find($id);
        $unit->update(['name' => $request->name]);
        return response()->json(['success' => 'Unit updated successfully.']);
    }

    public function destroy($id)
    {
        Unit::find($id)->delete();
        return response()->json(['success' => 'Unit deleted successfully.']);
    }

    public function updateStatus(Request $request)
    {
        $unit = Unit::find($request->id);
        $unit->status = $request->status;
        $unit->save();
        return response()->json(['success'=>'Status changed successfully.']);
    }
}

