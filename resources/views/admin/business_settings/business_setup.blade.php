@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: 15, 98, 106;
            --line: #e5e7eb;
            --muted: #6b7280;
            --radius: .65rem
        }

        body {
            background: #f5f7fb
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: .6rem
        }

        .qb-wizard-nav {
            display: flex;
            gap: .6rem;
            overflow: auto;
            padding: .6rem;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            background: #f8f9fa;
            margin-bottom: 1rem
        }

        .qb-wizard-tab {
            display: flex;
            gap: .6rem;
            align-items: center;
            padding: .55rem .85rem;
            border: 1px solid #e6e3ef;
            border-radius: .6rem;
            background: #fff;
            cursor: pointer;
            white-space: nowrap;
            transition: .2s
        }

        .qb-wizard-tab:hover {
            box-shadow: 0 1px 6px rgba(0, 0, 0, .08);
            transform: translateY(-1px)
        }

        .qb-wizard-tab.is-active {
            border-color: rgba(var(--primary), .7);
            box-shadow: 0 0 0 .15rem rgba(var(--primary), .1);
            background: rgba(var(--primary), .05)
        }

        .qb-wizard-tab-icon {
            font-size: 1.2rem;
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: .5rem;
            background: rgba(var(--primary), .12);
            color: rgba(var(--primary), 1)
        }

        .qb-wizard-tab.is-active .qb-wizard-tab-icon {
            background: rgba(var(--primary), 1);
            color: #fff
        }

        .panel {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: var(--radius)
        }

        .panel-header {
            padding: .75rem 1rem;
            border-bottom: 1px solid var(--line)
        }

        .panel-title {
            margin: 0;
            font-weight: 600
        }

        .panel-body {
            padding: 1rem
        }

        .panel-footer {
            padding: .75rem 1rem;
            border-top: 1px solid var(--line);
            background-color: #f8f9fa;
        }

        .small-muted {
            color: var(--muted);
            font-size: .875rem
        }

        .btn-primary {
            background: rgb(var(--primary));
            border: none
        }

        .tab-pane {
            display: none
        }

        .tab-pane.active {
            display: block
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f4f8ff;
            border: 1px solid #d8e6ff;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: .8rem
        }

        /* Social Media Section */
        .w-7 {
            width: 7%;
        }

        .w-15 {
            width: 15%;
        }

        .w-78 {
            width: 78%;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            background-color: #17a2b8;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            transform: translateX(16px);
        }

        /* Branding Cards */
        .setting-card-1 {
            border: 1px dashed #ddd;
        }

        .setting-button-1 {
            cursor: pointer;
            padding: 0.75rem;
            background-color: #f0f2f5;
            border-radius: 0.3rem;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="page-title">
            <h3 class="mb-0"><i class="bx bx-cog me-1"></i>Business Setup</h3>
            <span class="pill"><i class="bx bx-store-alt"></i> All core configurations for e-commerce</span>
        </div>
        <div class="d-flex gap-2">
            <button class="select-btn-info" id="btnExport"><i class="bx bx-download me-1"></i>Export JSON</button>
            <label class="select-btn-info mb-0" for="importFile"><i class="bx bx-upload me-1"></i>Import
                JSON</label>
            <input id="importFile" type="file" accept="application/json" class="d-none">
            <button class="btn btn-primary" id="btnSaveAll"><i class="bx bx-save me-1"></i>Save Changes</button>
        </div>
    </div>

    <div class="qb-wizard-nav" id="wizard-nav">
        <div class="qb-wizard-tab is-active" data-target="#tab-company">
            <div class="qb-wizard-tab-icon"><i class="bx bx-buildings"></i></div>
            <div>
                <h6 class="mb-0">Company & Business</h6><span class="small-muted">info & branding</span>
            </div>
        </div>
        <div class="qb-wizard-tab" data-target="#tab-contact">
            <div class="qb-wizard-tab-icon"><i class="bx bx-phone"></i></div>
            <div>
                <h6 class="mb-0">Contact & Social</h6><span class="small-muted">address & hotline</span>
            </div>
        </div>
        <div class="qb-wizard-tab" data-target="#tab-prefix">
            <div class="qb-wizard-tab-icon"><i class="bx bx-hash"></i></div>
            <div>
                <h6 class="mb-0">Localization</h6><span class="small-muted">order/invoice</span>
            </div>
        </div>
        <div class="qb-wizard-tab" data-target="#tab-docs">
            <div class="qb-wizard-tab-icon"><i class="bx bx-folder-open"></i></div>
            <div>
                <h6 class="mb-0">Branding & Documents</h6><span class="small-muted">license, BIN, TIN</span>
            </div>
        </div>
        <div class="qb-wizard-tab" data-target="#tab-storage">
            <div class="qb-wizard-tab-icon"><i class="bx bx-cloud"></i></div>
            <div>
                <h6 class="mb-0">System Settings</h6><span class="small-muted">local/S3</span>
            </div>
        </div>
    </div>

    <div id="wizard-content">
        <div class="tab-pane active" id="tab-company">
            <div class="row g-3">
                <div class="col-lg-12">
                    <form class="panel card-form" id="companyInfoForm" data-part="company_info">
                        <div class="panel-header d-flex justify-content-between align-items-center">
                            <h5 class="panel-title mb-0">Company Information</h5>
                            <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                        </div>
                        <div class="panel-body">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="form-group"><label>Company Name</label><input type="text"
                                            name="company_name" class="form-control"
                                            value="{{ $business_setup->company_name }}" disabled></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group"><label>Company Type</label>
                                        <select class="form-select" id="companyType" name="company_type" disabled>
                                            <option
                                                {{ $business_setup->company_type == 'Private Limited Company' ? 'selected' : '' }}>
                                                Private Limited Company</option>
                                            <option
                                                {{ $business_setup->company_type == 'Public Limited Company' ? 'selected' : '' }}>
                                                Public Limited Company</option>
                                            <option {{ $business_setup->company_type == 'Partnership' ? 'selected' : '' }}>
                                                Partnership</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group"><label>Industry</label><input type="text" name="industry"
                                            class="form-control" value="{{ $business_setup->industry }}" disabled></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group"><label>Establishment Date</label><input type="date"
                                            name="establishment_date" class="form-control"
                                            value="{{ $business_setup->establishment_date }}" disabled></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-end d-none"><button type="button"
                                class="btn btn-secondary btn-sm cancel-card-btn me-2">Cancel</button><button type="button"
                                class="btn btn-success btn-sm save-card-btn">Save</button></div>
                    </form>
                    <form class="panel mt-3 card-form" id="legalNumbersForm" data-part="legal_numbers">
                        <div class="panel-header d-flex justify-content-between align-items-center">
                            <h6 class="panel-title mb-0">Legal & Official Numbers</h6>
                            <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Company Registration Number</label><input
                                            type="text" name="company_registration_number" class="form-control"
                                            value="{{ $business_setup->company_registration_number }}" disabled></div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Trade License Number</label><input type="text"
                                            name="trade_license_number" class="form-control"
                                            value="{{ $business_setup->trade_license_number }}" disabled></div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>BIN/VAT Number</label><input type="text"
                                            name="bin_vat_number" class="form-control"
                                            value="{{ $business_setup->bin_vat_number }}" disabled></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-end d-none"><button type="button"
                                class="btn btn-secondary btn-sm cancel-card-btn me-2">Cancel</button><button
                                type="button" class="btn btn-success btn-sm save-card-btn">Save</button></div>
                    </form>
                    <form class="panel mt-3 card-form" id="addressForm" data-part="address">
                        <div class="panel-header d-flex justify-content-between align-items-center">
                            <h6 class="panel-title mb-0">Address Information</h6>
                            <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                        </div>
                        <div class="panel-body">
                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <div class="form-group"><label>Street Address</label>
                                        <textarea class="form-control" name="street_address" rows="2" disabled>{{ $business_setup->street_address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group"><label>City / Thana</label><input type="text"
                                            class="form-control" name="city_thana"
                                            value="{{ $business_setup->city_thana }}" disabled></div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group"><label>District</label><input type="text"
                                            class="form-control" name="district" value="{{ $business_setup->district }}"
                                            disabled></div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group"><label>Zip Code</label><input type="text"
                                            class="form-control" name="zip_code" value="{{ $business_setup->zip_code }}"
                                            disabled></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-end d-none"><button type="button"
                                class="btn btn-secondary btn-sm cancel-card-btn me-2">Cancel</button><button
                                type="button" class="btn btn-success btn-sm save-card-btn">Save</button></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab-contact">
            <form class="panel card-form" id="contactForm" data-part="contact_info">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0">Contact Information</h5>
                    <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <!-- Official -->
                        <div class="col-lg-6">
                            <div class="form-group"><label>Official Contact Number(s)</label>
                                <div class="repeater" id="rp-official">
                                    @php $vals = $business_setup->official_contact_number; @endphp
                                    @if (empty($vals))
                                        @php $vals=['']; @endphp
                                    @endif
                                    @foreach ($vals as $v)
                                        <div class="input-group mb-2">
                                            <input type="text" name="official_contact_number[]" class="form-control"
                                                value="{{ $v }}" disabled>
                                            <button type="button" class="action-btn-danger remove"
                                                disabled>&times;</button>
                                        </div>
                                    @endforeach
                                    <button type="button" class="select-btn-white add" disabled>Add
                                        official</button>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="col-lg-6">
                            <div class="form-group"><label>WhatsApp Number(s)</label>
                                <div class="repeater" id="rp-whatsapp">
                                    @php
                                        $vals = $business_setup->whatsapp_number;
                                        if (empty($vals)) {
                                            $vals = [''];
                                        }
                                    @endphp
                                    @foreach ($vals as $v)
                                        <div class="input-group mb-2">
                                            <input type="text" name="whatsapp_number[]" class="form-control"
                                                value="{{ $v }}" disabled>
                                            <button type="button" class="action-btn-danger remove"
                                                disabled>&times;</button>
                                        </div>
                                    @endforeach
                                    <button type="button" class="select-btn-white add" disabled>Add
                                        WhatsApp</button>
                                </div>
                            </div>
                        </div>

                        <!-- Hotline -->
                        <div class="col-lg-6">
                            <div class="form-group"><label>Hotline Number(s)</label>
                                <div class="repeater" id="rp-hotline">
                                    @php
                                        $vals = $business_setup->hotline_number;
                                        if (empty($vals)) {
                                            $vals = [''];
                                        }
                                    @endphp
                                    @foreach ($vals as $v)
                                        <div class="input-group mb-2">
                                            <input type="text" name="hotline_number[]" class="form-control"
                                                value="{{ $v }}" disabled>
                                            <button type="button" class="action-btn-danger remove"
                                                disabled>&times;</button>
                                        </div>
                                    @endforeach
                                    <button type="button" class="select-btn-white add" disabled>Add
                                        hotline</button>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-lg-6">
                            <div class="form-group"><label>Email Address(es)</label>
                                <div class="repeater" id="rp-email">
                                    @php
                                        $vals = $business_setup->email_address;
                                        if (empty($vals)) {
                                            $vals = [''];
                                        }
                                    @endphp
                                    @foreach ($vals as $v)
                                        <div class="input-group mb-2">
                                            <input type="email" name="email_address[]" class="form-control"
                                                value="{{ $v }}" disabled>
                                            <button type="button" class="action-btn-danger remove"
                                                disabled>&times;</button>
                                        </div>
                                    @endforeach
                                    <button type="button" class="select-btn-white add" disabled>Add
                                        email</button>
                                </div>
                            </div>
                        </div>

                        <!-- Keep existing singles -->
                        <div class="col-lg-4">
                            <div class="form-group"><label>Landline Number</label>
                                <input type="text" name="landline_number" class="form-control"
                                    value="{{ $business_setup->landline_number }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group"><label>Website Address</label>
                                <input type="url" name="website_address" class="form-control"
                                    value="{{ $business_setup->website_address }}" disabled>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="panel-footer text-end d-none"><button type="button"
                        class="btn btn-secondary btn-sm cancel-card-btn me-2">Cancel</button><button type="button"
                        class="btn btn-success btn-sm save-card-btn">Save</button></div>
            </form>
            <form class="panel mt-3 card-form" id="socialForm" data-part="social_media">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0">Social Media Information</h5>
                    <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="form-group"><label>Facebook</label>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="w-7"><button type="button" class="action-btn"><i
                                                class="bx bxl-facebook"></i></button></div>
                                    <div class="w-78"><input type="text" name="facebook_url" class="form-control"
                                            value="{{ $business_setup->facebook_url }}" disabled></div>
                                    <div class="w-15"><label class="toggle-switch"><input type="checkbox"
                                                name="facebook_status"
                                                {{ $business_setup->facebook_status == '1' ? 'checked' : '' }}
                                                disabled><span class="slider"></span></label></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group"><label>LinkedIn</label>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="w-7"><button type="button" class="action-btn"><i
                                                class="bx bxl-linkedin"></i></button></div>
                                    <div class="w-78"><input type="text" name="linkedin_url" class="form-control"
                                            value="{{ $business_setup->linkedin_url }}" disabled></div>
                                    <div class="w-15"><label class="toggle-switch"><input type="checkbox"
                                                name="linkedin_status"
                                                {{ $business_setup->linkedin_status == '1' ? 'checked' : '' }}
                                                disabled><span class="slider"></span></label></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group"><label>Youtube</label>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="w-7"><button type="button" class="action-btn"><i
                                                class="bx bxl-youtube"></i></button></div>
                                    <div class="w-78"><input type="text" name="youtube_url" class="form-control"
                                            value="{{ $business_setup->youtube_url }}" disabled></div>
                                    <div class="w-15"><label class="toggle-switch"><input type="checkbox"
                                                name="youtube_status"
                                                {{ $business_setup->youtube_status == '1' ? 'checked' : '' }}
                                                disabled><span class="slider"></span></label></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group"><label>Twitter</label>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="w-7"><button type="button" class="action-btn"><i
                                                class="bx bxl-twitter"></i></button></div>
                                    <div class="w-78"><input type="text" name="twitter_url" class="form-control"
                                            value="{{ $business_setup->twitter_url }}" disabled></div>
                                    <div class="w-15"><label class="toggle-switch"><input type="checkbox"
                                                name="twitter_status"
                                                {{ $business_setup->twitter_status == '1' ? 'checked' : '' }}
                                                disabled><span class="slider"></span></label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-end d-none"><button type="button"
                        class="btn btn-secondary btn-sm cancel-card-btn me-2">Cancel</button><button type="button"
                        class="btn btn-success btn-sm save-card-btn">Save</button></div>
            </form>
        </div>

        <div class="tab-pane" id="tab-prefix">
            {{-- Localization Settings --}}
            <form class="panel card-form" id="localizationForm" data-part="localization">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0"><i class="bx bx-globe me-2"></i>Localization Settings</h5>
                    <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>System Language</label>
                                <select name="system_language" class="form-select custom-input-s" disabled>
                                    @php $lang = $localization->system_language ?? 'bn'; @endphp
                                    <option value="en" {{ $lang === 'en' ? 'selected' : '' }}>English</option>
                                    <option value="bn" {{ $lang === 'bn' ? 'selected' : '' }}>Bengali</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Timezone</label>
                                <select name="timezone" class="form-select custom-input-s" disabled>
                                    @php $tz = $localization->timezone ?? 'Asia/Dhaka'; @endphp
                                    <option value="Asia/Dhaka" {{ $tz === 'Asia/Dhaka' ? 'selected' : '' }}>(GMT+6:00) Dhaka
                                    </option>
                                    <option value="Asia/Kolkata" {{ $tz === 'Asia/Kolkata' ? 'selected' : '' }}>(GMT+5:30)
                                        Kolkata</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Default Currency</label>
                                <select name="default_currency" class="form-select custom-input-s" disabled>
                                    @php $dc = $localization->default_currency ?? 'BDT'; @endphp
                                    <option value="BDT" {{ $dc === 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                    <option value="USD" {{ $dc === 'USD' ? 'selected' : '' }}>USD ($)</option>
                                    <option value="INR" {{ $dc === 'INR' ? 'selected' : '' }}>INR (₹)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Date Format</label>
                                @php $df = $localization->date_format ?? 'd-m-Y'; @endphp
                                <select name="date_format" class="form-select custom-input-s" disabled>
                                    <option value="d-m-Y" {{ $df === 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY (29-07-2025)
                                    </option>
                                    <option value="m/d/Y" {{ $df === 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY (07/29/2025)
                                    </option>
                                    <option value="Y-m-d" {{ $df === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD (2025-07-29)
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Time Format</label>
                                @php $tf = $localization->time_format ?? '12'; @endphp
                                <select name="time_format" class="form-select custom-input-s" disabled>
                                    <option value="12" {{ $tf === '12' ? 'selected' : '' }}>12-hour (08:30 AM)</option>
                                    <option value="24" {{ $tf === '24' ? 'selected' : '' }}>24-hour (20:30)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Currency Decimal Places</label>
                                <input type="number" name="currency_decimals" class="form-control custom-input-s"
                                    value="{{ $localization->currency_decimals ?? 2 }}" min="0" max="4"
                                    readonly disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-end d-none">
                    <button type="button" class="btn btn-secondary btn-sm cancel-card-btn">Cancel</button>
                    <button type="button" class="btn btn-success btn-sm save-card-btn">Save</button>
                </div>
            </form>

            {{-- Currencies & Exchange Rates --}}
            <form class="panel mt-3 card-form" id="currencyForm" data-part="currency">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0"><i class="bx bx-money me-2"></i>Currencies & Exchange Rates</h5>
                    <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Default Currency</label>
                                @php $cdc = $currency->default_currency ?? 'BDT'; @endphp
                                <select name="default_currency" class="form-select custom-input-s" disabled>
                                    <option value="BDT" {{ $cdc === 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                    <option value="USD" {{ $cdc === 'USD' ? 'selected' : '' }}>USD ($)</option>
                                    <option value="INR" {{ $cdc === 'INR' ? 'selected' : '' }}>INR (₹)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Fiscal Year Start</label>
                                @php $fy = $currency->fiscal_year_start ?? 'July'; @endphp
                                <select name="fiscal_year_start" class="form-select custom-input-s" disabled>
                                    @foreach (['January', 'April', 'July', 'October'] as $m)
                                        <option value="{{ $m }}" {{ $fy === $m ? 'selected' : '' }}>
                                            {{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>USD to BDT Exchange Rate</label>
                                <input type="number" step="0.01" name="usd_to_bdt_rate" class="form-control"
                                    value="{{ number_format((float) ($currency->usd_to_bdt_rate ?? 118.5), 2, '.', '') }}"
                                    readonly disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-end d-none">
                    <button type="button" class="btn btn-secondary btn-sm cancel-card-btn">Cancel</button>
                    <button type="button" class="btn btn-success btn-sm save-card-btn">Save</button>
                </div>
            </form>

            {{-- Public Holidays --}}
            <div class="panel mt-3">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0"><i class="bx bx-calendar-event me-2"></i>Public Holidays</h5>
                    <span class="qbit-badge-light"><i class="bx bx-calendar"></i> Year: {{ date('Y') }}</span>
                </div>
                <div class="panel-body">
                    <div class="row g-3 align-items-start">
                        <div class="col-12 col-lg-4">
                            <form id="holidayForm" class="p-3 border rounded">
                                <h6 class="mb-3">Add Holiday</h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="date" class="form-control" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Occasion / Reason</label>
                                        <input type="text" name="occasion" class="form-control"
                                            placeholder="e.g., Independence Day" required>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bx bx-plus me-1"></i>Add
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-12 col-lg-8 d-flex flex-column">
                            <h6 class="mb-2">Existing Holidays</h6>
                            <div class="table-responsive flex-grow-1">
                                <table class="table table-striped table-bordered mb-0" id="holidaysTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Occasion</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Operational Hours --}}
            <form class="panel mt-3 card-form" id="opHoursForm" data-part="operational_hours">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0"><i class="bx bx-time me-2"></i>Operational Hours</h5>
                    <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table operational-hours-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Day</th>
                                    <th>Status</th>
                                    <th>Office Start Time</th>
                                    <th>Office End Time</th>
                                </tr>
                            </thead>
                            @foreach ($operational_hours as $hour)
                                <tr>
                                    <td>{{ $hour->day }}</td>
                                    <td>
                                        <select class="form-select" id="{{ strtolower($hour->day) }}"
                                            name="status_{{ $hour->day }}" disabled>
                                            <option value="Working Day" {{ $hour->status == 'Working Day' ? 'selected' : '' }}>
                                                Working Day</option>
                                            <option value="Holiday" {{ $hour->status == 'Holiday' ? 'selected' : '' }}>Holiday
                                            </option>
                                        </select>
                                    </td>
                                    <td><input type="time" class="form-control" name="start_{{ $hour->day }}"
                                            value="{{ $hour->start_time }}" disabled></td>
                                    <td><input type="time" class="form-control" name="end_{{ $hour->day }}"
                                            value="{{ $hour->end_time }}" disabled></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="panel-footer text-end d-none">
                    <button type="button" class="btn btn-secondary btn-sm cancel-card-btn me-2">Cancel</button>
                    <button type="button" class="btn btn-success btn-sm save-card-btn">Save</button>
                </div>
            </form>
        </div>

        <div class="tab-pane" id="tab-docs">
            <form class="panel card-form" id="brandingForm" data-part="branding" method="PUT"
                enctype="multipart/form-data">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0"><i class="bx bx-palette me-2"></i>Company Branding</h5>
                    <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-lg-4 col-sm-6">
                            <div class="panel setting-card-1">
                                <div class="panel-header">
                                    <h5 class="panel-title">Main Logo</h5>
                                </div>
                                <div class="panel-body text-center"><img alt="Main logo"
                                        src="{{ asset('storage/' . $business_setup->logo) }}" class="my-3"><label
                                        class="setting-button-1 w-100"><i class="bx bx-cloud-upload"></i> Choose
                                        file<input type="file" name="logo" class="d-none" accept="image/*"
                                            disabled></label></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="panel setting-card-1">
                                <div class="panel-header">
                                    <h5 class="panel-title">Alternative Logo</h5>
                                </div>
                                <div class="panel-body text-center"><img alt="Alt logo"
                                        src="{{ asset('storage/' . $business_setup->alt_logo) }}" class="my-3"><label
                                        class="setting-button-1 w-100"><i class="bx bx-cloud-upload"></i> Choose
                                        file<input type="file" name="alt_logo" class="d-none" accept="image/*"
                                            disabled></label></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="panel setting-card-1">
                                <div class="panel-header">
                                    <h5 class="panel-title">Favicon</h5>
                                </div>
                                <div class="panel-body text-center"><img alt="Favicon"
                                        src="{{ asset('storage/' . $business_setup->favicon) }}" class="my-3"><label
                                        class="setting-button-1 w-100"><i class="bx bx-cloud-upload"></i> Choose
                                        file<input type="file" name="favicon" class="d-none" accept="image/*"
                                            disabled></label></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-end d-none"><button type="button"
                        class="btn btn-secondary btn-sm cancel-card-btn me-2">Cancel</button><button type="button"
                        class="btn btn-success btn-sm save-card-btn">Save</button></div>
            </form>

            <form class="panel mt-3 card-form" id="loginPageForm" data-part="login_page" method="PUT"
                enctype="multipart/form-data">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0"><i class="bx bx-log-in me-2"></i>Login Page Customization</h5>
                    <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <!-- Login Page Images -->
                        <div class="col-lg-6 col-sm-6">
                            <div class="panel setting-card-1">
                                <div class="panel-header">
                                    <h5 class="panel-title">Login Background Image</h5>
                                </div>
                                <div class="panel-body text-center">
                                    <img alt="Login Background" style="max-height: 120px; object-fit: cover;"
                                        src="{{ $business_setup->login_background ? asset('storage/' . $business_setup->login_background) : asset('frontend/assets/images/page-bg.jpg') }}" class="my-3 img-fluid rounded">
                                    <label class="setting-button-1 w-100"><i class="bx bx-cloud-upload"></i> Choose file
                                        <input type="file" name="login_background" class="d-none" accept="image/*" disabled>
                                    </label>
                                    <small class="text-muted d-block mt-1">Recommended: 1920x1080px</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="panel setting-card-1">
                                <div class="panel-header">
                                    <h5 class="panel-title">Login Illustration Image</h5>
                                </div>
                                <div class="panel-body text-center">
                                    <img alt="Login Image" style="max-height: 120px; object-fit: cover;"
                                        src="{{ $business_setup->login_image ? asset('storage/' . $business_setup->login_image) : 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400&h=300&fit=crop' }}" class="my-3 img-fluid rounded">
                                    <label class="setting-button-1 w-100"><i class="bx bx-cloud-upload"></i> Choose file
                                        <input type="file" name="login_image" class="d-none" accept="image/*" disabled>
                                    </label>
                                    <small class="text-muted d-block mt-1">Recommended: 400x300px</small>
                                </div>
                            </div>
                        </div>

                        <!-- Login Page Text Fields -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Login Page Title</label>
                                <input type="text" name="login_title" class="form-control"
                                    value="{{ $business_setup->login_title ?? '' }}"
                                    placeholder="e.g., QBit BMS - Ecosystem" disabled>
                                <small class="text-muted">Displayed as the main heading on login page</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Login Page Tagline</label>
                                <input type="text" name="login_tagline" class="form-control"
                                    value="{{ $business_setup->login_tagline ?? '' }}"
                                    placeholder="e.g., An Integrated Ecosystem of 10 Powerful Applications" disabled>
                                <small class="text-muted">Displayed below the illustration image</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Login Subtitle</label>
                                <input type="text" name="login_subtitle" class="form-control"
                                    value="{{ $business_setup->login_subtitle ?? '' }}"
                                    placeholder="e.g., Unlock Ultimate Efficiency with the Complete Suite." disabled>
                                <small class="text-muted">Displayed below "Sign In" heading</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Login Copyright Text</label>
                                <input type="text" name="login_copyright" class="form-control"
                                    value="{{ $business_setup->login_copyright ?? '' }}"
                                    placeholder="e.g., Copyright © 2025 - QBit Tech" disabled>
                                <small class="text-muted">Displayed at the bottom of login page</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-end d-none">
                    <button type="button" class="btn btn-secondary btn-sm cancel-card-btn me-2">Cancel</button>
                    <button type="button" class="btn btn-success btn-sm save-card-btn">Save</button>
                </div>
            </form>
            <div class="panel mt-3">
                <div class="panel-header">
                    <h5 class="panel-title mb-0"><i class="bx bx-folder-open me-2"></i>Official Documents</h5>
                </div>

                <div class="panel-body">
                    <div class="row g-3">
                        <!-- Left: Form (col-4) -->
                        <div class="col-12 col-lg-4">
                            <div class="p-3 border rounded h-100">
                                <h6 class="mb-3">Upload New Document</h6>
                                <form id="documentForm" enctype="multipart/form-data">
                                    <div class="row align-items-end g-3">
                                        <div class="col-12">
                                            <label class="form-label" for="documentType">Document Type</label>
                                            <select name="type" class="form-select" id="documentType" required>
                                                <option value="Trade License">Trade License</option>
                                                <option value="TIN Certificate / VAT Certificate">TIN Certificate / VAT
                                                    Certificate</option>
                                                <option value="BIN (Business Identification Number)">BIN (Business
                                                    Identification Number)</option>
                                                <option value="Company Registration Certificate">Company Registration
                                                    Certificate</option>
                                                <option value="Trade Mark / Intellectual Property Certificates">Trade Mark
                                                    / Intellectual Property Certificates</option>
                                                <option value="Professional Licenses">Professional Licenses</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label" for="documentFile">Choose File</label>
                                            <input type="file" id="documentFile" name="file" class="form-control"
                                                required>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="bx bx-upload me-1"></i>Upload Document
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Right: Table (col-8) -->
                        <div class="col-12 col-lg-8">
                            <h6 class="mb-2">Uploaded Documents</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="documentsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Document Type</th>
                                            <th>Uploaded On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="tab-pane" id="tab-storage">
            <form class="panel mt-3 card-form" id="systemSettingsForm" data-part="system_settings">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0"><i class="bx bx-cog me-2"></i>General System Settings</h5>
                    <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="form-group"><label>System Name</label><input type="text" name="system_name"
                                    class="form-control" value="QBit BMS" disabled></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group"><label>File Upload Max Size (MB)</label><input type="number"
                                    name="file_upload_max_size" class="form-control" value="10" disabled></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-end d-none"><button type="button"
                        class="btn btn-secondary btn-sm cancel-card-btn me-2">Cancel</button><button type="button"
                        class="btn btn-success btn-sm save-card-btn">Save</button></div>
            </form>
            <form class="panel mt-3 card-form" id="backupForm" data-part="backup">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <h5 class="panel-title mb-0"><i class="bx bx-data me-2"></i>Backup & Maintenance</h5>
                    <button type="button" class="select-btn-primary edit-card-btn">Edit</button>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-lg-4">
                            <div class="form-group"><label>Auto Backup Frequency</label><select class="form-select"
                                    name="auto_backup_frequency" id="autoBackupFrequency" disabled>
                                    <option {{ $business_setup->auto_backup_frequency == 'Daily' ? 'selected' : '' }}>Daily
                                    </option>
                                    <option {{ $business_setup->auto_backup_frequency == 'Weekly' ? 'selected' : '' }}>
                                        Weekly</option>
                                </select></div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group"><label>Backup Time</label><input type="time" name="backup_time"
                                    class="form-control" value="{{ $business_setup->backup_time }}" disabled></div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group"><label>Backup Retention (days)</label><input type="number"
                                    name="backup_retention" class="form-control"
                                    value="{{ $business_setup->backup_retention }}" disabled></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-end d-none"><button type="button"
                        class="btn btn-secondary btn-sm cancel-card-btn me-2">Cancel</button><button type="button"
                        class="btn btn-success btn-sm save-card-btn">Save</button></div>
            </form>

            <div class="panel mt-3">
                <div class="panel-header">
                    <h5 class="panel-title mb-0"><i class="bx bx-list-check me-2"></i>System Prefixes Management</h5>
                </div>
                <div class="panel-body">
                    <div class="page-inner">
                        <style>
                            .vertical-btn {
                                transform: rotate(90deg);
                                transform-origin: right top;
                                display: inline-block;
                                padding: 5px 35px;
                                bottom: -34px !important;
                                right: 5px;
                            }

                            /* Make radio look like checkbox with tick */
                            .form-check-input[type="radio"].checkbox-style {
                                appearance: none;
                                -webkit-appearance: none;
                                background-color: #fff;
                                border: 1px solid #348101;
                                width: 1em;
                                height: 1em;
                                border-radius: 0.15em;
                                display: inline-block;
                                position: relative;
                                margin-right: 5px;
                                cursor: pointer;
                                vertical-align: middle;
                            }

                            .form-check-input[type="radio"].checkbox-style:checked::before {
                                content: '✔';
                                position: absolute;
                                font-size: 0.9em;
                                color: #348101;
                                top: 50%;
                                left: 50%;
                                transform: translate(-50%, -55%);
                                font-weight: bold;
                            }
                        </style>

                        @foreach ($prefixes as $prefix)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-round">
                                        <div class="card-body">
                                            <form class="prefix-update-form"
                                                action="{{ route('admin.users.business-setup.prefix-update', $prefix->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="custom-border-success-1 custom-bg-success-100 rounded">
                                                            <div class="card-body p-2">
                                                                <a class="align-items-center" data-bs-toggle="collapse"
                                                                    href="#project-head" role="button"
                                                                    aria-expanded="true" aria-controls="project-head">
                                                                    <h5
                                                                        class="p-0 m-0 d-flex align-items-center justify-content-center client-main-title">
                                                                        {{ Str::title(str_replace('_', ' ', $prefix->prefix_name)) }}
                                                                        <i class="bx bx-badge-check text-success"></i>
                                                                    </h5>
                                                                </a>
                                                            </div>
                                                            <div class="pt-0 pb-2 card-body client-details-inner">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center">
                                                                                <label>{{ Str::title(str_replace('_', ' ', $prefix->prefix_name)) }}
                                                                                    Prefix</label>
                                                                                <button type="button"
                                                                                    data-bs-toggle="tooltip"
                                                                                    class="btn btn-link btn-success btn-lg">
                                                                                    <i class="bx bxs-edit"></i>
                                                                                </button>
                                                                            </div>
                                                                            <input type="text"
                                                                                class="form-control custom-input"
                                                                                id="prefix_style_{{ $prefix->id }}"
                                                                                placeholder="{{ Str::title(str_replace('_', ' ', $prefix->prefix_name)) }} Prefix"
                                                                                name="prefix_style"
                                                                                value="{{ $prefix->prefix_style }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-9 pe-5 ps-0 position-relative">
                                                        <div class="custom-border-success-1 pb-3 rounded">
                                                            <div class="card-body p-2">
                                                                <a class="align-items-center" data-bs-toggle="collapse"
                                                                    href="#project-head" role="button"
                                                                    aria-expanded="true" aria-controls="project-head">
                                                                    <h5
                                                                        class="p-0 m-0 d-flex align-items-center justify-content-center client-main-title">
                                                                        Prefix Configure <i
                                                                            class="bx bx-badge-check text-success ms-1"></i>
                                                                    </h5>
                                                                </a>
                                                            </div>

                                                            <div class="pt-2 pb-2 card-body client-details-inner">
                                                                <div class="row prefix-format-group"
                                                                    data-prefix-id="{{ $prefix->id }}">
                                                                    <div class="col-md-6">
                                                                        <label class="pb-2" for="prefix_format">Please
                                                                            Select Prefix Format</label>
                                                                        <div
                                                                            class="d-sm-flex align-items-center justify-content-between">
                                                                            @php
                                                                                $formats = [
                                                                                    'CODE-DD-MM-01',
                                                                                    'CODE-MM-01',
                                                                                    'CODE-DDMM-01',
                                                                                ];
                                                                            @endphp
                                                                            @foreach ($formats as $i => $format)
                                                                                <div class="form-check me-3">
                                                                                    <input
                                                                                        class="form-check-input checkbox-style"
                                                                                        type="radio"
                                                                                        name="prefix_format"
                                                                                        value="{{ $format }}"
                                                                                        id="format_{{ $prefix->id }}_{{ $i }}"
                                                                                        {{ $prefix->prefix_format == $format ? 'checked' : '' }}>
                                                                                    <label
                                                                                        class="form-check-label fs-12 fw-300 text-black-1"
                                                                                        for="format_{{ $prefix->id }}_{{ $i }}">
                                                                                        {{ $format }}
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-2 pe-2">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="prefix_code_{{ $prefix->id }}">Prefix
                                                                                Code</label>
                                                                            <input type="text"
                                                                                class="form-control custom-input"
                                                                                id="prefix_code_{{ $prefix->id }}"
                                                                                name="prefix_code"
                                                                                value="{{ $prefix->prefix_code }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2 px-2">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="separators_{{ $prefix->id }}">Separators</label>
                                                                            <input type="text"
                                                                                class="form-control custom-input"
                                                                                id="separators_{{ $prefix->id }}"
                                                                                name="separators"
                                                                                value="{{ $prefix->separators }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2 ps-2">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="digit_limit_{{ $prefix->id }}">Digit
                                                                                Limit</label>
                                                                            <input type="number" min="1"
                                                                                class="form-control custom-input"
                                                                                id="digit_limit_{{ $prefix->id }}"
                                                                                name="digit_limit"
                                                                                value="{{ $prefix->digit_limit }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-start">
                                                                <button type="submit"
                                                                    class="btn btn-primary vertical-btn position-absolute">SUBMIT</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>




    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(function() {
                /* ===========================
                 * Constants
                 * =========================== */
                const BUSINESS_ID = "{{ $business_setup->id }}";
                const ROUTES = {
                    update: "{{ route('admin.users.business-setup.update', ':id') }}".replace(':id', BUSINESS_ID),
                    holidaysIndex: "{{ route('admin.users.business-setup.public-holidays') }}",
                    holidaysStore: "{{ route('admin.users.business-setup.public-holidays.store') }}",
                    holidaysDelete: "/admin/business-setup/public-holiday/destroy/", // + id
                    docsIndex: "{{ route('admin.users.business-setup.documents') }}",
                    docsStore: "{{ route('admin.users.business-setup.documents.store') }}",
                    docsDeleteBase: "{{ url('admin/business-setup/documents') }}", // + /:id
                };

                /* ===========================
                 * Global AJAX CSRF
                 * =========================== */
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                /* ===========================
                 * Select2
                 * =========================== */
                function initSelect2(scope) {
                    const $scope = scope ? $(scope) : $(document);

                    // Known selects
                    $scope.find(
                            '#companyType, #documentType, #autoBackupFrequency, #sunday, #monday, #tuesday, #wednesday, #thursday, #friday, #saturday'
                            )
                        .filter('select')
                        .each(function() {
                            if ($(this).data('select2')) $(this).select2('destroy');
                            $(this).select2({
                                theme: 'bootstrap-5',
                                width: '100%'
                            });
                        });

                    // Localization small selects
                    $scope.find('select.custom-input-s').each(function() {
                        if ($(this).data('select2')) $(this).select2('destroy');
                        $(this).select2({
                            theme: 'bootstrap-5',
                            width: '100%'
                        });
                    });
                }
                initSelect2();

                /* ===========================
                 * Repeater helpers
                 * =========================== */
               // --- Repeater helpers (replace your cloneInputGroup + hydrateRepeaters + bindRepeater) ---
function cloneInputGroup(wrap, value, disabledState) {
  const first = wrap.querySelector('.input-group');
  if (!first) return;
  const clone = first.cloneNode(true);
  const input = clone.querySelector('input');
  input.value = value ?? '';
  input.defaultValue = input.value;            // keep reset() harmless
  input.disabled = !!disabledState;
  clone.querySelectorAll('button').forEach(b => b.disabled = !!disabledState);
  wrap.insertBefore(clone, wrap.querySelector('.add'));
}

function hydrateRepeaters(scope) {
  (scope ? $(scope) : $(document)).find('.repeater').each(function () {
    const wrap = this;
    if (wrap.dataset.hydrated === '1') return; // hydrate once only

    const firstGroup = wrap.querySelector('.input-group');
    if (!firstGroup) { wrap.dataset.hydrated = '1'; return; }

    const firstInput = firstGroup.querySelector('input');
    if (!firstInput) { wrap.dataset.hydrated = '1'; return; }

    const raw = String(firstInput.value || '').trim();
    let arr = null;

    // Only parse when it looks like JSON array
    if (raw.startsWith('[') && raw.endsWith(']')) {
      try { arr = JSON.parse(raw); } catch { arr = null; }
    }

    if (Array.isArray(arr) && arr.length) {
      const disabledState = firstInput.disabled;
      // set first
      firstInput.value = arr[0] ?? '';
      firstInput.defaultValue = firstInput.value; // protect reset()
      // add rest
      for (let i = 1; i < arr.length; i++) cloneInputGroup(wrap, arr[i], disabledState);
    } else {
      // single value: lock default to visible value so reset() won't inject brackets later
      firstInput.defaultValue = firstInput.value;
    }

    wrap.dataset.hydrated = '1';
  });
}

function bindRepeater(container) {
  const root = container instanceof Element ? container : document;
  root.querySelectorAll('.repeater').forEach(function (wrap) {
    wrap.addEventListener('click', function (e) {
      if (e.target.closest('.add')) {
        const first = wrap.querySelector('.input-group');
        if (!first) return;
        const clone = first.cloneNode(true);
        clone.querySelectorAll('input').forEach(i => {
          i.value = '';
          i.defaultValue = '';                 // protect reset()
          i.disabled = false;
        });
        clone.querySelectorAll('button').forEach(b => b.disabled = false);
        wrap.insertBefore(clone, wrap.querySelector('.add'));
      }
      if (e.target.closest('.remove')) {
        const row = e.target.closest('.input-group');
        const rows = wrap.querySelectorAll('.input-group');
        if (rows.length > 1) row.remove();
        else {
          const i = row.querySelector('input');
          i.value = '';
          i.defaultValue = '';
        }
      }
    });
  });
}

// call once after DOM ready, before snapshots
bindRepeater(document);
hydrateRepeaters(document);


                /* ===========================
                 * Card forms: edit / save / cancel
                 * =========================== */
                $('.card-form').each(function() {
                    const form = $(this);
                    const editBtn = form.find('.edit-card-btn');
                    const saveBtn = form.find('.save-card-btn');
                    const cancelBtn = form.find('.cancel-card-btn');
                    const footer = form.find('.panel-footer, .card-footer'); // support both
                    const part = form.data('part');

                    // snapshot repeater HTML after hydration so cancel restores clean state
                    hydrateRepeaters(form[0]);
                    const repeaterSnapshot = {};
                    form.find('.repeater').each(function(i, el) {
                        repeaterSnapshot[i] = el.innerHTML;
                    });

                    function togglables() {
                        return form.find('input, select, textarea, .repeater .add, .repeater .remove');
                    }

                    function toggleFormState(isEditing) {
                        const $tog = togglables();
                        $tog.prop('disabled', !isEditing);

                        // currency card special: rate becomes readonly only in view mode
                        if (part === 'currency') {
                            form.find('input[name="usd_to_bdt_rate"]').prop('readonly', !isEditing);
                        }

                        // branding file inputs
                        if (part === 'branding') {
                            form.find('input[type="file"]').prop('disabled', !isEditing);
                        }

                        // keep Select2 UI synced
                        form.find('select').each(function() {
                            $(this).trigger('change.select2');
                        });

                        if (editBtn.length) editBtn.toggleClass('d-none', isEditing);
                        if (footer.length) footer.toggleClass('d-none', !isEditing);
                    }

                    editBtn.on('click', function(e) {
                        e.preventDefault();
                        toggleFormState(true);
                    });

                   // --- inside $('.card-form').each(...) ---
cancelBtn.on('click', function (e) {
  e.preventDefault();

  // 1) reset non-repeater fields to their defaults
  form[0].reset();

  // 2) restore repeater HTML snapshot AFTER reset so brackets can't come back
  form.find('.repeater').each(function (i, el) {
    el.innerHTML = repeaterSnapshot[i];
    // rebind clicks and lock defaults of visible values
    bindRepeater(el);
    $(el).find('input').each(function () {
      this.defaultValue = this.value;
    });
    // mark hydrated to prevent any future auto-hydration here
    el.dataset.hydrated = '1';
  });

  // 3) lock view mode
  toggleFormState(false);
});


                    saveBtn.on('click', function(e) {
                        e.preventDefault();
                        const fd = new FormData(form[0]);
                        fd.append('part', part);
                        fd.append('_method', 'PUT');

                        if (part === 'operational_hours') {
                            let hours = {};
                            form.find('.operational-hours-table tbody tr').each(function() {
                                const day = $(this).find('td:first').text().trim();
                                const status = $(this).find('select').val();
                                const start_time = $(this).find('input[type="time"]').eq(0)
                                .val();
                                const end_time = $(this).find('input[type="time"]').eq(1).val();
                                hours[day] = {
                                    status,
                                    start_time,
                                    end_time
                                };
                            });
                            fd.append('hours', JSON.stringify(hours));
                        }

                        $.ajax({
                            url: ROUTES.update,
                            type: 'POST',
                            data: fd,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Saved',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                // refresh repeater snapshot to current DOM
                                const fresh = {};
                                form.find('.repeater').each(function(i, el) {
                                    fresh[i] = el.innerHTML;
                                });
                                Object.assign(repeaterSnapshot, fresh);

                                toggleFormState(false);
                            },
                            error: function(xhr) {
                                const msg = xhr?.responseJSON?.message || 'Error';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: msg
                                });
                            }
                        });
                    });
                });

                /* ===========================
                 * Wizard tabs
                 * =========================== */
                (function() {
                    const wizardTabs = $('#wizard-nav .qb-wizard-tab');
                    const tabPanes = $('#wizard-content .tab-pane');
                    wizardTabs.on('click', function() {
                        const target = $(this).data('target');
                        wizardTabs.removeClass('is-active');
                        $(this).addClass('is-active');
                        tabPanes.removeClass('active');
                        $('#' + String(target).replace('#', '')).addClass('active');
                    });
                })();

                /* ===========================
                 * Operational hours: disable times on Holiday
                 * =========================== */
                (function() {
                    const table = $('.operational-hours-table');
                    if (!table.length) return;
                    table.find('select').each(function() {
                        const select = $(this);
                        const row = select.closest('tr');

                        function update() {
                            const isHoliday = select.val() === 'Holiday';
                            const disabledGlobally = select.prop('disabled');
                            row.find('input[type="time"]').prop('disabled', isHoliday || disabledGlobally);
                        }
                        update();
                        select.on('change', update);
                    });
                })();

                /* ===========================
                 * Branding live preview
                 * =========================== */
                $(document).on('change', '#brandingForm input[type="file"]', function() {
                    const input = this;
                    if (!input.files || !input.files[0]) return;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $(input).closest('.panel-body').find('img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                });

                /* ===========================
                 * Prefix: submit
                 * =========================== */
                $(document).on('submit', 'form.prefix-update-form', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated',
                                text: res.message || 'Prefix updated.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors || {};
                                form.find('.is-invalid').removeClass('is-invalid');
                                form.find('.invalid-feedback').remove();
                                $.each(errors, function(key, msgs) {
                                    const input = form.find('[name="' + key + '"]');
                                    input.addClass('is-invalid').after(
                                        '<div class="invalid-feedback">' + msgs[0] +
                                        '</div>');
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Try again.'
                                });
                            }
                        }
                    });
                });

                /* ===========================
                 * Prefix: live preview
                 * =========================== */
                function updatePrefixPreview(prefixId) {
                    const root = $(`.prefix-format-group[data-prefix-id="${prefixId}"]`);
                    const format = root.find('input[name="prefix_format"]:checked').val();
                    const code = $(`#prefix_code_${prefixId}`).val() || '';
                    const sep = $(`#separators_${prefixId}`).val() || '';
                    const limit = parseInt($(`#digit_limit_${prefixId}`).val()) || 1;
                    const num = String(1).padStart(limit, '0');
                    let out = '';
                    switch (format) {
                        case 'CODE-DD-MM-01':
                            out = code + sep + 'DD' + sep + 'MM' + sep + num;
                            break;
                        case 'CODE-MM-01':
                            out = code + sep + 'MM' + sep + num;
                            break;
                        case 'CODE-DDMM-01':
                            out = code + sep + 'DD' + 'MM' + sep + num;
                            break;
                        default:
                            out = code + sep + num;
                    }
                    $(`#prefix_style_${prefixId}`).val(out);
                }
                $('.prefix-format-group').each(function() {
                    updatePrefixPreview($(this).data('prefix-id'));
                });
                $(document).on('change input',
                    'input[name="prefix_format"], input[id^="prefix_code_"], input[id^="separators_"], input[id^="digit_limit_"]',
                    function() {
                        updatePrefixPreview($(this).closest('.prefix-format-group').data('prefix-id'));
                    });

                /* ===========================
                 * Holidays CRUD
                 * =========================== */
                function loadHolidays() {
                    $.get(ROUTES.holidaysIndex, function(data) {
                        let rows = '';
                        (data || []).forEach(function(h) {
                            rows += `<tr>
          <td>${h.date}</td>
          <td>${h.occasion}</td>
          <td class="text-end">
            <button class="btn btn-sm btn-danger delete-holiday" data-id="${h.id}">
              <i class='bx bx-trash'></i>
            </button>
          </td>
        </tr>`;
                        });
                        $('#holidaysTable tbody').html(rows);
                    });
                }
                loadHolidays();

                $(document).on('submit', '#holidayForm', function(e) {
                    e.preventDefault();
                    $.post(ROUTES.holidaysStore, $(this).serialize())
                        .done(function() {
                            $('#holidayForm')[0].reset();
                            loadHolidays();
                        })
                        .fail(function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || 'Failed'
                            });
                        });
                });

                $(document).on('click', '.delete-holiday', function() {
                    const id = $(this).data('id');
                    Swal.fire({
                            title: 'Are you sure?',
                            text: "You can't revert this.",
                            icon: 'warning',
                            showCancelButton: true
                        })
                        .then((r) => {
                            if (!r.isConfirmed) return;
                            $.ajax({
                                    url: ROUTES.holidaysDelete + id,
                                    type: 'DELETE'
                                })
                                .done(function() {
                                    loadHolidays();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted'
                                    });
                                })
                                .fail(function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error deleting'
                                    });
                                });
                        });
                });

                /* ===========================
                 * Documents CRUD
                 * =========================== */
                function loadDocuments() {
                    $.get(ROUTES.docsIndex, function(data) {
                        let rows = '';
                        (data || []).forEach(function(doc) {
                            rows += `<tr>
          <td>${doc.type}</td>
          <td>${new Date(doc.created_at).toLocaleDateString()}</td>
          <td>
            <a href="/storage/${doc.file_path}" target="_blank" class="btn btn-sm btn-info me-1">
              <i class="bx bx-download"></i>
            </a>
            <button class="btn btn-sm btn-danger delete-document" data-id="${doc.id}">
              <i class="bx bx-trash"></i>
            </button>
          </td>
        </tr>`;
                        });
                        $('#documentsTable tbody').html(rows);
                    });
                }
                loadDocuments();

                $(document).on('submit', '#documentForm', function(e) {
                    e.preventDefault();
                    const fd = new FormData(this);
                    $.ajax({
                            url: ROUTES.docsStore,
                            type: 'POST',
                            data: fd,
                            processData: false,
                            contentType: false
                        })
                        .done(function() {
                            $('#documentForm')[0].reset();
                            loadDocuments();
                            Swal.fire('Success', 'Document uploaded successfully', 'success');
                        })
                        .fail(function(xhr) {
                            Swal.fire('Error', xhr.responseJSON?.message || 'Upload failed', 'error');
                        });
                });

                $(document).on('click', '.delete-document', function() {
                    const id = $(this).data('id');
                    Swal.fire({
                            title: 'Are you sure?',
                            text: 'This will be deleted.',
                            icon: 'warning',
                            showCancelButton: true
                        })
                        .then((r) => {
                            if (!r.isConfirmed) return;
                            $.ajax({
                                    url: `${ROUTES.docsDeleteBase}/${id}`,
                                    type: 'DELETE'
                                })
                                .done(function() {
                                    loadDocuments();
                                    Swal.fire('Deleted!', 'Document deleted successfully.', 'success');
                                })
                                .fail(function() {
                                    Swal.fire('Error', 'Delete failed', 'error');
                                });
                        });
                });

                /* ===========================
                 * Keep Select2 synced when toggling
                 * =========================== */
                $(document).on('click', '.edit-card-btn, .cancel-card-btn, .save-card-btn', function() {
                    const form = $(this).closest('.card-form');
                    initSelect2(form);
                });
            });
        </script>
    @endpush
@endsection
