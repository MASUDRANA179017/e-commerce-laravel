<?php

namespace App\Http\Controllers\Admin\Business_SetUp;

use App\Http\Controllers\Controller;
use App\Models\Admin\Business_SetUp\BusinessSetup;
use App\Models\Admin\Business_SetUp\OfficeDocument;
use App\Models\Admin\Business_SetUp\OperationalHours;
use App\Models\Admin\Business_SetUp\Prefix;
use App\Models\Admin\Business_SetUp\PublicHoliday;
use App\Models\SystemCurrency;
use App\Models\SystemLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Log;

class BusinessSetUpController extends Controller
{
    public function index(){
        $business_setup    = BusinessSetup::firstOrFail();
        $operational_hours = OperationalHours::all();
        $prefixes          = Prefix::all();

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

        return view('admin.business_settings.business_setup',
            compact('business_setup', 'operational_hours', 'prefixes', 'localization', 'currency'));
    }

    public function updateAll(Request $request, $id)
    {
        Log::info($request->all());
        $business = BusinessSetup::findOrFail($id);
        $part     = $request->input('part');
        $dataToUpdate = ['updated_by' => Auth::id()];

        switch ($part) {
            case 'company_info':
                $validated = $request->validate([
                    'company_name'       => 'nullable|string|max:255',
                    'company_type'       => 'nullable|string|max:255',
                    'industry'           => 'nullable|string|max:255',
                    'establishment_date' => 'nullable|date',
                ]);
                $business->update(array_merge($validated, $dataToUpdate));
                break;

            case 'legal_numbers':
                $validated = $request->validate([
                    'company_registration_number' => 'nullable|string|max:255',
                    'trade_license_number'        => 'nullable|string|max:255',
                    'bin_vat_number'              => 'nullable|string|max:255',
                ]);
                $business->update(array_merge($validated, $dataToUpdate));
                break;

            case 'address':
                $validated = $request->validate([
                    'street_address' => 'nullable|string',
                    'city_thana'     => 'nullable|string|max:255',
                    'district'       => 'nullable|string|max:255',
                    'zip_code'       => 'nullable|string|max:20',
                ]);
                $business->update(array_merge($validated, $dataToUpdate));
                break;

            case 'contact_info':
                $request->validate([
                    'official_contact_number'   => 'array',
                    'official_contact_number.*' => 'nullable|string|max:50',
                    'whatsapp_number'           => 'array',
                    'whatsapp_number.*'         => 'nullable|string|max:50',
                    'hotline_number'            => 'array',
                    'hotline_number.*'          => 'nullable|string|max:50',
                    'email_address'             => 'array',
                    'email_address.*'           => 'nullable|email|max:255',
                    'landline_number'           => 'nullable|string|max:50',
                    'website_address'           => 'nullable|url|max:255',
                ]);

                $clean = function ($arr) {
                    return array_values(array_unique(array_filter(
                        array_map(fn($v) => trim((string)$v), $arr ?? []),
                        fn($v) => $v !== ''
                    )));
                };

                $business->update(array_merge([
                    'official_contact_number' => $clean($request->input('official_contact_number', [])),
                    'whatsapp_number'         => $clean($request->input('whatsapp_number', [])),
                    'hotline_number'          => $clean($request->input('hotline_number', [])),
                    'email_address'           => $clean($request->input('email_address', [])),
                    'landline_number'         => $request->input('landline_number'),
                    'website_address'         => $request->input('website_address'),
                ], $dataToUpdate));
                break;

            case 'social_media':
                $validated = $request->validate([
                    'facebook_url'  => 'nullable|string|max:255',
                    'linkedin_url'  => 'nullable|string|max:255',
                    'youtube_url'   => 'nullable|string|max:255',
                    'twitter_url'   => 'nullable|string|max:255',
                ]);
                $validated['facebook_status'] = $request->has('facebook_status') ? 1 : 0;
                $validated['linkedin_status'] = $request->has('linkedin_status') ? 1 : 0;
                $validated['youtube_status']  = $request->has('youtube_status') ? 1 : 0;
                $validated['twitter_status']  = $request->has('twitter_status') ? 1 : 0;
                $business->update(array_merge($validated, $dataToUpdate));
                break;

            case 'operational_hours':
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
                break;

            case 'branding':
                $request->validate([
                    'logo'     => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
                    'alt_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
                    'favicon'  => 'nullable|image|mimes:ico,png,svg|max:1024',
                ]);

                if ($request->hasFile('logo')) {
                    deleteFile($business->logo);
                    $dataToUpdate['logo'] = uploadFile($request->file('logo'), 'business_setup/branding');
                }
                if ($request->hasFile('alt_logo')) {
                    deleteFile($business->alt_logo);
                    $dataToUpdate['alt_logo'] = uploadFile($request->file('alt_logo'), 'business_setup/branding');
                }
                if ($request->hasFile('favicon')) {
                    deleteFile($business->favicon);
                    $dataToUpdate['favicon'] = uploadFile($request->file('favicon'), 'business_setup/branding');
                }
                $business->update($dataToUpdate);
                break;

            case 'login_page':
                $request->validate([
                    'login_background' => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:5120',
                    'login_image'      => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
                    'login_title'      => 'nullable|string|max:255',
                    'login_tagline'    => 'nullable|string|max:500',
                    'login_subtitle'   => 'nullable|string|max:500',
                    'login_copyright'  => 'nullable|string|max:255',
                ]);

                // Handle text fields
                $dataToUpdate['login_title']     = $request->input('login_title');
                $dataToUpdate['login_tagline']   = $request->input('login_tagline');
                $dataToUpdate['login_subtitle']  = $request->input('login_subtitle');
                $dataToUpdate['login_copyright'] = $request->input('login_copyright');

                // Handle image uploads
                if ($request->hasFile('login_background')) {
                    deleteFile($business->login_background);
                    $dataToUpdate['login_background'] = uploadFile($request->file('login_background'), 'business_setup/login');
                }
                if ($request->hasFile('login_image')) {
                    deleteFile($business->login_image);
                    $dataToUpdate['login_image'] = uploadFile($request->file('login_image'), 'business_setup/login');
                }
                $business->update($dataToUpdate);
                break;

            case 'system_settings':
                $validated = $request->validate([
                    'system_name'          => 'required|string|max:255',
                    'file_upload_max_size' => 'required|integer|min:1',
                ]);
                $business->update(array_merge($validated, $dataToUpdate));
                return response()->json([
                    'status'  => 'success',
                    'message' => 'System settings updated successfully.',
                    'data'    => $business
                ]);

            case 'backup':
                if ($request->filled('backup_time')) {
                    $backupTime = \Carbon\Carbon::parse($request->backup_time)->format('H:i');
                    $request->merge(['backup_time' => $backupTime]);
                }
                $request->validate([
                    'auto_backup_frequency' => 'required|string|in:Daily,Weekly',
                    'backup_time'           => 'required|date_format:H:i',
                    'backup_retention'      => 'required|integer|min:1',
                ]);
                $business->update($dataToUpdate);
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Backup settings updated successfully.',
                    'data'    => $business
                ]);

            /* NEW: Localization singleton */
            case 'localization':
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
                    array_merge($validated, $dataToUpdate)
                );
                break;

            /* NEW: Currency singleton */
            case 'currency':
                $validated = $request->validate([
                    'default_currency'  => 'required|string|in:BDT,USD,INR',
                    'fiscal_year_start' => 'required|string|in:January,April,July,October',
                    'usd_to_bdt_rate'   => 'required|numeric|min:0',
                ]);
                SystemCurrency::updateOrCreate(
                    ['id' => SystemCurrency::query()->value('id') ?? 1],
                    array_merge($validated, $dataToUpdate)
                );
                break;

            default:
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Invalid update part.'
                ], 400);
        }

        return response()->json([
            'status'  => 'success',
            'message' => ucfirst(str_replace('_', ' ', $part)) . ' updated successfully.'
        ]);
    }

    /* Holidays */
    public function publicHolidays()
    {
        return PublicHoliday::orderBy('date')->get();
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

    /* Documents */
    public function documents()
    {
        return OfficeDocument::orderBy('created_at', 'desc')->get();
    }

    public function documentsStore(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $path = $request->hasFile('file')
            ? uploadFile($request->file('file'), 'office_documents')
            : null;

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
        if ($document->file_path) deleteFile($document->file_path);
        $document->delete();

        return response()->json(['success' => true]);
    }

    /* Optional wrappers if you keep separate routes */
    public function updateLocalization(Request $request)
    {
        $request->merge(['part' => 'localization', '_method' => 'PUT']);
        $id = BusinessSetup::query()->value('id');
        return $this->updateAll($request, $id);
    }

    public function updateCurrency(Request $request)
    {
        Log::info($request->all());
        $request->merge(['part' => 'currency', '_method' => 'PUT']);
        $id = BusinessSetup::query()->value('id');
        return $this->updateAll($request, $id);
    }
    public function prefixUpdate(Request $request, $id)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'prefix_style' => 'nullable|string',
            'prefix_format' => 'nullable|string',
            'prefix_code' => 'nullable|string',
            'separators' => 'nullable|string',
            'digit_limit' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $prefix = Prefix::findOrFail($id);
            $prefix->update($request->only([
                'prefix_style',
                'prefix_format',
                'prefix_code',
                'separators',
                'digit_limit'
            ]));

            return response()->json([
                'status' => 'success',
                'message' => 'Prefix updated successfully.',
                'data' => $prefix
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
