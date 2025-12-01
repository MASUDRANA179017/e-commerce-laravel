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
                    return '<input type="checkbox" class="toggle-status" data-id="'.$row->id.'" '.$checked.'>';
                })
                ->addColumn('action', function($row){
                    $edit = '<button class="btn btn-sm btn-primary edit-unit" data-id="'.$row->id.'">Edit</button>';
                    $delete = '<button class="btn btn-sm btn-danger delete-unit" data-id="'.$row->id.'">Delete</button>';
                    return $edit.' '.$delete;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('admin.units.index');
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required']);
        Unit::updateOrCreate(
            ['id' => $request->unit_id],
            ['name' => $request->name, 'status' => $request->status ?? 0]
        );
        return response()->json(['success'=>'Unit saved successfully.']);
    }

    public function edit($id)
    {
        $unit = Unit::find($id);
        return response()->json($unit);
    }

    public function destroy($id)
    {
        Unit::find($id)->delete();
        return response()->json(['success'=>'Unit deleted successfully.']);
    }

    public function toggleStatus($id)
    {
        $unit = Unit::find($id);
        $unit->status = !$unit->status;
        $unit->save();
        return response()->json(['success'=>'Status updated.']);
    }
}

