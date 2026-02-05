<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Admin\Business_SetUp\BusinessSetup;
use App\Models\Admin\Business_SetUp\OperationalHours;
use App\Models\Admin\Business_SetUp\Prefix;
use App\Models\Admin\Business_SetUp\PublicHoliday;
use App\Models\Admin\Business_SetUp\OfficeDocument;
use App\Models\SystemLocalization;
use App\Models\SystemCurrency;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = BusinessSetup::first();
        $operational_hours = OperationalHours::all();
        $prefixes          = Prefix::all();
        $public_holidays   = PublicHoliday::orderBy('date')->get();
        $documents         = OfficeDocument::orderBy('created_at', 'desc')->get();

        // singletons with sane defaults for the Blade
        $localization = SystemLocalization::first() ?? new SystemLocalization([
            'system_language'   => 'bn',
            'timezone'          => 'Asia/Dhaka',
            'default_currency'  => 'BDT',
            'date_format'       => 'd-m-Y',
            'time_format'       => '12',
            'currency_decimals' => 2,
        ]);

        $currency = SystemCurrency::first() ?? new SystemCurrency([
            'default_currency'  => 'BDT',
            'fiscal_year_start' => 'July',
            'usd_to_bdt_rate'   => 118.50,
        ]);

        return view('admin.settings.index', compact('settings', 'operational_hours', 'prefixes', 'localization', 'currency', 'public_holidays', 'documents'));
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

        Cache::forget('global_business_setup');
        Cache::forget('theme_settings_active_theme');

        return response()->json(['success' => true, 'message' => 'General settings updated']);
    }

    public function updateStoreInfo(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_type' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'establishment_date' => 'nullable|date',
            'street_address' => 'nullable|string',
            'city_thana' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'official_contact_number' => 'nullable|array',
            'official_contact_number.*' => 'nullable|string',
            'whatsapp_number' => 'nullable|array',
            'whatsapp_number.*' => 'nullable|string',
            'hotline_number' => 'nullable|array',
            'hotline_number.*' => 'nullable|string',
            'email_address' => 'nullable|array',
            'email_address.*' => 'nullable|string|email',
            'company_registration_number' => 'nullable|string|max:255',
            'trade_license_number' => 'nullable|string|max:255',
            'bin_vat_number' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $settings = BusinessSetup::first();
        if (!$settings) {
            return response()->json(['error' => 'Business Setup not found'], 404);
        }

        $data = $request->only([
            'company_name',
            'company_type',
            'industry',
            'establishment_date',
            'street_address',
            'city_thana',
            'district',
            'zip_code',
            'official_contact_number',
            'whatsapp_number',
            'hotline_number',
            'email_address',
            'company_registration_number',
            'trade_license_number',
            'bin_vat_number',
        ]);

        // Clean array fields
        $clean = function ($arr) {
            return array_values(array_unique(array_filter(
                array_map(fn($v) => trim((string)$v), $arr ?? []),
                fn($v) => $v !== ''
            )));
        };

        if (isset($data['official_contact_number'])) $data['official_contact_number'] = $clean($data['official_contact_number']);
        if (isset($data['whatsapp_number'])) $data['whatsapp_number'] = $clean($data['whatsapp_number']);
        if (isset($data['hotline_number'])) $data['hotline_number'] = $clean($data['hotline_number']);
        if (isset($data['email_address'])) $data['email_address'] = $clean($data['email_address']);

        // Handle File Uploads
        if ($request->hasFile('logo')) {
            if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = $request->file('logo')->store('business_setup', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                Storage::disk('public')->delete($settings->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('business_setup', 'public');
        }

        $settings->update($data);

        Cache::forget('global_business_setup');
        Cache::forget('theme_settings_active_theme');

        return response()->json(['success' => true, 'message' => 'Store information updated']);
    }

    public function updateLocalization(Request $request)
    {
        $validated = $request->validate([
            'system_language'   => 'required|string|in:en,bn',
            'timezone'          => 'required|string|max:191',
            'default_currency'  => 'required|string|in:BDT,USD,INR',
            'date_format'       => 'required|string|in:d-m-Y,m/d/Y,Y-m-d',
            'time_format'       => 'required|string|in:12,24',
            'currency_decimals' => 'required|integer|min:0|max:4',
        ]);

        SystemLocalization::updateOrCreate(
            ['id' => SystemLocalization::query()->value('id') ?? 1],
            $validated
        );

        return response()->json(['success' => true, 'message' => 'Localization updated successfully']);
    }

    public function updateCurrency(Request $request)
    {
        $validated = $request->validate([
            'default_currency'  => 'required|string|in:BDT,USD,INR',
            'fiscal_year_start' => 'required|string|in:January,April,July,October',
            'usd_to_bdt_rate'   => 'required|numeric|min:0',
        ]);

        SystemCurrency::updateOrCreate(
            ['id' => SystemCurrency::query()->value('id') ?? 1],
            $validated
        );

        return response()->json(['success' => true, 'message' => 'Currency settings updated successfully']);
    }

    public function updateOperationalHours(Request $request)
    {
        $hours = json_decode($request->input('hours'), true) ?? [];
        foreach ($hours as $day => $hour) {
            OperationalHours::updateOrCreate(
                ['day' => $day],
                [
                    'status'     => $hour['status']     ?? 'Working Day',
                    'start_time' => $hour['start_time'] ?? null,
                    'end_time'   => $hour['end_time']   ?? null,
                    'updated_by' => Auth::id(),
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Operational hours updated successfully']);
    }

    public function publicHolidaysStore(Request $request)
    {
        $request->validate([
            'date'     => 'required|date',
            'occasion' => 'required|string|max:255',
        ]);

        PublicHoliday::create([
            'date'       => $request->date,
            'occasion'   => $request->occasion,
            'updated_by' => Auth::id()
        ]);

        return response()->json(['success' => true, 'message' => 'Holiday added successfully']);
    }

    public function publicHolidaysDelete($id)
    {
        PublicHoliday::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Holiday deleted successfully']);
    }

    public function documentsStore(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('office_documents', 'public');
            if (!$path) {
                return response()->json(['message' => 'File upload failed or file is invalid.'], 422);
            }
        }

        $document = OfficeDocument::create([
            'type'       => $request->type,
            'file_path'  => $path,
            'updated_by' => Auth::id()
        ]);

        return response()->json($document);
    }

    public function documentsDelete($id)
    {
        $document = OfficeDocument::findOrFail($id);
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return response()->json(['success' => true]);
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

        Cache::forget('global_business_setup');

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
