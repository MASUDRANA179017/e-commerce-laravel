<?php

namespace App\Http\Controllers;

use App\Models\TermsCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TermsConditionController extends Controller
{
    public function index()
    {
        return view('terms-conditions.index');
    }

    public function getData()
    {
        $terms = TermsCondition::orderBy('created_at', 'desc')->get();
        return response()->json($terms);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $term = TermsCondition::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Terms & Conditions created successfully',
            'data' => $term
        ]);
    }

    public function show($id)
    {
        $term = TermsCondition::findOrFail($id);
        return response()->json($term);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $term = TermsCondition::findOrFail($id);
        $term->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Terms & Conditions updated successfully',
            'data' => $term
        ]);
    }

    public function destroy($id)
    {
        $term = TermsCondition::findOrFail($id);
        $term->delete();

        return response()->json([
            'success' => true,
            'message' => 'Terms & Conditions deleted successfully'
        ]);
    }
}