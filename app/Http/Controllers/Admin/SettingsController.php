<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function updateGeneral(Request $request)
    {
        // Update general settings
        return response()->json(['success' => true, 'message' => 'General settings updated']);
    }

    public function updateEmail(Request $request)
    {
        // Update email settings
        return response()->json(['success' => true, 'message' => 'Email settings updated']);
    }

    public function updatePayment(Request $request)
    {
        // Update payment settings
        return response()->json(['success' => true, 'message' => 'Payment settings updated']);
    }

    public function updateShipping(Request $request)
    {
        // Update shipping settings
        return response()->json(['success' => true, 'message' => 'Shipping settings updated']);
    }

    public function updateTax(Request $request)
    {
        // Update tax settings
        return response()->json(['success' => true, 'message' => 'Tax settings updated']);
    }

    public function updateCurrency(Request $request)
    {
        // Update currency settings
        return response()->json(['success' => true, 'message' => 'Currency settings updated']);
    }

    public function updateSocial(Request $request)
    {
        // Update social media settings
        return response()->json(['success' => true, 'message' => 'Social settings updated']);
    }

    public function updateSeo(Request $request)
    {
        // Update SEO settings
        return response()->json(['success' => true, 'message' => 'SEO settings updated']);
    }
}

