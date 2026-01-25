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
        $request->validate([
            'system_name' => 'required|string|max:255',
            'login_tagline' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string',
            'copyright_text' => 'nullable|string',
        ]);

        $settings = BusinessSetup::first();
        if (!$settings) {
            return response()->json(['error' => 'Business Setup not found'], 404);
        }

        $settings->update($request->only([
            'system_name',
            'login_tagline',
            'footer_text',
            'copyright_text',
        ]));

        return response()->json(['success' => true, 'message' => 'General settings updated']);
    }

    public function updateStoreInfo(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'street_address' => 'nullable|string',
            'official_contact_number' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'email_address' => 'nullable|string|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $settings = BusinessSetup::first();
        if (!$settings) {
            return response()->json(['error' => 'Business Setup not found'], 404);
        }

        $data = $request->only([
            'company_name',
            'street_address',
            'official_contact_number',
            'whatsapp_number',
            'email_address',
        ]);

        // Handle File Uploads
        if ($request->hasFile('logo')) {
            if ($settings->logo && \Storage::disk('public')->exists($settings->logo)) {
                \Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = $request->file('logo')->store('business_setup', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon && \Storage::disk('public')->exists($settings->favicon)) {
                \Storage::disk('public')->delete($settings->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('business_setup', 'public');
        }

        $settings->update($data);

        return response()->json(['success' => true, 'message' => 'Store information updated']);
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
        $request->validate([
            'default_shipping_method' => 'required|in:flat_rate,free_shipping,weight_based',
            'shipping_cost_dhaka' => 'required|numeric|min:0',
            'shipping_cost_outside' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'required|numeric|min:0',
        ]);

        $settings = BusinessSetup::first();
        if (!$settings) {
            return response()->json(['error' => 'Business Setup not found'], 404);
        }

        $settings->update($request->only([
            'default_shipping_method',
            'shipping_cost_dhaka',
            'shipping_cost_outside',
            'free_shipping_threshold',
        ]));

        return response()->json(['success' => true, 'message' => 'Shipping settings updated successfully']);
    }

    public function updateTax(Request $request)
    {
        // Update tax settings
        return response()->json(['success' => true, 'message' => 'Tax settings updated']);
    }

    public function updateScout(Request $request)
    {
        $request->validate([
            'scout_discount_enabled' => 'nullable|in:0,1',
            'scout_discount_percent' => 'required|numeric|min:0|max:100',
            'scout_discount_code' => 'required|string|max:50',
        ]);

        \App\Models\SystemSetting::set('scout_discount_enabled', $request->has('scout_discount_enabled') && $request->scout_discount_enabled == '1' ? '1' : '0', 'boolean');
        \App\Models\SystemSetting::set('scout_discount_percent', $request->scout_discount_percent, 'number');
        \App\Models\SystemSetting::set('scout_discount_code', $request->scout_discount_code, 'string');

        return response()->json(['success' => true, 'message' => 'Scout discount settings updated successfully']);
    }

    public function updateCurrency(Request $request)
    {
        // Update currency settings
        return response()->json(['success' => true, 'message' => 'Currency settings updated']);
    }

    public function updateSocial(Request $request)
    {
        $request->validate([
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
        ]);

        $settings = BusinessSetup::first();
        if (!$settings) {
            return response()->json(['error' => 'Business Setup not found'], 404);
        }

        $settings->update($request->only([
            'facebook_url',
            'twitter_url',
            'linkedin_url',
            'youtube_url',
        ]));

        return response()->json(['success' => true, 'message' => 'Social settings updated']);
    }

    public function updateSeo(Request $request)
    {
        $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'google_analytics_id' => 'nullable|string|max:255',
        ]);

        $settings = BusinessSetup::first();
        if (!$settings) {
            return response()->json(['error' => 'Business Setup not found'], 404);
        }

        $settings->update($request->only([
            'meta_title',
            'meta_description',
            'meta_keywords',
            'google_analytics_id',
        ]));

        return response()->json(['success' => true, 'message' => 'SEO settings updated']);
    }
}

