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
                    <div class="mb-4">
                        <label class="form-label fw-bold">Button Text Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_button_text_color" class="form-control form-control-color color-picker-button-text" value="{{ $business_setup->theme_button_text_color ?? '#ffffff' }}">
                            <div class="color-display color-display-button-text" style="background-color: {{ $business_setup->theme_button_text_color ?? '#ffffff' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-button-text">{{ $business_setup->theme_button_text_color ?? '#ffffff' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Secondary Button Background</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_secondary_button_bg" class="form-control form-control-color color-picker-secondary-btn-bg" value="{{ $business_setup->theme_secondary_button_bg ?? '#f5f5f5' }}">
                            <div class="color-display color-display-secondary-btn-bg" style="background-color: {{ $business_setup->theme_secondary_button_bg ?? '#f5f5f5' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-secondary-btn-bg">{{ $business_setup->theme_secondary_button_bg ?? '#f5f5f5' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Secondary Button Text Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_secondary_button_text" class="form-control form-control-color color-picker-secondary-btn-text" value="{{ $business_setup->theme_secondary_button_text ?? '#333333' }}">
                            <div class="color-display color-display-secondary-btn-text" style="background-color: {{ $business_setup->theme_secondary_button_text ?? '#333333' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-secondary-btn-text">{{ $business_setup->theme_secondary_button_text ?? '#333333' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Link Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_link" class="form-control form-control-color color-picker-link" value="{{ $business_setup->theme_color_link ?? '#0496ff' }}">
                            <div class="color-display color-display-link" style="background-color: {{ $business_setup->theme_color_link ?? '#0496ff' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-link">{{ $business_setup->theme_color_link ?? '#0496ff' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Text Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_text" class="form-control form-control-color color-picker-text" value="{{ $business_setup->theme_color_text ?? '#333333' }}">
                            <div class="color-display color-display-text" style="background-color: {{ $business_setup->theme_color_text ?? '#333333' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-text">{{ $business_setup->theme_color_text ?? '#333333' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Heading Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_heading" class="form-control form-control-color color-picker-heading" value="{{ $business_setup->theme_color_heading ?? '#1a1a2e' }}">
                            <div class="color-display color-display-heading" style="background-color: {{ $business_setup->theme_color_heading ?? '#1a1a2e' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-heading">{{ $business_setup->theme_color_heading ?? '#1a1a2e' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Badge/Highlight Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_badge" class="form-control form-control-color color-picker-badge" value="{{ $business_setup->theme_color_badge ?? '#f9c123' }}">
                            <div class="color-display color-display-badge" style="background-color: {{ $business_setup->theme_color_badge ?? '#f9c123' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-badge">{{ $business_setup->theme_color_badge ?? '#f9c123' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Border Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_border" class="form-control form-control-color color-picker-border" value="{{ $business_setup->theme_color_border ?? '#e0e0e0' }}">
                            <div class="color-display color-display-border" style="background-color: {{ $business_setup->theme_color_border ?? '#e0e0e0' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-border">{{ $business_setup->theme_color_border ?? '#e0e0e0' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Input Focus Color</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_input_focus" class="form-control form-control-color color-picker-input-focus" value="{{ $business_setup->theme_color_input_focus ?? '#0496ff' }}">
                            <div class="color-display color-display-input-focus" style="background-color: {{ $business_setup->theme_color_input_focus ?? '#0496ff' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-input-focus">{{ $business_setup->theme_color_input_focus ?? '#0496ff' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Success Color (Alerts/Badges)</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_success" class="form-control form-control-color color-picker-success" value="{{ $business_setup->theme_color_success ?? '#28a745' }}">
                            <div class="color-display color-display-success" style="background-color: {{ $business_setup->theme_color_success ?? '#28a745' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-success">{{ $business_setup->theme_color_success ?? '#28a745' }}</span></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Danger Color (Alerts/Badges)</label>
                        <div class="color-input-wrapper">
                            <input type="color" name="theme_color_danger" class="form-control form-control-color color-picker-danger" value="{{ $business_setup->theme_color_danger ?? '#dc3545' }}">
                            <div class="color-display color-display-danger" style="background-color: {{ $business_setup->theme_color_danger ?? '#dc3545' }}"></div>
                        </div>
                        <div class="color-hex-value"><strong>Value:</strong> <span class="hex-danger">{{ $business_setup->theme_color_danger ?? '#dc3545' }}</span></div>
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

            $('.color-picker-button-text').on('input', function() {
                let color = $(this).val();
                $('.color-display-button-text').css('background-color', color);
                $('.hex-button-text').text(color.toUpperCase());
            });

            $('.color-picker-secondary-btn-bg').on('input', function() {
                let color = $(this).val();
                $('.color-display-secondary-btn-bg').css('background-color', color);
                $('.hex-secondary-btn-bg').text(color.toUpperCase());
            });

            $('.color-picker-secondary-btn-text').on('input', function() {
                let color = $(this).val();
                $('.color-display-secondary-btn-text').css('background-color', color);
                $('.hex-secondary-btn-text').text(color.toUpperCase());
            });

            $('.color-picker-link').on('input', function() {
                let color = $(this).val();
                $('.color-display-link').css('background-color', color);
                $('.hex-link').text(color.toUpperCase());
            });

            $('.color-picker-text').on('input', function() {
                let color = $(this).val();
                $('.color-display-text').css('background-color', color);
                $('.hex-text').text(color.toUpperCase());
            });

            $('.color-picker-heading').on('input', function() {
                let color = $(this).val();
                $('.color-display-heading').css('background-color', color);
                $('.hex-heading').text(color.toUpperCase());
            });

            $('.color-picker-badge').on('input', function() {
                let color = $(this).val();
                $('.color-display-badge').css('background-color', color);
                $('.hex-badge').text(color.toUpperCase());
            });

            $('.color-picker-border').on('input', function() {
                let color = $(this).val();
                $('.color-display-border').css('background-color', color);
                $('.hex-border').text(color.toUpperCase());
            });

            $('.color-picker-input-focus').on('input', function() {
                let color = $(this).val();
                $('.color-display-input-focus').css('background-color', color);
                $('.hex-input-focus').text(color.toUpperCase());
            });

            $('.color-picker-success').on('input', function() {
                let color = $(this).val();
                $('.color-display-success').css('background-color', color);
                $('.hex-success').text(color.toUpperCase());
            });

            $('.color-picker-danger').on('input', function() {
                let color = $(this).val();
                $('.color-display-danger').css('background-color', color);
                $('.hex-danger').text(color.toUpperCase());
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

