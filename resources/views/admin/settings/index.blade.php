@extends('layouts.master')

@section('title', 'Settings')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Settings</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 mb-4">
            <div class="list-group list-group-flush">
                <a href="#general" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">settings</i> General
                </a>
                <a href="#store" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">store</i> Store Info
                </a>
                <a href="#holidays" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">calendar_month</i> Public Holidays
                </a>
                <a href="#documents" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">folder</i> Documents
                </a>
                <a href="#email" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">mail</i> Email
                </a>
                <a href="#payment" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">credit_card</i> Payment
                </a>
                <a href="#shipping" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">local_shipping</i> Shipping
                </a>
                <a href="#scout" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">shield</i> Scout Discount
                </a>
                <a href="#tax" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">receipt</i> Tax
                </a>
                <a href="#social" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">share</i> Social Media
                </a>
                <a href="#seo" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">search</i> SEO
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="tab-content">
            <!-- General Settings -->
            <div class="tab-pane fade show active" id="general">
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">General Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="generalSettingsForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Site Name</label>
                                    <input type="text" class="form-control" name="system_name" value="{{ $settings->system_name ?? 'GrowUp E-Commerce' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Login Tagline</label>
                                    <input type="text" class="form-control" name="login_tagline" value="{{ $settings->login_tagline ?? 'Your Ultimate Shopping Destination' }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Footer Text (About Us)</label>
                                <textarea class="form-control" name="footer_text" rows="3">{{ $settings->footer_text ?? '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Copyright Text</label>
                                <input type="text" class="form-control" name="copyright_text" value="{{ $settings->copyright_text ?? '' }}">
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                        </form>
                    </div>
                </div>

                <!-- Localization Settings -->
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Localization</h5>
                    </div>
                    <div class="card-body">
                        <form id="localizationForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Timezone</label>
                                    <select class="form-select" name="timezone">
                                        @foreach(DateTimeZone::listIdentifiers() as $timezone)
                                            <option value="{{ $timezone }}" {{ $localization->timezone == $timezone ? 'selected' : '' }}>{{ $timezone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">System Language</label>
                                    <select class="form-select" name="system_language">
                                        <option value="en" {{ $localization->system_language == 'en' ? 'selected' : '' }}>English</option>
                                        <option value="bn" {{ $localization->system_language == 'bn' ? 'selected' : '' }}>Bangla</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date Format</label>
                                    <select class="form-select" name="date_format">
                                        <option value="M d, Y" {{ $localization->date_format == 'M d, Y' ? 'selected' : '' }}>M d, Y (Dec 01, 2025)</option>
                                        <option value="d-m-Y" {{ $localization->date_format == 'd-m-Y' ? 'selected' : '' }}>d-m-Y (01-12-2025)</option>
                                        <option value="Y-m-d" {{ $localization->date_format == 'Y-m-d' ? 'selected' : '' }}>Y-m-d (2025-12-01)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Time Format</label>
                                    <select class="form-select" name="time_format">
                                        <option value="12" {{ $localization->time_format == '12' ? 'selected' : '' }}>12 Hour</option>
                                        <option value="24" {{ $localization->time_format == '24' ? 'selected' : '' }}>24 Hour</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                        </form>
                    </div>
                </div>

                <!-- Currency Settings -->
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Currency</h5>
                    </div>
                    <div class="card-body">
                        <form id="currencyForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Default Currency</label>
                                    <select class="form-select" name="default_currency">
                                        <option value="BDT" {{ $currency->default_currency == 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                        <option value="USD" {{ $currency->default_currency == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                        <option value="INR" {{ $currency->default_currency == 'INR' ? 'selected' : '' }}>INR (₹)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency Decimals</label>
                                    <input type="number" class="form-control" name="currency_decimals" value="{{ $localization->currency_decimals ?? 2 }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fiscal Year Start</label>
                                    <select class="form-select" name="fiscal_year_start">
                                        <option value="January" {{ $currency->fiscal_year_start == 'January' ? 'selected' : '' }}>January</option>
                                        <option value="April" {{ $currency->fiscal_year_start == 'April' ? 'selected' : '' }}>April</option>
                                        <option value="July" {{ $currency->fiscal_year_start == 'July' ? 'selected' : '' }}>July</option>
                                        <option value="October" {{ $currency->fiscal_year_start == 'October' ? 'selected' : '' }}>October</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">USD to BDT Rate</label>
                                    <input type="number" class="form-control" name="usd_to_bdt_rate" value="{{ $currency->usd_to_bdt_rate }}" step="0.01">
                                </div>
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Store Info -->
            <div class="tab-pane fade" id="store">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Store Information</h5>
                    </div>
                    <div class="card-body">
                        <form id="storeSettingsForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Logo</label>
                                    <input type="file" class="form-control" name="logo">
                                    @if(isset($settings->logo))
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" height="50">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Favicon</label>
                                    <input type="file" class="form-control" name="favicon">
                                    @if(isset($settings->favicon))
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $settings->favicon) }}" alt="Favicon" height="30">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <h6 class="mb-3 fw-bold text-muted">Company Information</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                     <label class="form-label">Company Name</label>
                                     <input type="text" class="form-control" name="company_name" value="{{ $settings->company_name ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                     <label class="form-label">Company Type</label>
                                     <select class="form-select" name="company_type">
                                         <option value="Private Limited Company" {{ ($settings->company_type ?? '') == 'Private Limited Company' ? 'selected' : '' }}>Private Limited Company</option>
                                         <option value="Public Limited Company" {{ ($settings->company_type ?? '') == 'Public Limited Company' ? 'selected' : '' }}>Public Limited Company</option>
                                         <option value="Partnership" {{ ($settings->company_type ?? '') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                                         <option value="Proprietorship" {{ ($settings->company_type ?? '') == 'Proprietorship' ? 'selected' : '' }}>Proprietorship</option>
                                     </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                     <label class="form-label">Industry</label>
                                     <input type="text" class="form-control" name="industry" value="{{ $settings->industry ?? '' }}">
                                </div>
                                <div class="col-md-6 mt-3">
                                     <label class="form-label">Establishment Date</label>
                                     <input type="date" class="form-control" name="establishment_date" value="{{ $settings->establishment_date ?? '' }}">
                                </div>
                            </div>

                            <h6 class="mb-3 fw-bold text-muted">Legal Numbers</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                     <label class="form-label">Registration No.</label>
                                     <input type="text" class="form-control" name="company_registration_number" value="{{ $settings->company_registration_number ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                     <label class="form-label">Trade License</label>
                                     <input type="text" class="form-control" name="trade_license_number" value="{{ $settings->trade_license_number ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                     <label class="form-label">BIN/VAT</label>
                                     <input type="text" class="form-control" name="bin_vat_number" value="{{ $settings->bin_vat_number ?? '' }}">
                                </div>
                            </div>

                            <h6 class="mb-3 fw-bold text-muted">Address</h6>
                            <div class="mb-3">
                                <label class="form-label">Street Address</label>
                                <textarea class="form-control" name="street_address" rows="2">{{ $settings->street_address ?? '' }}</textarea>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">City/Thana</label>
                                    <input type="text" class="form-control" name="city_thana" value="{{ $settings->city_thana ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">District</label>
                                    <input type="text" class="form-control" name="district" value="{{ $settings->district ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" name="zip_code" value="{{ $settings->zip_code ?? '' }}">
                                </div>
                            </div>

                            <h6 class="mb-3 fw-bold text-muted">Contact Info</h6>
                            <div class="row">
                                <!-- Official Phone -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone (Official)</label>
                                    <div class="repeater-container" data-name="official_contact_number[]">
                                        @php $phones = is_array($settings->official_contact_number) ? $settings->official_contact_number : (json_decode($settings->official_contact_number, true) ?? []); @endphp
                                        @if(empty($phones)) @php $phones = ['']; @endphp @endif
                                        @foreach($phones as $phone)
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="official_contact_number[]" value="{{ $phone }}">
                                                <button type="button" class="btn btn-outline-danger remove-field"><i class="material-symbols-outlined fs-16">delete</i></button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary add-field" data-target="official_contact_number[]"><i class="material-symbols-outlined fs-14">add</i> Add Number</button>
                                </div>

                                <!-- WhatsApp -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">WhatsApp</label>
                                    <div class="repeater-container" data-name="whatsapp_number[]">
                                        @php $whatsapps = is_array($settings->whatsapp_number) ? $settings->whatsapp_number : (json_decode($settings->whatsapp_number, true) ?? []); @endphp
                                        @if(empty($whatsapps)) @php $whatsapps = ['']; @endphp @endif
                                        @foreach($whatsapps as $wa)
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="whatsapp_number[]" value="{{ $wa }}">
                                                <button type="button" class="btn btn-outline-danger remove-field"><i class="material-symbols-outlined fs-16">delete</i></button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary add-field" data-target="whatsapp_number[]"><i class="material-symbols-outlined fs-14">add</i> Add WhatsApp</button>
                                </div>

                                <!-- Hotline -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Hotline</label>
                                    <div class="repeater-container" data-name="hotline_number[]">
                                        @php $hotlines = is_array($settings->hotline_number) ? $settings->hotline_number : (json_decode($settings->hotline_number, true) ?? []); @endphp
                                        @if(empty($hotlines)) @php $hotlines = ['']; @endphp @endif
                                        @foreach($hotlines as $hl)
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="hotline_number[]" value="{{ $hl }}">
                                                <button type="button" class="btn btn-outline-danger remove-field"><i class="material-symbols-outlined fs-16">delete</i></button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary add-field" data-target="hotline_number[]"><i class="material-symbols-outlined fs-14">add</i> Add Hotline</button>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="repeater-container" data-name="email_address[]">
                                        @php $emails = is_array($settings->email_address) ? $settings->email_address : (json_decode($settings->email_address, true) ?? []); @endphp
                                        @if(empty($emails)) @php $emails = ['']; @endphp @endif
                                        @foreach($emails as $email)
                                            <div class="input-group mb-2">
                                                <input type="email" class="form-control" name="email_address[]" value="{{ $email }}">
                                                <button type="button" class="btn btn-outline-danger remove-field"><i class="material-symbols-outlined fs-16">delete</i></button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary add-field" data-target="email_address[]"><i class="material-symbols-outlined fs-14">add</i> Add Email</button>
                                </div>
                            </div>
                            <button type="submit" class="create-btn-base mt-3">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Public Holidays -->
            <div class="tab-pane fade" id="holidays">
                <div class="card border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Public Holidays</h5>
                        <button class="create-btn-base border-0" data-bs-toggle="modal" data-bs-target="#addHolidayModal">Add Holiday</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Occasion</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($public_holidays as $holiday)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($holiday->date)->format('d M, Y') }}</td>
                                            <td>{{ $holiday->occasion }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger delete-holiday" data-id="{{ $holiday->id }}"><i class="material-symbols-outlined fs-16">delete</i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="tab-pane fade" id="documents">
                <div class="card border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Documents</h5>
                        <button class="create-btn-base border-0" data-bs-toggle="modal" data-bs-target="#addDocumentModal">Upload Document</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>File</th>
                                        <th>Uploaded At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $doc)
                                        <tr>
                                            <td>{{ $doc->type }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-primary">View File</a>
                                            </td>
                                            <td>{{ $doc->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger delete-document" data-id="{{ $doc->id }}"><i class="material-symbols-outlined fs-16">delete</i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="tab-pane fade" id="email">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Email Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="emailSettingsForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Mail Driver</label>
                                <select class="form-select" name="mail_mailer">
                                    <option value="smtp" {{ ($settings->mail_mailer ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                    <option value="mailgun" {{ ($settings->mail_mailer ?? '') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                    <option value="sendgrid" {{ ($settings->mail_mailer ?? '') == 'sendgrid' ? 'selected' : '' }}>SendGrid</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">SMTP Host</label>
                                    <input type="text" class="form-control" name="mail_host" value="{{ $settings->mail_host ?? '' }}" placeholder="smtp.gmail.com">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Port</label>
                                    <input type="text" class="form-control" name="mail_port" value="{{ $settings->mail_port ?? '' }}" placeholder="587">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="mail_username" value="{{ $settings->mail_username ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="mail_password" value="{{ $settings->mail_password ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                     <label class="form-label">Encryption</label>
                                     <input type="text" class="form-control" name="mail_encryption" value="{{ $settings->mail_encryption ?? 'tls' }}" placeholder="tls">
                                </div>
                                <div class="col-md-4 mb-3">
                                     <label class="form-label">From Address</label>
                                     <input type="email" class="form-control" name="mail_from_address" value="{{ $settings->mail_from_address ?? '' }}" placeholder="no-reply@example.com">
                                </div>
                                <div class="col-md-4 mb-3">
                                     <label class="form-label">From Name</label>
                                     <input type="text" class="form-control" name="mail_from_name" value="{{ $settings->mail_from_name ?? '' }}" placeholder="My Store">
                                </div>
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                            <button type="button" class="select-btn-info ms-2">Send Test Email</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Payment Settings -->
            <div class="tab-pane fade" id="payment">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Payment Methods</h5>
                    </div>
                    <div class="card-body">
                        <div class="border rounded p-3 mb-3">
                            <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Cash on Delivery</h6>
                                    <small class="text-muted">Accept payment on delivery</small>
                                </div>
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="border rounded p-3 mb-3">
                            <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">bKash</h6>
                                    <small class="text-muted">Accept bKash mobile payments</small>
                                </div>
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                        <div class="border rounded p-3 mb-3">
                            <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Nagad</h6>
                                    <small class="text-muted">Accept Nagad mobile payments</small>
                                </div>
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                        <div class="border rounded p-3 mb-3">
                            <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Card Payment (SSLCommerz)</h6>
                                    <small class="text-muted">Accept Visa, Mastercard, etc.</small>
                                </div>
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Settings -->
            <div class="tab-pane fade" id="shipping">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Shipping Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="shippingSettingsForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Default Shipping Method</label>
                                <select class="form-select" name="default_shipping_method">
                                    <option value="flat_rate" {{ $settings->default_shipping_method == 'flat_rate' ? 'selected' : '' }}>Flat Rate</option>
                                    <option value="free_shipping" {{ $settings->default_shipping_method == 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                                    <option value="weight_based" {{ $settings->default_shipping_method == 'weight_based' ? 'selected' : '' }}>Weight Based</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shipping Cost (Inside Dhaka)</label>
                                    <input type="number" class="form-control" name="shipping_cost_dhaka" value="{{ $settings->shipping_cost_dhaka ?? 60 }}" step="0.01">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shipping Cost (Outside Dhaka)</label>
                                    <input type="number" class="form-control" name="shipping_cost_outside" value="{{ $settings->shipping_cost_outside ?? 120 }}" step="0.01">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Free Shipping Threshold</label>
                                <input type="number" class="form-control" name="free_shipping_threshold" value="{{ $settings->free_shipping_threshold ?? 5000 }}" step="0.01" placeholder="Order amount for free shipping">
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Scout Discount Settings -->
            <div class="tab-pane fade" id="scout">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Scout Discount Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="scoutDiscountForm">
                            @csrf
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="enableScout" name="scout_discount_enabled" value="1" {{ \App\Models\SystemSetting::scoutDiscountEnabled() ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enableScout">Enable Scout Discount</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Discount Percentage (%)</label>
                                    <input type="number" class="form-control" name="scout_discount_percent" value="{{ \App\Models\SystemSetting::scoutDiscountPercent() }}" step="0.01" min="0" max="100">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Coupon Code</label>
                                    <input type="text" class="form-control" name="scout_discount_code" value="{{ \App\Models\SystemSetting::scoutDiscountCode() }}" placeholder="e.g., SCOUT">
                                </div>
                            </div>
                            <div class="mb-3 p-3 rounded-3" style="background: #f0f9ff; border: 1px solid #e0f2fe;">
                                <p class="mb-2"><strong>How it works:</strong></p>
                                <ul class="mb-0 small">
                                    <li>Scout members can fill the Scout Member form on checkout</li>
                                    <li>System will apply the configured discount percentage automatically</li>
                                    <li>Discount will be applied as a coupon code on successful verification</li>
                                </ul>
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tax Settings -->
            <div class="tab-pane fade" id="tax">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Tax Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="enableTax">
                                    <label class="form-check-label" for="enableTax">Enable Tax</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tax Rate (%)</label>
                                    <input type="number" class="form-control" value="0" step="0.01">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tax Label</label>
                                    <input type="text" class="form-control" value="VAT">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="taxIncluded">
                                    <label class="form-check-label" for="taxIncluded">Prices include tax</label>
                                </div>
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Social Media Settings -->
            <div class="tab-pane fade" id="social">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Social Media Links</h5>
                    </div>
                    <div class="card-body">
                        <form id="socialSettingsForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-facebook text-primary me-2"></i>Facebook</label>
                                <input type="url" class="form-control" name="facebook_url" value="{{ $settings->facebook_url ?? '' }}" placeholder="https://facebook.com/yourpage">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-twitter text-info me-2"></i>Twitter</label>
                                <input type="url" class="form-control" name="twitter_url" value="{{ $settings->twitter_url ?? '' }}" placeholder="https://twitter.com/yourpage">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-linkedin text-primary me-2"></i>LinkedIn</label>
                                <input type="url" class="form-control" name="linkedin_url" value="{{ $settings->linkedin_url ?? '' }}" placeholder="https://linkedin.com/yourpage">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-youtube text-danger me-2"></i>YouTube</label>
                                <input type="url" class="form-control" name="youtube_url" value="{{ $settings->youtube_url ?? '' }}" placeholder="https://youtube.com/yourchannel">
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="tab-pane fade" id="seo">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">SEO Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="seoSettingsForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title" value="{{ $settings->meta_title ?? '' }}" placeholder="SEO Title">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="3">{{ $settings->meta_description ?? '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords" value="{{ $settings->meta_keywords ?? '' }}" placeholder="ecommerce, shop, best deals">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Google Analytics ID</label>
                                <input type="text" class="form-control" name="google_analytics_id" value="{{ $settings->google_analytics_id ?? '' }}" placeholder="UA-XXXXX-Y">
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Holiday Modal -->
<div class="modal fade" id="addHolidayModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addHolidayForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Holiday</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Occasion</label>
                        <input type="text" class="form-control" name="occasion" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="create-btn-base">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Document Modal -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addDocumentForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Document Type</label>
                        <input type="text" class="form-control" name="type" placeholder="e.g. Trade License" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File (PDF/Image)</label>
                        <input type="file" class="form-control" name="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="create-btn-base">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Generic Form Submit
        function submitForm(formId, url, successMsg) {
            $('#' + formId).on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.message || successMsg);
                        if (response.redirect) window.location.href = response.redirect;
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('Something went wrong');
                        }
                    }
                });
            });
        }

        submitForm('generalSettingsForm', '{{ route("admin.settings.update-general") }}', 'General settings updated');
        submitForm('localizationForm', '{{ route("admin.settings.update-localization") }}', 'Localization updated');
        submitForm('currencyForm', '{{ route("admin.settings.update-currency") }}', 'Currency updated');
        submitForm('storeSettingsForm', '{{ route("admin.settings.update-store-info") }}', 'Store info updated');
        submitForm('emailSettingsForm', '{{ route("admin.settings.update-email") }}', 'Email settings updated');
        submitForm('shippingSettingsForm', '{{ route("admin.settings.update-shipping") }}', 'Shipping settings updated');
        submitForm('scoutDiscountForm', '{{ route("admin.settings.update-scout") }}', 'Scout discount updated');
        submitForm('socialSettingsForm', '{{ route("admin.settings.update-social") }}', 'Social settings updated');
        submitForm('seoSettingsForm', '{{ route("admin.settings.update-seo") }}', 'SEO settings updated');

        // Dynamic Fields for Store Info
        $('.add-field').on('click', function() {
            let target = $(this).data('target');
            let container = $(this).siblings('.repeater-container');
            let inputType = target.includes('email') ? 'email' : 'text';
            let fieldHtml = `
                <div class="input-group mb-2">
                    <input type="${inputType}" class="form-control" name="${target}" placeholder="Enter value">
                    <button type="button" class="btn btn-outline-danger remove-field"><i class="material-symbols-outlined fs-16">delete</i></button>
                </div>`;
            container.append(fieldHtml);
        });

        $(document).on('click', '.remove-field', function() {
            $(this).closest('.input-group').remove();
        });

        // Holidays
        $('#addHolidayForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '{{ route("admin.settings.holidays.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    toastr.error('Error adding holiday');
                }
            });
        });

        $('.delete-holiday').on('click', function() {
            if(!confirm('Are you sure?')) return;
            let id = $(this).data('id');
            $.ajax({
                url: '{{ url("admin/settings/holidays") }}/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    toastr.success(response.message);
                    location.reload();
                }
            });
        });

        // Documents
        $('#addDocumentForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '{{ route("admin.settings.documents.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success('Document uploaded successfully');
                    location.reload();
                },
                error: function(xhr) {
                    toastr.error('Error uploading document');
                }
            });
        });

        $('.delete-document').on('click', function() {
            if(!confirm('Are you sure?')) return;
            let id = $(this).data('id');
            $.ajax({
                url: '{{ url("admin/settings/documents") }}/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    toastr.success('Document deleted successfully');
                    location.reload();
                }
            });
        });
    });
</script>
@endpush
