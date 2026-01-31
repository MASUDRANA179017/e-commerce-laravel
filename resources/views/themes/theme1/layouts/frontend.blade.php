<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $business_setup->meta_title ?? config('app.name', 'E-Commerce'))</title>
    <meta name="description" content="@yield('description', $business_setup->meta_description ?? 'Best Online Shopping Experience')">
    <meta name="keywords" content="@yield('keywords', $business_setup->meta_keywords ?? 'online shopping, e-commerce')">

    @if (!empty($business_setup->google_analytics_id))
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $business_setup->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ $business_setup->google_analytics_id }}');
        </script>
    @endif

    <!-- Favicon -->
    <link rel="shortcut icon"
        href="{{ $business_setup && $business_setup->favicon ? asset('storage/' . $business_setup->favicon) : asset('frontend/assets/images/logo.png') }}"
        type="image/x-icon">
    <link rel="icon"
        href="{{ $business_setup && $business_setup->favicon ? asset('storage/' . $business_setup->favicon) : asset('frontend/assets/images/logo.png') }}"
        type="image/x-icon">

    @php
        $themePrimary = $business_setup->theme_color_primary ?? '#0496ff';
        $themeSecondary = $business_setup->theme_color_secondary ?? '#1a1a2e';
        $themeAccent = $business_setup->theme_color_accent ?? '#f9c123';
        $themeButtonTextColor = $business_setup->theme_button_text_color ?? '#ffffff';
        $themeSecondaryButtonBg = $business_setup->theme_secondary_button_bg ?? '#f5f5f5';
        $themeSecondaryButtonText = $business_setup->theme_secondary_button_text ?? '#333333';
        $themeLinkColor = $business_setup->theme_color_link ?? '#0496ff';
        $themeTextColor = $business_setup->theme_color_text ?? '#333333';
        $themeHeadingColor = $business_setup->theme_color_heading ?? '#1a1a2e';
        $themeBadgeColor = $business_setup->theme_color_badge ?? '#f9c123';
        $themeBorderColor = $business_setup->theme_color_border ?? '#e0e0e0';
        $themeInputFocusColor = $business_setup->theme_color_input_focus ?? '#0496ff';
        $themeSuccessColor = $business_setup->theme_color_success ?? '#28a745';
        $themeDangerColor = $business_setup->theme_color_danger ?? '#dc3545';
        $themeFont = $business_setup->theme_font_primary ?? 'Outfit';
        $themeBaseSize = $business_setup->theme_font_base_size ?? '16px';
        $googleFontFamily = str_replace(' ', '+', $themeFont);

        $themeHeaderStyle = strtolower($business_setup->theme_header_style ?? 'default');
        $themeFooterStyle = strtolower($business_setup->theme_footer_style ?? 'default');
        $bodyClasses = [];
        if ($themeHeaderStyle === 'sticky') $bodyClasses[] = 'header-sticky-mode';
        if ($themeHeaderStyle === 'transparent') $bodyClasses[] = 'header-transparent-mode';
        if ($themeFooterStyle === 'minimal') $bodyClasses[] = 'footer-minimal-mode';
        if ($themeFooterStyle === 'extended') $bodyClasses[] = 'footer-extended-mode';
        $bodyClassAttr = implode(' ', $bodyClasses);
    @endphp

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&family={{ $googleFontFamily }}:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/update-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/default-theme.css') }}" id="switch-color">
    <link rel="stylesheet" href="{{ asset('frontend/css/sticky-header.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/qbit-bms-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <style>
        :root {
            /* Core 3-Color System */
            --primary-color: {{ $themePrimary }};
            --secondary-color: {{ $themeSecondary }};
            --accent-color: {{ $themeAccent }};

            /* Derived Colors & Mappings */
            --tertiary-color: {{ $themeAccent }};
            --quaternary-color: {{ $themeSecondary }};
            --hover-color: {{ $themeSecondary }};

            /* UI Elements mapped to 3-Color System */
            --button-text-color: #ffffff;
            --secondary-button-bg: #f5f5f5;
            --secondary-button-text: {{ $themeSecondary }};
            --link-color: {{ $themePrimary }};
            --text-color: #333333;
            --heading-color: {{ $themeSecondary }};
            --badge-color: {{ $themeAccent }};
            --border-color: #e0e0e0;
            --input-focus-color: {{ $themePrimary }};

            /* Status Colors (Standard) */
            --success-color: #28a745;
            --danger-color: #dc3545;

            /* Section Palettes mapped to 3-color system */
            --primary-six: {{ $themeSecondary }};
            --primary-six-title: {{ $themeSecondary }};
            --primary-six-light: {{ $themeAccent }};
            --primary-seven-heading: {{ $themeSecondary }};
            --primary-eight: {{ $themeAccent }};

            --base-font-size: {{ $themeBaseSize }};
            /* Legacy color variables for compatibility */
            --apece-primary: {{ $themePrimary }};
            --primary: {{ $themePrimary }};
        }

        body {
            font-family: '{{ $themeFont }}', sans-serif;
            font-size: var(--base-font-size);
            color: var(--text-color);
        }

        /* Layout toggles from theme customizer */
        .header-transparent-mode .header-area,
        .header-transparent-mode .header-two,
        .header-transparent-mode .header-six-area {
            background: transparent;
            position: absolute;
            width: 100%;
            z-index: 20;
        }

        .header-sticky-mode .header-area,
        .header-sticky-mode .header-two,
        .header-sticky-mode .header-six-area {
            position: sticky;
            top: 0;
            z-index: 30;
            backdrop-filter: blur(6px);
        }

        .footer-minimal-mode .footer-area {
            padding-top: 40px;
            padding-bottom: 30px;
        }

        .footer-extended-mode .footer-area {
            padding-top: 90px;
            padding-bottom: 70px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: '{{ $themeFont }}', sans-serif;
        }

        /* ============================
           UNIVERSAL COLOR OVERRIDES
           All 3 colors: Primary, Secondary, Accent
           ============================ */

        /* PRIMARY COLOR - Main CTAs, buttons, active states */
        .btn--primary,
        .btn-primary,
        .create-btn-base,
        .select-btn-base,
        .btn--dark,
        .primary-btn,
        a.btn--primary,
        a.create-btn-base {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: var(--button-text-color) !important;
        }

        .btn--primary:hover,
        .btn-primary:hover,
        .create-btn-base:hover,
        .select-btn-base:hover,
        .btn--dark:hover,
        a.btn--primary:hover,
        a.create-btn-base:hover,
        .btn--primary:active,
        .btn-primary:active,
        .btn--primary.active,
        .btn-primary.active {
            background-color: color-mix(in srgb, var(--primary-color) 85%, black) !important;
            border-color: color-mix(in srgb, var(--primary-color) 85%, black) !important;
            color: #ffffff !important;
        }

        /* ALL BUTTON VARIANTS - text color */
        button,
        .btn,
        [class*="btn-"],
        [class*="btn--"],
        input[type="button"],
        input[type="submit"],
        .button {
            color: var(--button-text-color) !important;
        }

        /* Secondary button text and background */
        .btn--white,
        .btn-secondary,
        .select-btn-white,
        .create-btn-white {
            background-color: var(--secondary-button-bg) !important;
            color: var(--secondary-button-text) !important;
            border-color: var(--secondary-button-bg) !important;
        }

        .btn--white:hover,
        .btn-secondary:hover,
        .select-btn-white:hover,
        .create-btn-white:hover {
            background-color: color-mix(in srgb, var(--secondary-button-bg) 85%, black) !important;
            color: var(--secondary-button-text) !important;
            border-color: color-mix(in srgb, var(--secondary-button-bg) 85%, black) !important;
        }

        /* Links use primary
        a:not(.dropdown-item):not(.nav-link):not(.pagination a) {
            color: var(--primary-color) !important;
        }
        a:not(.btn) {
            color: white !important;
        }
        a:not(.btn):not(.dropdown-item):not(.nav-link):not(.pagination a):hover {
            color: color-mix() !important;
        } */

        /* Headings use heading color */
        /* h1, h2, h3, h4, h5, h6, */
        .heading,
        .title,
        .section-title,
        .product-title,
        .post-title {
            color: var(--heading-color) !important;
        }

        /* Text color for body and paragraphs */
        p, span, li, td, th:not([class*="color"]) {
            color: var(--text-color);
        }

        /* Badge color */
        .badge,
        .badge-info,
        .qbit-badge,
        .rating-badge,
        .status-badge {
            background-color: var(--badge-color) !important;
            color: #fff !important;
        }

        /* Borders */
        .border,
        .border-top,
        .border-bottom,
        .border-left,
        .border-right,
        [class*="border-"] {
            border-color: var(--border-color) !important;
        }

        /* Input focus states */
        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            border-color: var(--input-focus-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(var(--input-focus-color), 0.25) !important;
        }

        .form-check-input:checked {
            background-color: var(--input-focus-color) !important;
            border-color: var(--input-focus-color) !important;
        }

        /* Success color for alerts and badges */
        .alert-success,
        .badge-success,
        .text-success,
        .status-success {
            /* background-color: var(--success-color) !important; */
            color: rgba(var(--primary-color)) !important;
            border-color: var(--success-color) !important;
        }

        /* Danger color for alerts and badges */
        .alert-danger,
        .badge-danger,
        .text-danger,
        .status-danger {
            /* background-color: var(--danger-color) !important; */
            color: var(--danger-color) !important;
            border-color: var(--danger-color) !important;
        }

        /* Featured Products Tabs (User Request) */
        .difference-two__tab-btn {
            background-color: var(--primary-color) !important;
            color: var(--secondary-color) !important;
            border: 1px solid var(--primary-color) !important;
        }

        .difference-two__tab-btn:hover,
        .difference-two__tab-btn.active {
            color: #ffffff !important;
            filter: brightness(0.9);
        }

        /* Navigation active states */
        .navbar__list li a:hover,
        .navbar__list li a.active,
        .nav-link.active {
            color: var(--primary-color) !important;
        }

        .navbar__item:hover {
            color: var(--primary-color) !important;
        }

        /* FAQ Section Title (User Request) */
        .faq-eight-area .title-animation {
            color: var(--primary-color) !important;
        }

        /* Badges and pills - primary light background */
        .badge-primary,
        .badge-soft,
        .badge-light-primary,
        .qbit-badge-light,
        .badge-info {
            background-color: rgba(var(--primary-color), 0.1) !important;
            color: var(--primary-color) !important;
            border-color: rgba(var(--primary-color), 0.2) !important;
        }

        /* Primary color borders */
        .border-primary,
        .border-top-primary {
            border-color: var(--primary-color) !important;
        }

        /* Price highlight - use primary */
        .price-new,
        .sale-price,
        .product-price,
        .price-discount {
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        /* Category tags and filters - primary */
        .category-tag,
        .product-tag,
        .filter-tag {
            background-color: rgba(var(--primary-color), 0.08) !important;
            color: var(--primary-color) !important;
            border-color: rgba(var(--primary-color), 0.15) !important;
        }

        .category-tag:hover,
        .product-tag:hover,
        .filter-tag:hover,
        .category-tag.active,
        .product-tag.active,
        .filter-tag.active {
            background-color: var(--primary-color) !important;
            color: #fff !important;
        }

        /* Dropdown and select styling */
        .dropdown-item.active,
        .dropdown-item:active {
            background-color: var(--primary-color) !important;
            color: #fff !important;
        }

        .dropdown-item:hover {
            background-color: rgba(var(--primary-color), 0.1) !important;
            color: var(--primary-color) !important;
        }

        /* Pagination - primary color */
        .pagination .page-link.active,
        .pagination .page-link.active:hover {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #fff !important;
        }

        .pagination .page-link:hover {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        /* Modals - primary tint */
        .modal-header {
            background-color: rgba(var(--primary-color), 0.05) !important;
            border-bottom-color: rgba(var(--primary-color), 0.2) !important;
        }

        .modal-title {
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        .alert-primary {
            background-color: rgba(var(--primary-color), 0.1) !important;
            color: var(--primary-color) !important;
            border-color: rgba(var(--primary-color), 0.3) !important;
        }

        /* Form inputs focus - primary */
        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(var(--primary-color), 0.25) !important;
        }

        .form-check-input:checked {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        /* Tabs and pills - primary */
        .nav-tabs .nav-link.active,
        .nav-pills .nav-link.active,
        .tab-active {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            background-color: rgba(var(--primary-color), 0.05) !important;
        }

        /* SECONDARY COLOR - Backgrounds, headers, dark elements */
        .bg-secondary-custom,
        .header-secondary,
        .sidebar-secondary,
        .panel-secondary {
            background-color: var(--secondary-color) !important;
        }

        .text-secondary-custom {
            color: var(--secondary-color) !important;
        }

        .border-secondary-custom {
            border-color: var(--secondary-color) !important;
        }

        /* Section backgrounds with secondary */
        .hero-section,
        .feature-section {
            background: linear-gradient(135deg, rgba(var(--secondary-color), 0.05) 0%, rgba(var(--primary-color), 0.05) 100%) !important;
        }

        /* Dark headers/footers using secondary */
        .header-dark {
            background-color: var(--secondary-color) !important;
            color: #fff !important;
        }

        .footer-dark {
            background-color: var(--secondary-color) !important;
        }

        /* ACCENT COLOR - Highlights, warnings, special offers */
        .text-accent,
        .accent-text,
        .highlight-text {
            color: var(--accent-color) !important;
        }

        .bg-accent,
        .accent-bg {
            background-color: var(--accent-color) !important;
        }

        .border-accent {
            border-color: var(--accent-color) !important;
        }

        /* Star ratings use accent */
        .fa-star,
        .fa-star-half,
        .star-fill,
        .rating-star {
            color: var(--accent-color) !important;
        }

        /* Badge warnings and accents */
        .badge-warning,
        .badge-success,
        .badge-highlight {
            background-color: var(--accent-color) !important;
            color: #fff !important;
        }

        /* Special offer labels */
        .offer-badge,
        .new-badge,
        .hot-badge,
        .sale-badge {
            background-color: var(--accent-color) !important;
            color: #fff !important;
        }

        /* Product discount percentage */
        .discount-percent,
        .discount-label {
            background-color: var(--accent-color) !important;
            color: #fff !important;
        }

        /* Flash sale elements */
        .flash-sale-badge,
        .countdown-badge {
            background-color: var(--accent-color) !important;
            color: #fff !important;
        }

        /* Testimonial highlights */
        .testimonial-accent,
        .quote-mark {
            color: var(--accent-color) !important;
        }

        /* Alert success/warning */
        .alert-accent {
            background-color: rgba(var(--accent-color), 0.1) !important;
            color: var(--accent-color) !important;
            border-color: var(--accent-color) !important;
        }

        /* Progress bars - secondary */
        .progress-bar {
            background-color: var(--primary-color) !important;
        }

        .progress-bar-secondary {
            background-color: var(--secondary-color) !important;
        }

        .progress-bar-accent {
            background-color: var(--accent-color) !important;
        }

        /* Tooltips and popovers */
        .tooltip-inner {
            background-color: var(--primary-color) !important;
        }

        .popover-header {
            background-color: var(--primary-color) !important;
            color: #fff !important;
        }

        /* Spinner/loader */
        .spinner-border,
        .spinner-grow {
            color: var(--primary-color) !important;
        }

        /* Rating and hearts (wishlist) */
        .heart-icon.active,
        .fa-heart.active {
            color: var(--accent-color) !important;
        }

        /* Product card elements */
        .product-card-title {
            font-family: '{{ $themeFont }}', sans-serif !important;
        }

        .product-card-rating .fa-star {
            color: var(--accent-color) !important;
        }

        /* Section titles with primary accent */
        .section-title span,
        .title-main span,
        .title-highlight {
            color: var(--primary-color) !important;
        }

        /* Progress bars */
        .progress-bar {
            background-color: var(--primary-color) !important;
        }

        /* Tooltips and popovers */
        .tooltip-inner {
            background-color: var(--primary-color) !important;
        }

        .popover-header {
            background-color: var(--primary-color) !important;
            color: #fff !important;
        }

        /* Spinner/loader */
        .spinner-border,
        .spinner-grow {
            color: var(--primary-color) !important;
        }

        /* Rating and hearts (wishlist) */
        .heart-icon.active,
        .fa-heart.active {
            color: var(--primary-color) !important;
        }

        /* Product card elements */
        .product-card-title {
            font-family: '{{ $themeFont }}', sans-serif !important;
        }

        .product-card-rating .fa-star {
            color: var(--accent-color) !important;
        }

        /* Section titles with primary accent */
        .section-title span,
        .title-main span,
        .title-highlight {
            color: var(--primary-color) !important;
        }

        /* Shop sidebar */
        /* .shop-sidebar-widget {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        } */

        .shop-sidebar-widget .intro h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
        }

        .sidebar-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-list ul li {
            margin-bottom: 12px;
        }

        .sidebar-list ul li a {
            color: #666;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            font-size: 14px;
        }

        /* .sidebar-list ul li a:hover,
        .sidebar-list ul li.active a {
            color: var(--primary-color);
            padding-left: 5px;
        } */

        /* .tag-wrapper a {
            display: inline-block;
            padding: 6px 15px;
            background: #f5f5f5;
            border-radius: 20px;
            margin: 5px;
            font-size: 13px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
        } */

        .tag-wrapper a:hover,
        .tag-wrapper a.active {
            background: var(--primary-color);
            color: #fff;
        }

        /* Text & Typography Styles */
        a {
            text-decoration: none !important;
        }

        /* h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: '{{ $themeFont }}', sans-serif;
            font-weight: 600;
            color: #333;
            line-height: 1.3;
        } */

        p {
            font-family: '{{ $themeFont }}', sans-serif;
            font-size: calc(var(--base-font-size) * 0.94);
            line-height: 1.7;
            color: #666;
            text-align: left;
        }

        .text-white p {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Navbar link styles */
        .navbar__list li a {
            text-decoration: none;
            color: calc(var(--text-color) * 1);
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar__list li a:hover {
            color: var(--primary-color);
        }

        /* Footer text styles */
        .footer-two__widget p,
        .footer-two__widget a {
            color: rgba(59, 51, 51, 0.7);
            text-decoration: none;
            font-size: 14px;
            line-height: 1.8;
        }

        .footer-two__widget a:hover {
            color: var(--primary-color);
        }

        .footer-two__widget h5 {
            color: #fff;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .footer-two__widget ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-two__widget ul li {
            margin-bottom: 10px;
        }

        /* Footer logo and social icons visibility */
        .footer-two__widget-logo img {
            max-height: 60px;
            opacity: 1 !important;
            filter: none !important;
        }

        .footer-two__widget .social a {
            color: #fff !important;
            opacity: 1 !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .footer-two__widget .social a i {
            color: #fff !important;
            font-size: 16px;
        }

        .footer-two__widget .social a:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.25);
        }

        .dark-body .footer-two .footer-two__widget .social a {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .footer-eight-area::before {
            pointer-events: none;
            z-index: 0;
        }

        .footer-two,
        .footer-eight-area {
            position: relative;
        }

        .footer-two .container,
        .footer-eight-area .container {
            position: relative;
            z-index: 1;
        }

        .footer-two .footer-two__widget,
        .footer-two .footer-two__widget * {
            user-select: text !important;
        }

        .footer-eight-area .footer-two__widget h5 {
            color: #fff !important;
        }

        .footer-eight-area .footer-two__widget p {
            color: rgba(255, 255, 255, 0.85) !important;
        }

        .footer-eight-area .footer-two__widget li a {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        @media (max-width: 992px) {
            .footer-two {
                padding-top: 60px;
            }

            .footer-two .divider {
                margin: 40px 0;
            }

            .footer-two .footer-two__widget h5 {
                font-size: 17px;
            }
        }

        @media (max-width: 768px) {
            .footer-two {
                padding-top: 40px;
            }

            .footer-eight-area {
                margin: 0;
                border-radius: 0;
                padding-top: 20px !important;
            }

            .footer-eight-top {
                margin-bottom: 20px;
                padding-bottom: 12px;
            }

            .footer-two .footer-two__widget h5 {
                font-size: 16px;
            }

            .footer-two .footer-two__widget p,
            .footer-two .footer-two__widget a {
                font-size: 13px;
                line-height: 1.7;
            }

            .footer-two .footer-two__widget .social a {
                width: 36px;
                height: 36px;
            }

            .footer-two .footer-two__copyright-inner p {
                font-size: 13px;
            }

            .footer-eight-top .col-xl-3,
            .footer-eight-top .col-lg-3,
            .footer-eight-top .col-md-3 {
                width: 100%;
                flex: 0 0 100%;
                margin-bottom: 12px;
            }

            .footer-two .row>div {
                margin-bottom: 20px;
            }

            .footer-two .row>div:nth-last-of-type(1) {
                margin-bottom: 0;
            }

            .footer-eight-area .subscribe-six-button .btn-six-primary {
                display: inline-flex !important;
            }
        }

        @media (max-width: 576px) {

            .footer-eight-top-info,
            .footer-eight-top-info-con,
            .footer-two__widget,
            .footer-two__widget-intro,
            .footer-two__widget-content {
                text-align: center;
            }

            .footer-eight-top-info {
                justify-content: center;
            }

            .footer-eight-top-icon {
                margin: 0 auto 8px;
            }

            .footer-two__widget .social {
                display: flex;
                justify-content: center;
            }

            .footer-two__widget ul li a,
            .footer-two__widget-content--contact ul li a {
                display: flex;
                justify-content: center;
            }

            .footer-two .footer-two__widget .line {
                justify-content: center;
            }

            .footer-two .footer-two__widget h5,
            .footer-two .footer-two__widget .footer-two__widget-intro {
                text-align: center;
            }

            .footer-eight-top-wrap h4 {
                text-align: center;
            }
        }

        /* Topbar text */
        .topbar a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 13px;
        }

        .topbar a:hover {
            color: #fff;
        }

        /* Section titles */
        .section-eight-wrapper h2,
        .section-six-wrapper h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .section-eight-wrapper h6,
        .section-six-wrapper h6 {
            font-size: 14px;
            text-transform: none;
            letter-spacing: 0;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        /* FAQ accordion text */
        .faq-eight-accordion-button {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
        }

        .faq-eight-accordion-body p {
            font-size: 14px;
            color: #666;
        }

        /* Testimonial text */
        .testimonial-six-paragraph {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            font-style: italic;
        }

        /* Product card text */
        .property-single-content h4 a {
            text-decoration: none;
        }

        .property-single-content p {
            margin-bottom: 0;
            font-size: 13px;
        }

        .property-details li {
            font-size: 14px;
        }

        /* Banner text */
        .banner-two__slider-content h1 {
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .banner-two__slider-content p {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 25px;
        }

        /* Category card text */
        .ministrie-eight-title a {
            color: #fff;
            text-decoration: none;
            font-size: 20px;
            font-weight: 600;
        }

        .ministrie-eight-paragraph {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }
    </style>

    @stack('styles')
</head>

<body class="{{ $bodyClassAttr }}">
    <div class="page-wrapper">

        <!-- ========== TOPBAR ========== -->
        {{-- <div class="topbar topbar-six-area d-none d-lg-block overflow-visible z-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="topbar-six__wrapper d-flex justify-content-between align-items-center">
                            <!-- left -->
                            <div class="topbar__list-wrapper">
                                <ul class="topbar__list topbar-six-list">
                                    <li>
                                        <a class="fw-normal"
                                            href="mailto:{{ config('mail.from.address', 'info@shop.com') }}">
                                            <i class="fa-regular fa-envelope"></i> {{ config('mail.from.address',
                                            'info@shop.com') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="fw-normal" href="tel:{{ $business_setup->official_contact_number[0] ?? '+8801700000000' }}">
                                            <i class="fa-solid fa-phone"></i> Sales: {{ $business_setup->official_contact_number[0] ?? '+880 1700-000000' }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="fw-normal" href="tel:{{ $business_setup->hotline_number[0] ?? '+8801800000000' }}">
                                            <i class="fa-solid fa-headset"></i> Hotline: {{ $business_setup->hotline_number[0] ?? '+880 1800-000000' }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- right -->
                            <div class="topbar-six-right">
                                <ul
                                    class="d-flex footer__bottom-list gap-4 justify-content-center justify-content-lg-end">
                                    @guest
                                        <li><a class="fw-normal" href="{{ route('login') }}"><i class='bx bx-user'></i>
                                                Login</a></li>
                                        <li><a class="fw-normal" href="{{ route('register') }}"><i
                                                    class='bx bx-user-plus'></i> Register</a></li>
                                    @else
                                        <li><a class="fw-normal" href="{{ route('dashboard') }}"><i class='bx bx-user'></i>
                                                My Account</a></li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        @include('frontend.partials.topbar')

        <!-- ========== HEADER ========== -->
        {{-- <header class="header header-tertiary header-six-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="main-header__menu-box">
                            <nav class="navbar p-0">
                                <!-- Brand -->
                                <div class="navbar-logo">
                                    <a href="{{ url('/') }}" aria-label="Home">
                                        <img src="{{ $business_setup && $business_setup->logo ? asset('storage/' . $business_setup->logo) : asset('frontend/assets/images/logo.png') }}"
                                            alt="{{ config('app.name') }}" height="50">
                                    </a>
                                </div>

                                <!-- Nav -->
                                <div class="navbar__options">
                                    <div class="header-six-navbar-space d-flex justify-content-end">
                                        <nav class="navbar__menu d-none d-xl-block" aria-label="Primary">
                                            @php
                                                $menus = [];
                                                $menuPath = null;
                                                if (\Illuminate\Support\Facades\Storage::disk('local')->exists('menus.json')) {
                                                    $menuPath = 'menus.json';
                                                } elseif (\Illuminate\Support\Facades\Storage::disk('local')->exists('private/menus.json')) {
                                                    $menuPath = 'private/menus.json';
                                                }
                                                if ($menuPath) {
                                                    $menus = json_decode(\Illuminate\Support\Facades\Storage::disk('local')->get($menuPath), true) ?: [];
                                                }
                                                $mainMenu = $menus['main'] ?? [];
                                            @endphp
                                            @php
                                                $renderMenu = function($items) use (&$renderMenu) {
                                                    echo '<ul class="navbar__list">';
                                                    foreach ($items as $m) {
                                                        $hasChildren = is_array($m) && isset($m['children']) && is_array($m['children']) && count($m['children']) > 0;
                                                        if ($hasChildren) {
                                                            echo '<li class="navbar__item navbar__item--has-children nav-fade">';
                                                            echo '<a href="'.e($m['url']).'">'.e($m['label']).'</a>';
                                                            echo '<ul class="navbar__sub-menu">';
                                                            foreach ($m['children'] as $c) {
                                                                $childHasChildren = is_array($c) && isset($c['children']) && is_array($c['children']) && count($c['children']) > 0;
                                                                if ($childHasChildren) {
                                                                    echo '<li class="navbar__item navbar__item--has-children">';
                                                                    echo '<a href="'.e($c['url']).'">'.e($c['label']).'</a>';
                                                                    echo '<ul class="navbar__sub-menu">';
                                                                    foreach ($c['children'] as $cc) {
                                                                        echo '<li><a href="'.e($cc['url']).'">'.e($cc['label']).'</a></li>';
                                                                    }
                                                                    echo '</ul>';
                                                                    echo '</li>';
                                                                } else {
                                                                    echo '<li><a href="'.e($c['url']).'">'.e($c['label']).'</a></li>';
                                                                }
                                                            }
                                                            echo '</ul>';
                                                            echo '</li>';
                                                        } else {
                                                            echo '<li class="navbar__item nav-fade"><a href="'.e($m['url']).'">'.e($m['label']).'</a></li>';
                                                        }
                                                    }
                                                    echo '</ul>';
                                                };
                                            @endphp
                                            {!! $renderMenu($mainMenu) !!}




                                            </ul>
                                        </nav>
                                    </div>
                                    <!-- Cart & Wishlist -->
                                    <div class="contact-btn d-flex align-items-center gap-3">
                                        <a href="#" class="open-search" aria-label="Open search">
                                                        <i class="fa-solid fa-magnifying-glass fs-4"></i>
                                                    </a>
                                        <a href="{{ route('wishlist.index') }}" class="position-relative text-dark"
                                            title="Wishlist" style="text-decoration: none;">
                                            <i class='bx bx-heart fs-4'></i>
                                            @php $wishlistCount = count(session('wishlist', [])); @endphp
                                            <span class="cart-count wishlist-count">{{ $wishlistCount }}</span>
                                        </a>
                                        <button type="button"
                                            class="open-cart position-relative text-dark border-0 bg-transparent"
                                            title="Cart" style="text-decoration: none; cursor: pointer;"
                                            onclick="openSidebarCart()">
                                            <i class='bx bx-cart fs-4'></i>
                                            @php $cartCount = array_sum(array_column(session('cart', []), 'qty')); @endphp
                                            <span class="cart-count">{{ $cartCount }}</span>
                                        </button>
                                    </div>
                                    <!-- Mobile toggle -->
                                    <button class="open-offcanvas-nav d-flex d-xl-none" aria-label="toggle mobile menu"
                                        title="Open menu">
                                        <span class="icon-bar top-bar"></span>
                                        <span class="icon-bar middle-bar"></span>
                                        <span class="icon-bar bottom-bar"></span>
                                    </button>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header> --}}
        @include('frontend.partials.header')

        <!-- ========== MOBILE MENU ========== -->
        {{-- <div class="mobile-menu d-block d-xxl-none">
            <nav class="mobile-menu__wrapper" aria-label="Mobile">
                <div class="mobile-menu__header nav-fade">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ $business_setup && $business_setup->logo ? asset('storage/' . $business_setup->logo) : asset('frontend/assets/images/logo.png') }}"
                                alt="{{ config('app.name') }}">
                        </a>
                    </div>
                    <button aria-label="close mobile menu" class="close-mobile-menu">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="mobile-menu__list"></div>
                <div class="mobile-menu__cta nav-fade d-block d-md-none">
                    <a href="{{ route('shop.index') }}" class="btn--primary">Shop Now <i
                            class="fa-solid fa-shopping-bag ms-1"></i></a>
                </div>
                <div class="mobile-menu__social social nav-fade">
                    @if ($business_setup && $business_setup->facebook_status && $business_setup->facebook_url)
                        <a href="{{ $business_setup->facebook_url }}" target="_blank" title="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    @endif
                    @if ($business_setup && $business_setup->twitter_status && $business_setup->twitter_url)
                        <a href="{{ $business_setup->twitter_url }}" target="_blank" title="twitter"><i class="fa-brands fa-twitter"></i></a>
                    @endif
                    @if ($business_setup && $business_setup->linkedin_status && $business_setup->linkedin_url)
                        <a href="{{ $business_setup->linkedin_url }}" target="_blank" title="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                    @endif
                    @if ($business_setup && $business_setup->youtube_status && $business_setup->youtube_url)
                        <a href="{{ $business_setup->youtube_url }}" target="_blank" title="youtube"><i class="fa-brands fa-youtube"></i></a>
                    @endif
                    @if (isset($business_setup->instagram_status) && isset($business_setup->instagram_url) && $business_setup->instagram_status && $business_setup->instagram_url)
                        <a href="{{ $business_setup->instagram_url }}" target="_blank" title="instagram"><i class="fa-brands fa-instagram"></i></a>
                    @endif
                </div>
            </nav>
        </div>
        <div class="mobile-menu__backdrop"></div> --}}
        {{-- @include('frontend.partials.mobile-menu') --}}

        <!-- ========== SEARCH POPUP ========== -->
        {{-- <div class="search-popup" role="dialog" aria-modal="true" aria-label="Search">
            <button class="close-search" aria-label="Close search box" title="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <form action="{{ route('shop.index') }}" method="get">
                <div class="search-popup__group">
                    <input type="text" name="search" id="searchField" placeholder="Search products..." required>
                    <button type="submit" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div> --}}
        @include('frontend.partials.search-popup')

        <!-- ========== SIDEBAR CART ========== -->
        @include('frontend.partials.sidebar-cart')

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- ========== FOOTER ========== -->
        {{-- <footer class="footer-two footer-six-area footer-eight-area"
            data-background="{{ asset('frontend/assets/images/footer-eight-bg.jpg') }}">
            <div class="container">
                <div class="footer-eight-top">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 d-flex align-items-center">
                            <div class="footer-eight-top-wrap">
                                <h4>Subscribe to Our Newsletter</h4>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 d-flex align-items-center">
                            <div class="footer-eight-top-wrap">
                                <div class="subscribe-six-input">
                                    <input type="email" placeholder="Enter your email">
                                    <div class="subscribe-six-button subscribe-eight-button">
                                        <button
                                            class="btn--primary btn-six-primary d-none d-md-flex text-white fw-medium rounded-5">Subscribe</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 d-flex align-items-center">
                            <div class="footer-eight-top-info position-relative call">
                                <div class="footer-eight-top-icon">
                                    <span><i class="fa-solid fa-phone"></i></span>
                                </div>
                                <div class="footer-eight-top-info-con">
                                    <p>Sales Hotline</p>
                                    <a class="apece-link-line" href="tel:{{ $business_setup->official_contact_number[0] ?? '+8801700000000' }}">{{ $business_setup->official_contact_number[0] ?? '+880 1700-000000' }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 d-flex align-items-center">
                            <div class="footer-eight-top-info position-relative gamil">
                                <div class="footer-eight-top-icon">
                                    <span><i class="fa-solid fa-headset"></i></span>
                                </div>
                                <div class="footer-eight-top-info-con">
                                    <p>Support</p>
                                    <a class="apece-link-line" href="tel:{{ $business_setup->hotline_number[0] ?? '+8801800000000' }}">{{ $business_setup->hotline_number[0] ?? '+880 1800-000000' }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Brand / About -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="footer-two__widget">
                            <div class="footer-two__widget-logo mb-2">
                                <a href="{{ route('home') }}">
                                    <img src="{{ $business_setup && $business_setup->logo ? asset('storage/' . $business_setup->logo) : asset('frontend/assets/images/logo.png') }}"
                                        alt="{{ config('app.name') }}" height="50">
                                </a>
                            </div>
                            <div class="footer-two__widget-content">
                                <p class="sub-itle-lg">
                                    {{ $business_setup->footer_text ?? 'Your one-stop destination for quality products at affordable prices. Shop with confidence and enjoy fast delivery.' }}
                                </p>
                                <div class="social">
                                    @if ($business_setup && $business_setup->facebook_status && $business_setup->facebook_url)
                                        <a href="{{ $business_setup->facebook_url }}" target="_blank" aria-label="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                    @endif
                                    @if (isset($business_setup->instagram_status) && isset($business_setup->instagram_url) && $business_setup->instagram_status && $business_setup->instagram_url)
                                        <a href="{{ $business_setup->instagram_url }}" target="_blank" aria-label="instagram"><i class="fa-brands fa-instagram"></i></a>
                                    @endif
                                    @if ($business_setup && $business_setup->twitter_status && $business_setup->twitter_url)
                                        <a href="{{ $business_setup->twitter_url }}" target="_blank" aria-label="twitter"><i class="fa-brands fa-twitter"></i></a>
                                    @endif
                                    @if ($business_setup && $business_setup->youtube_status && $business_setup->youtube_url)
                                        <a href="{{ $business_setup->youtube_url }}" target="_blank" aria-label="youtube"><i class="fa-brands fa-youtube"></i></a>
                                    @endif
                                    @if ($business_setup && $business_setup->linkedin_status && $business_setup->linkedin_url)
                                        <a href="{{ $business_setup->linkedin_url }}" target="_blank" aria-label="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-12 col-md-6 col-xl-2 offset-xl-1">
                        <div class="footer-two__widget">
                            <div class="footer-two__widget-intro">
                                <h5>Quick Links</h5>
                                <div class="line">
                                    <span class="large-line"></span>
                                    <span class="small-line"></span>
                                    <span class="small-line"></span>
                                </div>
                            </div>
                            <div class="footer-two__widget-content">
                                <ul>
                                    @php $footerMenu = $menus['footer'] ?? []; @endphp
                                    @foreach ($footerMenu as $m)
                                        <li>
                                            <a class="text-white sub-title-lg" href="{{ $m['url'] }}">
                                                <span><i class="fa-solid fa-angle-right me-2"></i></span> {{ $m['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Service -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="footer-two__widget footer-two__widget--alternate">
                            <div class="footer-two__widget-intro">
                                <h5>Customer Service</h5>
                                <div class="line">
                                    <span class="large-line"></span>
                                    <span class="small-line"></span>
                                    <span class="small-line"></span>
                                </div>
                            </div>
                            <div class="footer-two__widget-content">
                                <ul>
                                    <li><a class="text-white sub-title-lg" href="{{ route('cart.index') }}"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> My Cart</a></li>
                                    <li><a class="text-white sub-title-lg" href="{{ route('wishlist.index') }}"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> Wishlist</a></li>
                                    <li><a class="text-white sub-title-lg" href="#"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> Track Order</a>
                                    </li>
                                    <li><a class="text-white sub-title-lg" href="#"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> Returns &
                                            Refunds</a></li>
                                    <li><a class="text-white sub-title-lg" href="#"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> FAQs</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="footer-two__widget footer-two__widget--alternate">
                            <div class="footer-two__widget-intro">
                                <h5>Get In Touch</h5>
                                <div class="line">
                                    <span class="large-line"></span>
                                    <span class="small-line"></span>
                                    <span class="small-line"></span>
                                </div>
                            </div>
                            <div class="footer-two__widget-content footer-two__widget-content--contact">
                                <ul>
                                    <li>
                                        <a class="text-white sub-title-lg" href="#">
                                            <i class="fa-solid fa-location-dot"></i> {{ $business_setup->street_address ?? '' }}{{ ($business_setup->street_address ?? '') && ($business_setup->city_thana ?? '') ? ', ' : '' }}{{ $business_setup->city_thana ?? '' }}{{ ($business_setup->district ?? '') ? ', ' . $business_setup->district : '' }}
                                        </a>
                                    </li>
                                    <li><a class="text-white sub-title-lg" href="tel:{{ $business_setup->official_contact_number[0] ?? '+8801700000000' }}"><i
                                                class="fa-solid fa-phone"></i> {{ $business_setup->official_contact_number[0] ?? '+880 1700-000000' }}</a></li>
                                    <li><a class="text-white sub-title-lg" href="mailto:{{ $business_setup->email_address[0] ?? 'info@shop.com' }}"><i
                                                class="fa-solid fa-envelope"></i> {{ $business_setup->email_address[0] ?? 'info@shop.com' }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-two__copyright footer-six-copyright">
                <div class="container">
                    <div class="row align-items-center gutter-12 footer-six-copyright-border position-relative">
                        <div class="col-12 col-lg-6">
                            <div class="footer-two__copyright-inner text-center text-lg-start">
                                <p>
                                    @if ($business_setup && $business_setup->copyright_text)
                                        {{ $business_setup->copyright_text }}
                                    @else
                                        Copyright &copy; <span id="copyrightYear">{{ date('Y') }}</span> <a href="{{ url('/') }}">{{ $business_setup->company_name ?? config('app.name') }}</a>. All rights reserved.
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="footer__bottom-left">
                                <ul class="footer__bottom-list justify-content-center justify-content-lg-end">
                                    <li><a href="{{ route('frontend.terms') }}">Terms & Conditions</a></li>
                                    <li><a href="{{ route('frontend.privacy') }}">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer> --}}
        @include('frontend.partials.footer')

    </div>

    <!-- ==== custom cursor ==== -->

    <!-- ==== scroll to top ==== -->
    <button class="progress-wrap" aria-label="scroll indicator" title="back to top">
        <span></span>
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </button>

    @include('frontend.partials.quick-view-modal')
    <!-- JS Dependencies -->
    <script src="{{ asset('frontend/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/odometer.min.js') }}"></script>
    <script src="{{ asset('frontend/js/vanilla-tilt.min.js') }}"></script>
    <script src="{{ asset('frontend/js/aos.js') }}"></script>
    <script src="{{ asset('frontend/js/SplitText.min.js') }}"></script>
    <script src="{{ asset('frontend/js/ScrollToPlugin.min.js') }}"></script>
    <script src="{{ asset('frontend/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('frontend/js/gsap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/swiper-slider.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: '3000'
            };
        }
    </script>

    <!-- Polyfill for missing plugins and elements -->
    <script>
        // MetisMenu polyfill - prevents error if plugin not loaded
        if (typeof jQuery !== 'undefined' && !jQuery.fn.metisMenu) {
            jQuery.fn.metisMenu = function() {
                return this;
            };
        }

        // Create dummy elements for countdown to prevent errors
        (function() {
            var countdownIds = ['days', 'hours', 'minutes', 'seconds', 'headline', 'countdown', 'content'];
            countdownIds.forEach(function(id) {
                if (!document.getElementById(id)) {
                    var dummy = document.createElement('div');
                    dummy.id = id;
                    dummy.style.display = 'none';
                    document.body.appendChild(dummy);
                }
            });
        })();
    </script>

    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.js') }}?v={{ time() }}"></script>

    <script>
        (function bootstrapCart() {
            try {
                @php
                    $__cart = session('cart', []);
                    $__subtotal = 0;
                    foreach ($__cart as $__it) {
                        $__subtotal += ($__it['price'] ?? 0) * ($__it['qty'] ?? 1);
                    }
                @endphp
                window.__CART_ITEMS__ = @json($__cart);
                window.__CART_SUBTOTAL__ = @json($__subtotal);
            } catch (e) {}
        })();

        function showToast(type, message) {
            if (typeof toastr !== 'undefined') {
                var map = {
                    success: 'success',
                    error: 'error',
                    warning: 'warning',
                    info: 'info'
                };
                var fn = map[type] || 'info';
                toastr[fn](String(message || ''));
                return;
            }
            document.querySelectorAll('.toast-notification').forEach(function(t) {
                t.remove();
            });
            var toast = document.createElement('div');
            toast.className = 'toast-notification toast-' + type;
            toast.innerHTML = '<i class="fa-solid fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') +
                ' me-2"></i><span>' + String(message || '') + '</span>';
            document.body.appendChild(toast);
            setTimeout(function() {
                toast.classList.add('show');
            }, 100);
            setTimeout(function() {
                toast.classList.remove('show');
                setTimeout(function() {
                    toast.remove();
                }, 300);
            }, 3000);
        }

        // Add to Cart AJAX
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.add-to-cart');
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();

            const productId = btn.dataset.productId || btn.dataset.id;
            if (!productId) {
                console.error('No product ID found');
                return;
            }

            btn.disabled = true;
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Adding...';

            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify((function() {
                        var payload = {
                            product_id: productId,
                            quantity: 1
                        };
                        var scope = btn.closest('.product-card') || document;
                        var vidEl = scope.querySelector('[name=\"variant_id\"]');
                        var vnameEl = scope.querySelector('[name=\"variant\"]');
                        var qtyEl = scope.querySelector('[name=\"quantity\"]');
                        if (vidEl && vidEl.value) payload.variant_id = vidEl.value;
                        if (vnameEl && vnameEl.value) payload.variant = vnameEl.value;
                        if (qtyEl && qtyEl.value) {
                            var q = parseInt(qtyEl.value);
                            payload.quantity = isNaN(q) || q < 1 ? 1 : q;
                        }
                        return payload;
                    })())
                })
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;

                    if (data.success) {
                        // Update cart count in header
                        document.querySelectorAll('.cart-count:not(.wishlist-count)').forEach(el => {
                            el.textContent = data.cartCount;
                        });
                        showToast('success', data.message || 'Product added to cart!');

                        try {
                            var list = document.querySelector('#sidebarCart .cart-items-list');
                            var body = document.querySelector('#sidebarCart .sidebar-cart-body');
                            var headerCount = document.querySelector('#sidebarCart .cart-items-count');

                            // Remove empty cart message if present
                            var emptyCart = document.querySelector('#sidebarCart .empty-cart');
                            if (emptyCart) emptyCart.remove();

                            if (data.addedItem) {
                                if (!list) {
                                    if (body) body.innerHTML = '<div class="cart-items-list"></div>';
                                    list = document.querySelector('#sidebarCart .cart-items-list');
                                }
                                var item = data.addedItem;
                                var img = item.options && item.options.image ? ('/storage/' + item.options
                                        .image) :
                                    '{{ asset('frontend/assets/images/shop/KHPP-SA21 - 1.png') }}';
                                var slug = item.options && item.options.slug ? item.options.slug : (item.id ||
                                    '');
                                var html = '' +
                                    '<div class="sidebar-cart-item" data-row-id="' + item.rowId +
                                    '" data-product-id="' + (item.id || '') + '">' +
                                    '<div class="cart-item-img">' +
                                    '<img src="' + img + '" alt="' + (item.name || '') + '">' +
                                    '</div>' +
                                    '<div class="cart-item-info">' +
                                    '<h6 class="cart-item-title">' +
                                    '<a href="/product/' + slug + '">' + (item.name || '') + '</a>' +
                                    '</h6>' +
                                    (item.options && item.options.variant ? (
                                        '<small class=\"text-muted d-block mb-1\">Variant: ' + item.options
                                        .variant + '</small>') : '') +
                                    '<div class="cart-item-price">' +
                                    '<span class="price">৳' + (parseInt(item.price) || 0) + '</span>' +
                                    '<span class="multiply">×</span>' +
                                    '<span class="qty">' + (parseInt(item.qty) || 1) + '</span>' +
                                    '<span class="total">= ৳' + ((parseInt(item.price) || 0) * (parseInt(item
                                        .qty) || 1)).toLocaleString() + '</span>' +
                                    '</div>' +
                                    '<div class="cart-item-actions">' +
                                    '<div class="qty-selector">' +
                                    '<button type="button" class="qty-btn" onclick="updateCartQty(\'' + item
                                    .rowId + '\', -1)"><i class="fa-solid fa-minus"></i></button>' +
                                    '<span class="qty-value" id="qty-' + item.rowId + '">' + (parseInt(item
                                        .qty) || 1) + '</span>' +
                                    '<button type="button" class="qty-btn" onclick="updateCartQty(\'' + item
                                    .rowId + '\', 1)"><i class="fa-solid fa-plus"></i></button>' +
                                    '</div>' +
                                    '<div class="variant-selector">' +
                                    '<button type="button" class="qty-btn" onclick="openVariantSelector(\'' +
                                    item.rowId +
                                    '\')" title="Change Variant"><i class="fa-solid fa-sliders"></i></button>' +
                                    '</div>' +
                                    '<button type="button" class="remove-btn" onclick="removeFromCart(\'' + item
                                    .rowId +
                                    '\')" title="Remove"><i class="fa-solid fa-trash-can"></i></button>' +
                                    '</div>' +
                                    '<div class="variant-select-wrap mt-2" style="display:none;">' +
                                    '<select class="form-select form-select-sm variant-select"></select>' +
                                    '<button type="button" class="btn btn-sm btn-primary mt-2" onclick="applyVariantChange(\'' +
                                    item.rowId + '\')">Apply</button>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                                if (list) {
                                    var existing = list.querySelector('.sidebar-cart-item[data-row-id=\"' + item
                                        .rowId + '\"]');
                                    if (existing) existing.remove();
                                    list.insertAdjacentHTML('afterbegin', html);
                                }
                                if (headerCount) headerCount.textContent = data.cartCount + (data.cartCount ===
                                    1 ? ' Item' : ' Items');

                                // Update Footer
                                var footer = document.querySelector('#sidebarCart .sidebar-cart-footer');
                                var subtotal = data.cartTotal || 0;
                                var shippingHtml = '';
                                if (subtotal >= 5000) {
                                    shippingHtml =
                                        '<i class="fa-solid fa-circle-check text-success me-1"></i> You qualify for <strong>FREE shipping</strong>!';
                                } else {
                                    shippingHtml = '<i class="fa-solid fa-truck me-1"></i> Add ৳' + (5000 -
                                            subtotal).toLocaleString() +
                                        ' more for <strong>FREE shipping</strong>';
                                }

                                if (!footer && body) {
                                    var footerHtml = '<div class="sidebar-cart-footer">' +
                                        '<div class="cart-subtotal">' +
                                        '<span>Subtotal:</span>' +
                                        '<span class="subtotal-amount">৳' + subtotal.toLocaleString() +
                                        '</span>' +
                                        '</div>' +
                                        '<p class="shipping-note">' + shippingHtml + '</p>' +
                                        '<div class="cart-buttons">' +
                                        '<a href="/cart" class="btn-view-cart">' +
                                        '<i class="fa-solid fa-cart-shopping me-2"></i> View Cart' +
                                        '</a>' +
                                        '<a href="/checkout" class="btn-checkout">' +
                                        '<i class="fa-solid fa-lock me-2"></i> Checkout' +
                                        '</a>' +
                                        '</div>' +
                                        '</div>';
                                    body.insertAdjacentHTML('afterend', footerHtml);
                                } else if (footer) {
                                    var subEl = footer.querySelector('.subtotal-amount');
                                    if (subEl) subEl.textContent = '৳' + subtotal.toLocaleString();
                                    var shipEl = footer.querySelector('.shipping-note');
                                    if (shipEl) shipEl.innerHTML = shippingHtml;
                                }
                            }
                        } catch (e) {}

                        // Open cart sidebar after a brief delay
                        setTimeout(function() {
                            if (typeof openSidebarCart === 'function') {
                                openSidebarCart();
                            }
                        }, 300);

                        try {
                            if (window.__CART_ITEMS__ && data.addedItem && data.addedItem.rowId) {
                                window.__CART_ITEMS__[data.addedItem.rowId] = {
                                    id: data.addedItem.id,
                                    name: data.addedItem.name,
                                    price: data.addedItem.price,
                                    qty: data.addedItem.qty,
                                    options: data.addedItem.options || {}
                                };
                                if (typeof data.cartTotal === 'number') {
                                    window.__CART_SUBTOTAL__ = data.cartTotal;
                                }
                            }
                        } catch (e) {}
                    } else {
                        showToast('error', data.message || 'Failed to add product to cart');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                    showToast('error', 'Something went wrong. Please try again.');
                });
        });

        // Add to Wishlist AJAX
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.add-to-wishlist');
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();

            const productId = btn.dataset.productId || btn.dataset.id;
            const hasInWishList = btn.dataset.hasInWishlist;
            if (!productId) return;

            btn.disabled = true;
            const icon = btn.querySelector('i');
            const originalClass = icon ? icon.className : '';
            if (icon) icon.className = 'fa-solid fa-spinner fa-spin';
            console.log({hasInWishList});
            if (hasInWishList === 'true') {
                fetch(`/wishlist/remove/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                    })
                    .then(response => response.json())
                    .then(data => {
                        btn.disabled = false;

                        if (data.success) {
                            btn.dataset.hasInWishlist = 'false';
                            icon.className = 'fa-regular fa-heart';
                            btn.classList.remove('active', 'text-danger');
                            showToast('success', data.message);
                        } else {
                            if (icon) icon.className = originalClass;
                            showToast('error', data.message || 'Failed to update wishlist');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        btn.disabled = false;
                        if (icon) icon.className = originalClass;
                        showToast('error', 'Something went wrong. Please try again.');
                    });
            } else {
                fetch('/wishlist/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        btn.disabled = false;

                        if (data.success) {
                            if (data.added) {
                                if (icon) icon.className = 'fa-solid fa-heart';
                                btn.classList.add('active', 'text-danger');
                            } else {
                                if (icon) icon.className = 'fa-regular fa-heart';
                                btn.classList.remove('active', 'text-danger');
                            }
                            const wishlistBadge = document.querySelector('.wishlist-count');
                            if (wishlistBadge) {
                                const count = Number(data.wishlistCount ?? 0);
                                wishlistBadge.textContent = count;
                                wishlistBadge.style.display = count > 0 ? 'inline-flex' : 'none';
                            }
                            showToast('success', data.message);
                            btn.dataset.hasInWishlist = 'true';
                            icon.className = 'fa-solid fa-heart text-danger';
                            btn.classList.add('active', 'text-danger');
                        } else {
                            if (icon) icon.className = originalClass;
                            showToast('error', data.message || 'Failed to update wishlist');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        btn.disabled = false;
                        if (icon) icon.className = originalClass;
                        showToast('error', 'Something went wrong. Please try again.');
                    });
            }

        });
    </script>

    <script>
        (function() {
            function proceed(target) {
                if (target.tagName === 'A' && target.href) {
                    window.location.href = target.href;
                    return;
                }
                var form = target.closest('form');
                if (form) {
                    form.submit();
                    return;
                }
                target.click();
            }
            document.addEventListener('click', function(e) {
                var el = e.target.closest('[data-confirm]');
                if (!el) return;
                e.preventDefault();
                var msg = el.getAttribute('data-confirm') || 'Are you sure?';
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: msg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then(function(result) {
                        if (result.isConfirmed) proceed(el);
                    });
                } else {
                    if (window.confirm(msg)) proceed(el);
                }
            });
            document.addEventListener('submit', function(e) {
                var form = e.target;
                var msg = form.getAttribute('data-confirm');
                if (!msg) return;
                e.preventDefault();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: msg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then(function(result) {
                        if (result.isConfirmed) form.submit();
                    });
                } else {
                    if (window.confirm(msg)) form.submit();
                }
            });
        })();
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('success'))
                showToast('success', "{{ Session::get('success') }}");
            @endif
            @if (Session::has('error'))
                showToast('error', "{{ Session::get('error') }}");
            @endif
            @if (Session::has('info'))
                showToast('success', "{{ Session::get('info') }}");
            @endif
            @if (Session::has('warning'))
                showToast('error', "{{ Session::get('warning') }}");
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showToast('error', "{{ $error }}");
                @endforeach
            @endif
        });
    </script>

    @stack('scripts')
</body>

</html>
