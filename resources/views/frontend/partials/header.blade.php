<!-- Header Start -->
<header class="header-area"
    style="background: #fff; box-shadow: 0 2px 20px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 1000;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <nav class="navbar-main d-flex align-items-center justify-content-between" style="padding: 15px 0;">

                    <!-- Logo -->
                    <div class="logo-area">
                        <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                            <div class="logo-icon me-2"
                                style="width: 45px; height: 45px; background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-cart-shopping text-white" style="font-size: 20px;"></i>
                            </div>
                            <div class="logo-text">
                                <h4 class="mb-0" style="font-weight: 700; color: #1a1a2e; font-size: 22px;">Grow<span
                                        style="color: #0496ff;">Up</span></h4>
                                <small style="font-size: 10px; color: #888; letter-spacing: 1px;">E-COMMERCE</small>
                            </div>
                        </a>
                    </div>

                    <!-- Search Bar (Desktop) -->
                    <div class="search-area d-none d-lg-block" style="flex: 1; max-width: 500px; margin: 0 40px;">
                        <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                            <div class="input-group"
                                style="border: 2px solid #e9ecef; border-radius: 50px; overflow: hidden;">
                                <input type="text" name="search" class="form-control border-0"
                                    placeholder="Search for products..." style="padding: 12px 20px; font-size: 14px;"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn"
                                    style="background: #0496ff; color: #fff; padding: 0 25px; border-radius: 0 50px 50px 0 !important;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Navigation Menu (Desktop) -->
                    <nav class="main-nav d-none d-xl-block">
                        <ul class="nav-list d-flex align-items-center gap-4 mb-0 list-unstyled">
                            <li class="nav-item">
                                <a href="{{ route('home') }}"
                                    class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                    style="font-weight: 500; color: {{ request()->routeIs('home') ? '#0496ff' : '#333' }}; text-decoration: none; font-size: 15px; transition: all 0.3s;">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item position-relative dropdown-nav">
                                <a href="{{ route('shop.index') }}"
                                    class="nav-link d-flex align-items-center {{ request()->routeIs('shop.*') ? 'active' : '' }}"
                                    style="font-weight: 500; color: {{ request()->routeIs('shop.*') ? '#0496ff' : '#333' }}; text-decoration: none; font-size: 15px; transition: all 0.3s;">
                                    Shop <i class="fa-solid fa-chevron-down ms-1" style="font-size: 10px;"></i>
                                </a>
                                <!-- Dropdown Menu -->
                                <ul class="dropdown-menu-custom"
                                    style="position: absolute; top: 100%; left: 0; background: #fff; min-width: 220px; padding: 15px 0; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); opacity: 0; visibility: hidden; transform: translateY(10px); transition: all 0.3s; list-style: none; margin-top: 15px;">
                                    @php
                                        try {
                                            $navCategories = \App\Models\Admin\Product\ProductCategory::whereNull('parent_id')->where('show_on_menu', true)->orderBy('order')->limit(8)->get();
                                        } catch (\Exception $e) {
                                            $navCategories = collect();
                                        }
                                    @endphp
                                    @foreach($navCategories as $category)
                                        <li>
                                            <a href="{{ route('shop.index', ['category' => $category->name]) }}"
                                                class="dropdown-item-custom d-flex align-items-center"
                                                style="padding: 10px 25px; color: #666; text-decoration: none; font-size: 14px; transition: all 0.3s;">
                                                <i class="fa-solid fa-angle-right me-2"
                                                    style="color: #0496ff; font-size: 12px;"></i>
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                    <li style="border-top: 1px solid #eee; margin-top: 10px; padding-top: 10px;">
                                        <a href="{{ route('shop.index') }}"
                                            class="dropdown-item-custom d-flex align-items-center"
                                            style="padding: 10px 25px; color: #0496ff; text-decoration: none; font-size: 14px; font-weight: 600;">
                                            <i class="fa-solid fa-th-large me-2"></i>
                                            View All Categories
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('frontend.about') }}"
                                    class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}"
                                    style="font-weight: 500; color: {{ request()->routeIs('frontend.about') ? '#0496ff' : '#333' }}; text-decoration: none; font-size: 15px; transition: all 0.3s;">
                                    About
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('blog.index') }}"
                                    class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}"
                                    style="font-weight: 500; color: {{ request()->routeIs('blog.*') ? '#0496ff' : '#333' }}; text-decoration: none; font-size: 15px; transition: all 0.3s;">
                                    Blog
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('frontend.contact') }}"
                                    class="nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}"
                                    style="font-weight: 500; color: {{ request()->routeIs('frontend.contact') ? '#0496ff' : '#333' }}; text-decoration: none; font-size: 15px; transition: all 0.3s;">
                                    Contact
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Right Icons -->
                    <div class="header-icons d-flex align-items-center gap-3">
                        <!-- Search Icon (Mobile) -->
                        <button class="icon-btn d-lg-none open-search"
                            style="width: 42px; height: 42px; border: none; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #333; font-size: 16px; transition: all 0.3s; cursor: pointer;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>

                        <!-- Wishlist Icon -->
                        @php
                            $wishlistCount = count(session()->get('wishlist', []));
                            $cartCount = 0;
                            $cart = session()->get('cart', []);
                            foreach ($cart as $item) {
                                $cartCount += $item['qty'] ?? 1;
                            }
                        @endphp
                        <a href="{{ route('wishlist.index') }}" class="icon-btn position-relative"
                            style="width: 42px; height: 42px; border: none; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #333; font-size: 16px; text-decoration: none; transition: all 0.3s;"
                            title="My Wishlist">
                            <i class="fa-regular fa-heart"></i>
                            <span class="badge-count wishlist-count"
                                style="position: absolute; top: -5px; right: -5px; width: 20px; height: 20px; background: #dc3545; color: #fff; border-radius: 50%; font-size: 10px; display: flex; align-items: center; justify-content: center; font-weight: 600;">{{ $wishlistCount }}</span>
                        </a>

                        <!-- Cart Icon -->
                        <button class="icon-btn position-relative open-cart"
                            style="width: 42px; height: 42px; border: none; background: #0496ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; cursor: pointer; transition: all 0.3s;"
                            title="Shopping Cart">
                            <i class="fa-solid fa-shopping-bag"></i>
                            <span class="badge-count cart-count"
                                style="position: absolute; top: -5px; right: -5px; width: 20px; height: 20px; background: #dc3545; color: #fff; border-radius: 50%; font-size: 10px; display: flex; align-items: center; justify-content: center; font-weight: 600;">{{ $cartCount }}</span>
                        </button>


                        <!-- Mobile Menu Toggle -->
                        <button class="mobile-menu-toggle d-xl-none"
                            style="width: 42px; height: 42px; border: none; background: #1a1a2e; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px; cursor: pointer; transition: all 0.3s;">
                            <span
                                style="width: 20px; height: 2px; background: #fff; border-radius: 2px; transition: all 0.3s;"></span>
                            <span
                                style="width: 20px; height: 2px; background: #fff; border-radius: 2px; transition: all 0.3s;"></span>
                            <span
                                style="width: 14px; height: 2px; background: #fff; border-radius: 2px; transition: all 0.3s; align-self: flex-start; margin-left: 11px;"></span>
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->

<!-- Mobile Menu Sidebar -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1001; opacity: 0; visibility: hidden; transition: all 0.3s;"></div>
<div class="mobile-menu-sidebar" id="mobileMenuSidebar" style="position: fixed; top: 0; left: -300px; width: 300px; height: 100%; background: #fff; z-index: 1002; transition: all 0.3s; overflow-y: auto; box-shadow: 2px 0 10px rgba(0,0,0,0.1);">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
        <h5 class="m-0 fw-bold">Menu</h5>
        <button class="btn-close" id="closeMobileMenu"></button>
    </div>
    <div class="p-3">
        <!-- Mobile Search -->
        <form action="{{ route('shop.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>

        <!-- Mobile Nav Links -->
        <ul class="list-unstyled d-flex flex-column gap-3">
            <li>
                <a href="{{ route('home') }}" class="text-dark text-decoration-none fw-medium d-block py-2 {{ request()->routeIs('home') ? 'text-primary' : '' }}">Home</a>
            </li>
            <li>
                <div class="d-flex align-items-center justify-content-between cursor-pointer" data-bs-toggle="collapse" data-bs-target="#mobileShopDropdown">
                    <a href="{{ route('shop.index') }}" class="text-dark text-decoration-none fw-medium py-2 {{ request()->routeIs('shop.*') ? 'text-primary' : '' }}">Shop</a>
                    <i class="fa-solid fa-chevron-down text-muted fs-12"></i>
                </div>
                <div class="collapse ps-3 mt-2" id="mobileShopDropdown">
                    <ul class="list-unstyled d-flex flex-column gap-2 border-start ps-3 border-2">
                        @php
                            try {
                                $navCategories = \App\Models\Admin\Product\ProductCategory::whereNull('parent_id')->where('show_on_menu', true)->orderBy('order')->limit(8)->get();
                            } catch (\Exception $e) {
                                $navCategories = collect();
                            }
                        @endphp
                        @foreach($navCategories as $category)
                            <li>
                                <a href="{{ route('shop.index', ['category' => $category->name]) }}" class="text-secondary text-decoration-none fs-14 d-block py-1">{{ $category->name }}</a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ route('shop.index') }}" class="text-primary text-decoration-none fs-14 d-block py-1 fw-medium">View All Categories</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ route('frontend.about') }}" class="text-dark text-decoration-none fw-medium d-block py-2 {{ request()->routeIs('frontend.about') ? 'text-primary' : '' }}">About</a>
            </li>
            <li>
                <a href="{{ route('blog.index') }}" class="text-dark text-decoration-none fw-medium d-block py-2 {{ request()->routeIs('blog.*') ? 'text-primary' : '' }}">Blog</a>
            </li>
            <li>
                <a href="{{ route('frontend.contact') }}" class="text-dark text-decoration-none fw-medium d-block py-2 {{ request()->routeIs('frontend.contact') ? 'text-primary' : '' }}">Contact</a>
            </li>
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        const mobileMenuSidebar = document.getElementById('mobileMenuSidebar');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        
        function openMenu() {
            mobileMenuOverlay.style.opacity = '1';
            mobileMenuOverlay.style.visibility = 'visible';
            mobileMenuSidebar.style.left = '0';
        }
        
        function closeMenu() {
            mobileMenuOverlay.style.opacity = '0';
            mobileMenuOverlay.style.visibility = 'hidden';
            mobileMenuSidebar.style.left = '-300px';
        }
        
        if(mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                openMenu();
            });
        }
        
        if(closeMobileMenu) {
            closeMobileMenu.addEventListener('click', closeMenu);
        }
        
        if(mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', closeMenu);
        }
    });
</script>

<style>
    /* Navigation Hover Effects */
    .nav-link:hover {
        color: #0496ff !important;
    }

    /* Dropdown Show on Hover */
    .dropdown-nav:hover .dropdown-menu-custom {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item-custom:hover {
        background: #f8f9fa;
        color: #0496ff !important;
        padding-left: 30px !important;
    }

    /* User Dropdown */
    .user-dropdown:hover .user-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .user-dropdown-menu li a:hover,
    .user-dropdown-menu li button:hover {
        background: #f8f9fa;
    }

    /* Icon Button Hover */
    .icon-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Search Form Focus */
    .search-form .input-group:focus-within {
        border-color: #0496ff !important;
        box-shadow: 0 0 0 4px rgba(4, 150, 255, 0.1);
    }

    /* Mobile Menu Toggle Animation */
    .mobile-menu-toggle:hover {
        background: #0496ff;
    }

    .mobile-menu-toggle:hover span:last-child {
        width: 20px;
        margin-left: 0;
        align-self: center;
    }
</style>