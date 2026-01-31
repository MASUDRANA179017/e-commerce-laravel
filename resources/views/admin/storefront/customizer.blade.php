@extends('layouts.master')

@section('title', 'Theme Customizer')

@push('styles')
<style>
    .form-control-color {
        height: 60px;
        cursor: pointer;
        border: 2px solid #e5e7eb !important;
        border-radius: 8px;
        padding: 4px;
    }

    .form-control-color:hover {
        border-color: #0496ff !important;
    }

    .color-input-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 10px;
    }

    .color-input-wrapper input {
        flex: 1;
    }

    .color-display {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }

    .color-hex-value {
        font-family: 'Courier New', monospace;
        font-size: 13px;
        font-weight: 500;
        color: #666;
        margin-top: 8px;
        background: #f9f9f9;
        padding: 8px 12px;
        border-radius: 6px;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="mb-4 col-12">
        <div class="flex-wrap gap-3 d-flex align-items-center justify-content-between">
            <h3 class="mb-0 fw-bold">Theme Customizer</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Theme Customizer</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-lg-4">
        <form id="themeSettingsForm">
            @csrf
            <div class="mb-4 border-0 card">
                <div class="bg-white card-header">
                    <h5 class="mb-0 fw-bold">Colors</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Primary Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_primary" class="form-control form-control-color color-picker-primary" value="{{ $business_setup->theme_color_primary ?? '#0496ff' }}">
                            <div class="color-display color-display-primary" style="background-color: {{ $business_setup->theme_color_primary ?? '#0496ff' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-primary">{{ $business_setup->theme_color_primary ?? '#0496ff' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Secondary Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_secondary" class="form-control form-control-color color-picker-secondary" value="{{ $business_setup->theme_color_secondary ?? '#1a1a2e' }}">
                            <div class="color-display color-display-secondary" style="background-color: {{ $business_setup->theme_color_secondary ?? '#1a1a2e' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-secondary">{{ $business_setup->theme_color_secondary ?? '#1a1a2e' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Accent Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_accent" class="form-control form-control-color color-picker-accent" value="{{ $business_setup->theme_color_accent ?? '#f9c123' }}">
                            <div class="color-display color-display-accent" style="background-color: {{ $business_setup->theme_color_accent ?? '#f9c123' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-accent">{{ $business_setup->theme_color_accent ?? '#f9c123' }}</span></div>
                    </div>
                </div>
            </div>

            <div class="mb-4 border-0 card">
                <div class="bg-white card-header">
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

            <div class="mb-4 border-0 card">
                <div class="bg-white card-header">
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
            // Update color display when user changes color
            $('.color-picker-primary').on('input', function() {
                let color = $(this).val();
                $('.color-display-primary').css('background-color', color);
                $('.hex-primary').text(color.toUpperCase());
            });

            $('.color-picker-secondary').on('input', function() {
                let color = $(this).val();
                $('.color-display-secondary').css('background-color', color);
                $('.hex-secondary').text(color.toUpperCase());
            });

            $('.color-picker-accent').on('input', function() {
                let color = $(this).val();
                $('.color-display-accent').css('background-color', color);
                $('.hex-accent').text(color.toUpperCase());
            });

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
        <div class="border-0 card">
            <div class="bg-white card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Preview</h5>
                <div class="gap-1 d-flex">
                    <button class="select-btn-base active">Desktop</button>
                    <button class="select-btn-white">Tablet</button>
                    <button class="select-btn-white">Mobile</button>
                </div>
            </div>
            <div class="p-0 card-body">
                <iframe src="{{ route('home') }}" style="width: 100%; height: 600px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

