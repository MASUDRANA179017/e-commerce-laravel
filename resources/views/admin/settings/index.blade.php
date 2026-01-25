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
                <div class="card border-0">
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
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Timezone</label>
                                    <select class="form-select">
                                        <option>Asia/Dhaka (UTC+6)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency</label>
                                    <select class="form-select">
                                        <option>BDT (৳)</option>
                                        <option>USD ($)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date Format</label>
                                <select class="form-select">
                                    <option>M d, Y (Dec 01, 2025)</option>
                                    <option>d/m/Y (01/12/2025)</option>
                                    <option>Y-m-d (2025-12-01)</option>
                                </select>
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
                            <div class="row mb-3">
                                <div class="col-md-12">
                                     <label class="form-label">Company Name</label>
                                     <input type="text" class="form-control" name="company_name" value="{{ $settings->company_name ?? '' }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Store Address</label>
                                <textarea class="form-control" name="street_address" rows="2">{{ $settings->street_address ?? '' }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="official_contact_number" value="{{ is_array($settings->official_contact_number) ? ($settings->official_contact_number[0] ?? '') : ($settings->official_contact_number ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control" name="whatsapp_number" value="{{ is_array($settings->whatsapp_number) ? ($settings->whatsapp_number[0] ?? '') : ($settings->whatsapp_number ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email_address" value="{{ is_array($settings->email_address) ? ($settings->email_address[0] ?? '') : ($settings->email_address ?? '') }}">
                                </div>
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                        </form>
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
                                <input type="text" class="form-control" name="meta_title" value="{{ $settings->meta_title ?? '' }}" placeholder="{{ config('app.name', 'GrowUp E-Commerce') }} - Your Ultimate Shopping Destination">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="3" placeholder="Shop the latest products at the best prices. {{ config('app.name', 'GrowUp E-Commerce') }} offers quality products with fast delivery across Bangladesh.">{{ $settings->meta_description ?? '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords" value="{{ $settings->meta_keywords ?? '' }}" placeholder="e-commerce, online shopping, bangladesh">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Google Analytics ID</label>
                                <input type="text" class="form-control" name="google_analytics_id" value="{{ $settings->google_analytics_id ?? '' }}" placeholder="UA-XXXXXXXXX-X">
                            </div>
                            <button type="submit" class="create-btn-base">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function handleFormSubmit(formId, route) {
        document.getElementById(formId)?.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(route, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    if(typeof toastr !== 'undefined') {
                        toastr.success(data.message);
                    } else {
                        alert(data.message);
                    }
                    // Reload page if logo/favicon updated to show changes immediately if needed, 
                    // or just rely on the user refreshing. 
                    // For store settings which might change logo, a reload might be nice but let's stick to toastr for now.
                } else {
                    if(typeof toastr !== 'undefined') {
                        toastr.error(data.message || 'Something went wrong');
                    } else {
                        alert(data.message || 'Something went wrong');
                    }
                }
            })
            .catch(err => {
                console.error(err);
                if(typeof toastr !== 'undefined') {
                    toastr.error('Server Error');
                } else {
                    alert('Server Error');
                }
            });
        });
    }

    handleFormSubmit('generalSettingsForm', '{{ route("admin.settings.general") }}');
    handleFormSubmit('storeSettingsForm', '{{ route("admin.settings.store") }}');
    handleFormSubmit('emailSettingsForm', '{{ route("admin.settings.email") }}');
    handleFormSubmit('socialSettingsForm', '{{ route("admin.settings.social") }}');
    handleFormSubmit('seoSettingsForm', '{{ route("admin.settings.seo") }}');

    // Activate tab based on hash
    document.addEventListener("DOMContentLoaded", function() {
        var hash = window.location.hash;
        if (hash) {
            var triggerEl = document.querySelector('a[href="' + hash + '"]');
            if (triggerEl) {
                // Remove active class from all tabs
                document.querySelectorAll('.list-group-item').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(el => el.classList.remove('show', 'active'));
                
                // Activate the target tab
                triggerEl.classList.add('active');
                var targetPane = document.querySelector(hash);
                if(targetPane) {
                    targetPane.classList.add('show', 'active');
                }
            }
        }
    });

    // Handle Shipping Settings Form Submission
    document.getElementById('shippingSettingsForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        
        fetch('{{ route("admin.settings.shipping") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showCustomToast('success', 'Shipping settings saved successfully!', '✓');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showCustomToast('error', 'Error: ' + (data.message || 'Failed to save'), '✕');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showCustomToast('error', 'An error occurred while saving.', '✕');
        });
    });

    // Custom Toast Notification
    function showCustomToast(type, message, icon) {
        // Remove existing toasts
        const existingToasts = document.querySelectorAll('.custom-toast');
        existingToasts.forEach(toast => toast.remove());

        const toast = document.createElement('div');
        toast.className = `custom-toast custom-toast-${type}`;
        
        const colors = {
            success: { bg: '#10b981', icon: '✓' },
            error: { bg: '#ef4444', icon: '✕' },
            warning: { bg: '#f59e0b', icon: '⚠' },
            info: { bg: '#3b82f6', icon: 'ℹ' }
        };

        const color = colors[type] || colors.info;

        toast.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${color.bg};
                color: white;
                padding: 16px 24px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                display: flex;
                align-items: center;
                gap: 12px;
                font-weight: 500;
                font-size: 14px;
                z-index: 9999;
                animation: slideInRight 0.3s ease-out;
                max-width: 400px;
                word-wrap: break-word;
            ">
                <span style="
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 24px;
                    height: 24px;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.2);
                    font-weight: bold;
                    flex-shrink: 0;
                ">${icon}</span>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(toast);

        // Auto remove after 4 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    // Add animation styles if not already present
    if (!document.getElementById('toast-styles')) {
        const style = document.createElement('style');
        style.id = 'toast-styles';
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }

            .custom-toast {
                animation: slideInRight 0.3s ease-out !important;
            }
        `;
        document.head.appendChild(style);
    }

    // Handle Scout Discount Settings Form Submission
    document.getElementById('scoutDiscountForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        
        // Add checkbox value even if unchecked
        if (!formData.has('scout_discount_enabled')) {
            formData.append('scout_discount_enabled', '0');
        }
        
        fetch('{{ route("admin.settings.scout") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showCustomToast('success', 'Scout discount settings saved successfully!', '✓');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showCustomToast('error', 'Error: ' + (data.message || 'Failed to save'), '✕');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showCustomToast('error', 'An error occurred while saving.', '✕');
        });
    });
</script>
@endpush

