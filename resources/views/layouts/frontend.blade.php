<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GrowUp E-Commerce')</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    
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
        
        body {
            font-family: 'Outfit', sans-serif;
            color: #333;
        }
        
        .btn--primary {
            background: var(--primary-color);
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn--primary:hover {
            background: #0380d9;
            color: #fff;
            transform: translateY(-2px);
        }
        
        .apece-primary-button {
            background: var(--primary-color);
            color: #fff;
            border: none;
            padding: 14px 35px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .apece-primary-button:hover {
            background: #0380d9;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(4, 150, 255, 0.3);
        }
        
        .sub-title-main {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: inline-block;
            margin-bottom: 10px;
        }
        
        .sub-title-main i {
            margin-right: 8px;
        }
        
        .title-animation {
            font-size: 42px;
            font-weight: 700;
            color: var(--secondary-color);
            line-height: 1.2;
        }
        
        .title-animation span {
            color: var(--primary-color);
        }
        
        /* Topbar Styles */
        .topbar {
            background: var(--secondary-color);
            padding: 10px 0;
        }
        
        .topbar__list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 30px;
        }
        
        .topbar__list li a {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .topbar__list li a:hover {
            color: #fff;
        }
        
        .topbar-six-right ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .topbar-six-right ul li a,
        .topbar-six-right ul li button {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
            text-decoration: none;
        }
        
        /* Header Styles */
        .header {
            background: #fff;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        .navbar__list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 35px;
        }
        
        .navbar__item a {
            color: var(--secondary-color);
            font-weight: 500;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s;
        }
        
        .navbar__item a:hover,
        .navbar__item a.active {
            color: var(--primary-color);
        }
        
        .navbar__item--has-children {
            position: relative;
        }
        
        .navbar__sub-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff;
            min-width: 220px;
            padding: 15px 0;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            list-style: none;
        }
        
        .navbar__item--has-children:hover .navbar__sub-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .navbar__sub-menu li a {
            display: block;
            padding: 10px 25px;
            color: #666;
            font-size: 15px;
        }
        
        .navbar__sub-menu li a:hover {
            background: var(--light-bg);
            color: var(--primary-color);
        }
        
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
        }
        
        /* Banner Styles */
        .banner-two {
            position: relative;
            overflow: hidden;
        }
        
        .banner-two__slider-single {
            height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .banner-two__slider-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }
        
        .banner-two__slider-single .container {
            position: relative;
            z-index: 2;
        }
        
        /* Common Banner */
        .common-banner {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0380d9 100%);
            padding: 80px 0;
            text-align: center;
        }
        
        .common-banner__content .sub-title {
            color: rgba(255,255,255,0.9);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .common-banner__content h2 {
            color: #fff;
            font-size: 48px;
            font-weight: 700;
            margin-top: 15px;
        }
        
        .common-banner .breadcrumb {
            margin-top: 20px;
        }
        
        .common-banner .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
        }
        
        .common-banner .breadcrumb-item.active {
            color: #fff;
        }
        
        /* Feature Section */
        .feature-six-wrapper {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }
        
        .feature-six-wrapper:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        }
        
        .feature-six-icon span {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(4, 150, 255, 0.1);
            border-radius: 50%;
            color: var(--primary-color);
            font-size: 28px;
        }
        
        .feature-six-content h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .feature-six-content p {
            color: #666;
            margin: 0;
            font-size: 14px;
        }
        
        /* Product Card */
        .property-single-boxarea {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }
        
        .property-single-boxarea:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .property-list-img-area {
            position: relative;
            overflow: hidden;
        }
        
        .property-list-img-area img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .property-single-boxarea:hover .property-list-img-area img {
            transform: scale(1.08);
        }
        
        .property-single-content {
            padding: 20px;
        }
        
        .property-single-content h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .property-single-content h4 a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .property-single-content h4 a:hover {
            color: var(--primary-color);
        }
        
        .property-single-content p {
            color: #888;
            font-size: 14px;
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
        }
        
        .btn-area1 {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            gap: 10px;
        }
        
        .action-btn-success {
            background: var(--success-color);
            color: #fff;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .action-btn-success:hover {
            background: #099654;
            color: #fff;
        }
        
        .action-btn-danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .action-btn-danger:hover {
            background: var(--danger-color);
            color: #fff;
        }
        
        /* Shop Sidebar */
        .shop__sidebar {
            position: sticky;
            top: 100px;
        }
        
        .shop-sidebar-widget {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
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
        }
        
        .sidebar-list ul li a:hover,
        .sidebar-list ul li.active a {
            color: var(--primary-color);
            padding-left: 5px;
        }
        
        /* Footer Styles */
        .footer-area {
            background: var(--secondary-color);
            padding: 80px 0 30px;
            color: #fff;
        }
        
        .footer-widget {
            margin-bottom: 40px;
        }
        
        .footer-widget h5 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .footer-widget h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links li a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .footer-links li a:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }
        
        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-contact li {
            color: rgba(255,255,255,0.7);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .footer-contact li i {
            color: var(--primary-color);
        }
        
        .footer-area .social a {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: #fff;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .footer-area .social a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 25px;
            margin-top: 30px;
            text-align: center;
        }
        
        .footer-bottom p {
            color: rgba(255,255,255,0.6);
            margin: 0;
        }
        
        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: -100%;
            width: 300px;
            height: 100vh;
            background: #fff;
            z-index: 9999;
            transition: left 0.3s ease;
            overflow-y: auto;
        }
        
        .mobile-menu.active {
            left: 0;
        }
        
        .mobile-menu__backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        
        .mobile-menu__backdrop.active {
            opacity: 1;
            visibility: visible;
        }
        
        .mobile-menu__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .close-mobile-menu {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }
        
        /* Search Popup */
        .search-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.95);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        
        .search-popup.active {
            opacity: 1;
            visibility: visible;
        }
        
        .search-popup .close-search {
            position: absolute;
            top: 30px;
            right: 30px;
            background: none;
            border: none;
            color: #fff;
            font-size: 30px;
            cursor: pointer;
        }
        
        .search-popup__group {
            display: flex;
            max-width: 600px;
            width: 90%;
        }
        
        .search-popup__group input {
            flex: 1;
            padding: 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px 0 0 5px;
        }
        
        .search-popup__group button {
            padding: 20px 30px;
            background: var(--primary-color);
            border: none;
            color: #fff;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }
        
        /* Sidebar Cart */
        .sidebar-cart {
            position: fixed;
            top: 0;
            right: -400px;
            width: 380px;
            height: 100vh;
            background: #fff;
            z-index: 9999;
            transition: right 0.3s ease;
            box-shadow: -5px 0 30px rgba(0,0,0,0.1);
        }
        
        .sidebar-cart.active {
            right: 0;
        }
        
        .cart-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        
        .cart-backdrop.active {
            opacity: 1;
            visibility: visible;
        }
        
        .sidebar-cart .der {
            padding: 25px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-cart .close-cart {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }
        
        .sidebar-cart h2 {
            font-size: 22px;
            margin-bottom: 25px;
        }
        
        .sidebar-cart .cart-items {
            flex: 1;
            overflow-y: auto;
        }
        
        .sidebar-cart .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .sidebar-cart .action-buttons a {
            flex: 1;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
        }
        
        .sidebar-cart .view-cart-button {
            background: #f5f5f5;
            color: var(--secondary-color);
        }
        
        .sidebar-cart .checkout-button {
            background: var(--primary-color);
            color: #fff;
        }
        
        /* Utility Classes */
        .h-30px { height: 30px; }
        .h-40px { height: 40px; }
        .w-30px { width: 30px; }
        .w-40px { width: 40px; }
        .fs-15 { font-size: 15px; }
        .fs-20 { font-size: 20px; }
        
        /* Responsive */
        @media (max-width: 991px) {
            .title-animation {
                font-size: 32px;
            }
            
            .banner-two__slider-single {
                height: 450px;
            }
            
            .common-banner__content h2 {
                font-size: 36px;
            }
        }
        
        @media (max-width: 767px) {
            .title-animation {
                font-size: 28px;
            }
            
            .banner-two__slider-single {
                height: 350px;
            }
            
            .common-banner {
                padding: 50px 0;
            }
            
            .common-banner__content h2 {
                font-size: 28px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="page-wrapper">
        
        <!-- Topbar -->
        @include('frontend.partials.topbar')
        
        <!-- Header -->
        @include('frontend.partials.header')
        
        <!-- Mobile Menu -->
        @include('frontend.partials.mobile-menu')
        
        <!-- Search Popup -->
        @include('frontend.partials.search-popup')
        
        <!-- Sidebar Cart -->
        @include('frontend.partials.sidebar-cart')
        
        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
        
        <!-- Footer -->
        @include('frontend.partials.footer')
        
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });
        
        // Mobile Menu Toggle
        document.querySelector('.open-offcanvas-nav')?.addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.add('active');
            document.querySelector('.mobile-menu__backdrop').classList.add('active');
        });
        
        document.querySelector('.close-mobile-menu')?.addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.remove('active');
            document.querySelector('.mobile-menu__backdrop').classList.remove('active');
        });
        
        document.querySelector('.mobile-menu__backdrop')?.addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.remove('active');
            this.classList.remove('active');
        });
        
        // Search Popup Toggle
        document.querySelector('.open-search')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.search-popup').classList.add('active');
        });
        
        document.querySelector('.close-search')?.addEventListener('click', function() {
            document.querySelector('.search-popup').classList.remove('active');
        });
        
        // Sidebar Cart Toggle
        document.querySelector('.open-cart')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.sidebar-cart').classList.add('active');
            document.querySelector('.cart-backdrop').classList.add('active');
        });
        
        document.querySelector('.close-cart')?.addEventListener('click', function() {
            document.querySelector('.sidebar-cart').classList.remove('active');
            document.querySelector('.cart-backdrop').classList.remove('active');
        });
        
        document.querySelector('.cart-backdrop')?.addEventListener('click', function() {
            document.querySelector('.sidebar-cart').classList.remove('active');
            this.classList.remove('active');
        });
        
        // Toast Notification Function
        function showToast(type, message) {
            // Remove existing toasts
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
        
        // Add to Cart AJAX (using event delegation for dynamic elements)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.add-to-cart');
            if (!btn) return;
            
            e.preventDefault();
            e.stopPropagation();
            
            const productId = btn.dataset.productId;
            if (!productId) return;
            
            // Disable button temporarily
            btn.disabled = true;
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
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
        
        // Add to Wishlist AJAX (using event delegation for dynamic elements)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.add-to-wishlist');
            if (!btn) return;
            
            e.preventDefault();
            e.stopPropagation();
            
            const productId = btn.dataset.productId;
            if (!productId) return;
            
            // Disable button temporarily
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
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                
                if (data.success) {
                    if (data.added) {
                        // Added to wishlist - fill heart
                        if (icon) icon.className = 'fa-solid fa-heart';
                        btn.classList.add('active', 'text-danger');
                    } else {
                        // Removed from wishlist - empty heart
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
    
    <!-- Toast Notification Styles -->
    <style>
        .toast-notification {
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 15px 25px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
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
    </style>
    
    @stack('scripts')
</body>
</html>

