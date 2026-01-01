@extends('layouts.master')

@section('title', 'Theme Customizer')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Theme Customizer</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Theme Customizer</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-lg-4">
        <form id="themeSettingsForm">
            @csrf
            <div class="card border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Colors</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Primary Color</label>
                        <input type="color" name="theme_color_primary" class="form-control form-control-color w-100" value="{{ $business_setup->theme_color_primary ?? '#0496ff' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Secondary Color</label>
                        <input type="color" name="theme_color_secondary" class="form-control form-control-color w-100" value="{{ $business_setup->theme_color_secondary ?? '#1a1a2e' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Accent Color</label>
                        <input type="color" name="theme_color_accent" class="form-control form-control-color w-100" value="{{ $business_setup->theme_color_accent ?? '#f9c123' }}">
                    </div>
                </div>
            </div>

            <div class="card border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Typography</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Primary Font</label>
                        <select class="form-select" name="theme_font_primary">
                            <option value="Outfit" {{ ($business_setup->theme_font_primary ?? 'Outfit') == 'Outfit' ? 'selected' : '' }}>Outfit</option>
                            <option value="Roboto" {{ ($business_setup->theme_font_primary ?? '') == 'Roboto' ? 'selected' : '' }}>Roboto</option>
                            <option value="Open Sans" {{ ($business_setup->theme_font_primary ?? '') == 'Open Sans' ? 'selected' : '' }}>Open Sans</option>
                            <option value="Poppins" {{ ($business_setup->theme_font_primary ?? '') == 'Poppins' ? 'selected' : '' }}>Poppins</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Base Font Size</label>
                        <select class="form-select" name="theme_font_base_size">
                            <option value="14px" {{ ($business_setup->theme_font_base_size ?? '') == '14px' ? 'selected' : '' }}>14px</option>
                            <option value="16px" {{ ($business_setup->theme_font_base_size ?? '16px') == '16px' ? 'selected' : '' }}>16px</option>
                            <option value="18px" {{ ($business_setup->theme_font_base_size ?? '') == '18px' ? 'selected' : '' }}>18px</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Layout</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Header Style</label>
                        <select class="form-select" name="theme_header_style">
                            <option value="Default" {{ ($business_setup->theme_header_style ?? 'Default') == 'Default' ? 'selected' : '' }}>Default</option>
                            <option value="Sticky" {{ ($business_setup->theme_header_style ?? '') == 'Sticky' ? 'selected' : '' }}>Sticky</option>
                            <option value="Transparent" {{ ($business_setup->theme_header_style ?? '') == 'Transparent' ? 'selected' : '' }}>Transparent</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Footer Style</label>
                        <select class="form-select" name="theme_footer_style">
                            <option value="Default" {{ ($business_setup->theme_footer_style ?? 'Default') == 'Default' ? 'selected' : '' }}>Default</option>
                            <option value="Minimal" {{ ($business_setup->theme_footer_style ?? '') == 'Minimal' ? 'selected' : '' }}>Minimal</option>
                            <option value="Extended" {{ ($business_setup->theme_footer_style ?? '') == 'Extended' ? 'selected' : '' }}>Extended</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="button" id="saveThemeSettings" class="create-btn-base w-100">Save Changes</button>
        </form>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#saveThemeSettings').click(function() {
                var btn = $(this);
                var originalText = btn.text();
                btn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: '{{ route("admin.storefront.customizer.save") }}',
                    type: 'POST',
                    data: $('#themeSettingsForm').serialize(),
                    success: function(response) {
                        if(response.success) {
                            toastr.success(response.message);
                            // Optionally reload iframe
                            $('iframe').attr('src', $('iframe').attr('src'));
                        } else {
                            toastr.error('Something went wrong');
                        }
                    },
                    error: function() {
                        toastr.error('Server error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).text(originalText);
                    }
                });
            });
        });
    </script>
    @endpush

    <div class="col-lg-8">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Preview</h5>
                <div class="d-flex gap-1">
                    <button class="select-btn-base active">Desktop</button>
                    <button class="select-btn-white">Tablet</button>
                    <button class="select-btn-white">Mobile</button>
                </div>
            </div>
            <div class="card-body p-0">
                <iframe src="{{ route('home') }}" style="width: 100%; height: 600px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

