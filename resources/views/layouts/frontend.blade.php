<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'E-Commerce'))</title>
    <meta name="description" content="@yield('description', 'Best Online Shopping Experience')">

    <!-- Favicon -->
    <link rel="shortcut icon"
        href="{{ $business_setup && $business_setup->favicon ? asset('storage/' . $business_setup->favicon) : asset('frontend/assets/images/logo.png') }}"
        type="image/x-icon">
    <link rel="icon"
        href="{{ $business_setup && $business_setup->favicon ? asset('storage/' . $business_setup->favicon) : asset('frontend/assets/images/logo.png') }}"
        type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap"
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
    <link rel="stylesheet" href="{{ asset('frontend/css/slick-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owlcarousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/qbit-bms-style.css') }}">

    <style>
        :root {
            --primary-color: #0496ff;
            --secondary-color: #1a1a2e;
            --accent-color: #f9c123;
            --success-color: #0ab969;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --dark-bg: #1a1a2e;
        }

        /* Toast Notification Styles */
        .toast-notification {
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 15px 25px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
            z-index: 99999;
            transform: translateX(120%);
            transition: transform 0.3s ease;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .toast-notification.show {
            transform: translateX(0);
        }

        .toast-success {
            border-left: 4px solid #28a745;
        }

        .toast-success i {
            color: #28a745;
        }

        .toast-error {
            border-left: 4px solid #dc3545;
        }

        .toast-error i {
            color: #dc3545;
        }

        .add-to-wishlist.active,
        .add-to-wishlist.text-danger {
            color: #dc3545 !important;
        }

        .add-to-wishlist.active i,
        .add-to-wishlist.text-danger i {
            color: #dc3545 !important;
        }

        /* Cart Count Badge */
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            font-size: 10px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--danger-color);
            color: #fff;
            border-radius: 50%;
        }

        /* Product Card Styles */
        .property-single-boxarea {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .property-single-boxarea:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .property-list-img-area {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            background: #f8f9fa;
        }

        .property-list-img-area a {
            display: block;
            width: 100%;
            height: 100%;
        }

        .property-list-img-area .img1 {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .property-list-img-area img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            transition: transform 0.5s ease;
            display: block !important;
        }

        .property-single-boxarea:hover .property-list-img-area img {
            transform: scale(1.08);
        }

        .property-single-content {
            padding: 20px;
        }

        .property-single-content h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .property-single-content h4 a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }

        .property-single-content h4 a:hover {
            color: var(--primary-color);
        }

        .property-single-content p {
            color: #888;
            font-size: 13px;
            margin: 0;
        }

        .property-details {
            padding: 0 20px 15px;
            border-top: 1px solid #eee;
        }

        .property-details ul {
            list-style: none;
            padding: 15px 0 0;
            margin: 0;
        }

        .property-details ul li {
            font-size: 14px;
            color: #666;
            line-height: 24px;
        }

        .btn-area1 {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            gap: 10px;
        }

        .action-btn-success {
            background: linear-gradient(135deg, #0ab969 0%, #089d56 100%);
            color: #fff !important;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 13px;
            font-weight: 500;
        }

        .action-btn-success:hover {
            background: linear-gradient(135deg, #089d56 0%, #078048 100%);
            color: #fff;
            transform: translateY(-2px);
        }

        .action-btn-danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color) !important;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }

        .action-btn-danger:hover {
            background: var(--danger-color);
            color: #fff !important;
        }

        .h-30px {
            height: 30px;
        }

        .w-30px {
            width: 30px;
        }

        .fs-15 {
            font-size: 15px;
        }

        .fs-20 {
            font-size: 20px;
        }

        /* Badge styles */
        .property-list-img-area .badge {
            font-size: 11px;
            padding: 5px 10px;
            font-weight: 600;
        }

        /* Section spacing */
        section {
            padding: 60px 0;
        }

        /* Title animation styles */
        .title-animation {
            font-size: 36px;
            font-weight: 700;
            color: #333;
            line-height: 1.3;
        }

        .title-animation span {
            color: var(--primary-color);
        }

        .sub-title-main {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        /* Button styles */
        .btn--primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0380d9 100%);
            color: #fff !important;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn--primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(4, 150, 255, 0.3);
            color: #fff;
        }

        /* Shop sidebar styles */
        .shop-sidebar-widget {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }

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

        .sidebar-list ul li a:hover,
        .sidebar-list ul li.active a {
            color: var(--primary-color);
            padding-left: 5px;
        }

        .tag-wrapper a {
            display: inline-block;
            padding: 6px 15px;
            background: #f5f5f5;
            border-radius: 20px;
            margin: 5px;
            font-size: 13px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
        }

        .tag-wrapper a:hover,
        .tag-wrapper a.active {
            background: var(--primary-color);
            color: #fff;
        }

        /* Text & Typography Styles */
        a {
            text-decoration: none !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            color: #333;
            line-height: 1.3;
        }

        p {
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
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
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar__list li a:hover {
            color: var(--primary-color);
        }

        /* Footer text styles */
        .footer-two__widget p,
        .footer-two__widget a {
            color: rgba(255, 255, 255, 0.7);
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
            text-transform: uppercase;
            letter-spacing: 2px;
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

<body>
    <div class="page-wrapper">

        <!-- ========== TOPBAR ========== -->
        <div class="topbar topbar-six-area d-none d-lg-block overflow-visible z-2">
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
                                        <a class="fw-normal" href="tel:+8801700000000">
                                            <i class="fa-solid fa-phone"></i> Sales: +880 1700-000000
                                        </a>
                                    </li>
                                    <li>
                                        <a class="fw-normal" href="tel:+8801800000000">
                                            <i class="fa-solid fa-headset"></i> Hotline: +880 1800-000000
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
        </div>

        <!-- ========== HEADER ========== -->
        <header class="header header-tertiary header-six-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="main-header__menu-box">
                            <nav class="navbar p-0">
                                <!-- Brand -->
                                <div class="navbar-logo">
                                    <a href="{{ route('home') }}" aria-label="Home">
                                        <img src="{{ $business_setup && $business_setup->logo ? asset('storage/' . $business_setup->logo) : asset('frontend/assets/images/logo.png') }}"
                                            alt="{{ config('app.name') }}" height="50">
                                    </a>
                                </div>
                                <!-- Nav -->
                                <div class="navbar__options">
                                    <div class="header-six-navbar-space d-flex justify-content-end">
                                        <nav class="navbar__menu d-none d-xl-block" aria-label="Primary">
                                            <ul class="navbar__list">
                                                <li class="navbar__item nav-fade">
                                                    <a href="{{ route('home') }}"
                                                        class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                                                </li>
                                                <li class="navbar__item nav-fade">
                                                    <a href="{{ route('shop.index') }}"
                                                        class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop</a>
                                                </li>
                                                <li class="navbar__item navbar__item--has-children nav-fade">
                                                    <a href="#">Categories</a>
                                                    <ul class="navbar__sub-menu">
                                                        @php
                                                            $categories = \App\Models\Admin\Product\ProductCategory::take(8)->get();
                                                        @endphp
                                                        @foreach($categories as $cat)
                                                            <li><a
                                                                    href="{{ route('shop.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                <li class="navbar__item nav-fade">
                                                    <a href="{{ route('frontend.about') }}">About Us</a>
                                                </li>
                                                <li class="navbar__item nav-fade">
                                                    <a href="{{ route('frontend.contact') }}">Contact Us</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="open-search" aria-label="Open search">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <!-- Cart & Wishlist -->
                                    <div class="contact-btn d-flex align-items-center gap-3">
                                        <a href="{{ route('wishlist.index') }}" class="position-relative text-dark"
                                            title="Wishlist" style="text-decoration: none;">
                                            <i class='bx bx-heart fs-4'></i>
                                            @php $wishlistCount = count(session('wishlist', [])); @endphp
                                            @if($wishlistCount > 0)
                                                <span class="cart-count">{{ $wishlistCount }}</span>
                                            @endif
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
        </header>

        <!-- ========== MOBILE MENU ========== -->
        <div class="mobile-menu d-block d-xxl-none">
            <nav class="mobile-menu__wrapper" aria-label="Mobile">
                <div class="mobile-menu__header nav-fade">
                    <div class="logo">
                        <a href="{{ route('home') }}">
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
                    <a href="#" target="_blank" title="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" target="_blank" title="twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" target="_blank" title="instagram"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </nav>
        </div>
        <div class="mobile-menu__backdrop"></div>

        <!-- ========== SEARCH POPUP ========== -->
        <div class="search-popup" role="dialog" aria-modal="true" aria-label="Search">
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
        </div>

        <!-- ========== SIDEBAR CART ========== -->
        @include('frontend.partials.sidebar-cart')

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- ========== FOOTER ========== -->
        <footer class="footer-two footer-six-area footer-eight-area"
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
                                    <a class="apece-link-line" href="tel:+8801700000000">+880 1700-000000</a>
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
                                    <a class="apece-link-line" href="tel:+8801800000000">+880 1800-000000</a>
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
                                    Your one-stop destination for quality products at affordable prices. Shop with
                                    confidence and enjoy fast delivery.
                                </p>
                                <div class="social">
                                    <a href="#" target="_blank" aria-label="facebook"><i
                                            class="fa-brands fa-facebook-f"></i></a>
                                    <a href="#" target="_blank" aria-label="instagram"><i
                                            class="fa-brands fa-instagram"></i></a>
                                    <a href="#" target="_blank" aria-label="twitter"><i
                                            class="fa-brands fa-twitter"></i></a>
                                    <a href="#" target="_blank" aria-label="youtube"><i
                                            class="fa-brands fa-youtube"></i></a>
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
                                    <li><a class="text-white sub-title-lg" href="{{ route('home') }}"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> Home</a></li>
                                    <li><a class="text-white sub-title-lg" href="{{ route('shop.index') }}"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> Shop</a></li>
                                    <li><a class="text-white sub-title-lg" href="{{ route('frontend.about') }}"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> About Us</a></li>
                                    <li><a class="text-white sub-title-lg"
                                            href="{{ route('frontend.contact') }}"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> Contact Us</a></li>
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
                                            <i class="fa-solid fa-location-dot"></i> Dhaka, Bangladesh
                                        </a>
                                    </li>
                                    <li><a class="text-white sub-title-lg" href="tel:+8801700000000"><i
                                                class="fa-solid fa-phone"></i> +880 1700-000000</a></li>
                                    <li><a class="text-white sub-title-lg" href="mailto:info@shop.com"><i
                                                class="fa-solid fa-envelope"></i> info@shop.com</a></li>
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
                                <p>Copyright &copy; <span id="copyrightYear">{{ date('Y') }}</span> <a
                                        href="{{ route('home') }}">{{ config('app.name') }}</a>. All rights reserved.
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="footer__bottom-left">
                                <ul class="footer__bottom-list justify-content-center justify-content-lg-end">
                                    <li><a href="#">Terms & Conditions</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <!-- ==== custom cursor ==== -->
    <div class="mouseCursor cursor-outer"></div>
    <div class="mouseCursor cursor-inner"></div>

    <!-- ==== scroll to top ==== -->
    <button class="progress-wrap" aria-label="scroll indicator" title="back to top">
        <span></span>
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </button>

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
    <script src="{{ asset('frontend/js/owlcarousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick-slider.js') }}"></script>
    <script src="{{ asset('frontend/js/swiper-slider.js') }}"></script>

    <!-- Polyfill for missing plugins and elements -->
    <script>
        // MetisMenu polyfill - prevents error if plugin not loaded
        if (typeof jQuery !== 'undefined' && !jQuery.fn.metisMenu) {
            jQuery.fn.metisMenu = function () { return this; };
        }

        // Create dummy elements for countdown to prevent errors
        (function () {
            var countdownIds = ['days', 'hours', 'minutes', 'seconds', 'headline', 'countdown', 'content'];
            countdownIds.forEach(function (id) {
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
    <script src="{{ asset('frontend/js/custom.js') }}"></script>

    <script>
        // Toast Notification Function
        function showToast(type, message) {
            document.querySelectorAll('.toast-notification').forEach(t => t.remove());

            const toast = document.createElement('div');
            toast.className = `toast-notification toast-${type}`;
            toast.innerHTML = `
                <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <span>${message}</span>
            `;
            document.body.appendChild(toast);

            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Add to Cart AJAX
        document.addEventListener('click', function (e) {
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
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;

                    if (data.success) {
                        // Update cart count in header
                        document.querySelectorAll('.cart-count').forEach(el => {
                            el.textContent = data.cartCount;
                        });
                        showToast('success', data.message || 'Product added to cart!');

                        // Open cart sidebar after a brief delay
                        setTimeout(function () {
                            if (typeof openSidebarCart === 'function') {
                                openSidebarCart();
                            }
                        }, 300);
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
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.add-to-wishlist');
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();

            const productId = btn.dataset.productId || btn.dataset.id;
            if (!productId) return;

            btn.disabled = true;
            const icon = btn.querySelector('i');
            const originalClass = icon ? icon.className : '';
            if (icon) icon.className = 'fa-solid fa-spinner fa-spin';

            fetch('/wishlist/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
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
        });

    </script>

    @stack('scripts')
</body>

</html>