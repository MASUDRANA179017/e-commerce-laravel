<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Business_SetUp\BusinessSetup;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = BusinessSetup::first();
        return view('admin.settings.index', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        // Update general settings
        return response()->json(['success' => true, 'message' => 'General settings updated']);
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|numeric',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        $settings = BusinessSetup::first();
        if (!$settings) {
            return response()->json(['error' => 'Business Setup not found'], 404);
        }

        $settings->update($request->only([
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
        ]));

        return response()->json(['success' => true, 'message' => 'Email settings updated successfully']);
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

