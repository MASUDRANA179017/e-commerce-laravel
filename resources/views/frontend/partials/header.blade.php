<!-- Header Start -->
<header class="header-area" style="background: #fff; box-shadow: 0 2px 20px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 1000;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <nav class="navbar-main d-flex align-items-center justify-content-between" style="padding: 15px 0;">
                    
                    <!-- Logo -->
                    <div class="logo-area">
                        <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                            <div class="logo-icon me-2" style="width: 45px; height: 45px; background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-cart-shopping text-white" style="font-size: 20px;"></i>
                            </div>
                            <div class="logo-text">
                                <h4 class="mb-0" style="font-weight: 700; color: #1a1a2e; font-size: 22px;">Grow<span style="color: #0496ff;">Up</span></h4>
                                <small style="font-size: 10px; color: #888; letter-spacing: 1px;">E-COMMERCE</small>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Search Bar (Desktop) -->
                    <div class="search-area d-none d-lg-block" style="flex: 1; max-width: 500px; margin: 0 40px;">
                        <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                            <div class="input-group" style="border: 2px solid #e9ecef; border-radius: 50px; overflow: hidden;">
                                <input type="text" name="search" class="form-control border-0" placeholder="Search for products..." style="padding: 12px 20px; font-size: 14px;" value="{{ request('search') }}">
                                <button type="submit" class="btn" style="background: #0496ff; color: #fff; padding: 0 25px; border-radius: 0 50px 50px 0 !important;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Navigation Menu (Desktop) -->
                    <nav class="main-nav d-none d-xl-block">
                        <ul class="nav-list d-flex align-items-center gap-4 mb-0 list-unstyled">
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" style="font-weight: 500; color: {{ request()->routeIs('home') ? '#0496ff' : '#333' }}; text-decoration: none; font-size: 15px; transition: all 0.3s;">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item position-relative dropdown-nav">
                                <a href="{{ route('shop.index') }}" class="nav-link d-flex align-items-center {{ request()->routeIs('shop.*') ? 'active' : '' }}" style="font-weight: 500; color: {{ request()->routeIs('shop.*') ? '#0496ff' : '#333' }}; text-decoration: none; font-size: 15px; transition: all 0.3s;">
                                    Shop <i class="fa-solid fa-chevron-down ms-1" style="font-size: 10px;"></i>
                                </a>
                                <!-- Dropdown Menu -->
                                <ul class="dropdown-menu-custom" style="position: absolute; top: 100%; left: 0; background: #fff; min-width: 220px; padding: 15px 0; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); opacity: 0; visibility: hidden; transform: translateY(10px); transition: all 0.3s; list-style: none; margin-top: 15px;">
                                    @php
                                        try {
                                            $navCategories = \App\Models\Admin\Product\ProductCategory::whereNull('parent_id')->where('show_on_menu', true)->orderBy('order')->limit(8)->get();
                                        } catch (\Exception $e) {
                                            $navCategories = collect();
                                        }
                                    @endphp
                                    @foreach($navCategories as $category)
                                        <li>
                                            <a href="{{ route('shop.index', ['category' => $category->name]) }}" class="dropdown-item-custom d-flex align-items-center" style="padding: 10px 25px; color: #666; text-decoration: none; font-size: 14px; transition: all 0.3s;">
                                                <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i>
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                    <li style="border-top: 1px solid #eee; margin-top: 10px; padding-top: 10px;">
                                        <a href="{{ route('shop.index') }}" class="dropdown-item-custom d-flex align-items-center" style="padding: 10px 25px; color: #0496ff; text-decoration: none; font-size: 14px; font-weight: 600;">
                                            <i class="fa-solid fa-th-large me-2"></i>
                                            View All Categories
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('frontend.about') }}" class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}" style="font-weight: 500; color: {{ request()->routeIs('frontend.about') ? '#0496ff' : '#333' }}; text-decoration: none; font-size: 15px; transition: all 0.3s;">
                                    About
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('frontend.contact') }}" class="nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}" style="font-weight: 500; color: {{ request()->routeIs('frontend.contact') ? '#0496ff' : '#333' }}; text-decoration: none; font-size: 15px; transition: all 0.3s;">
                                    Contact
                                </a>
                            </li>
                        </ul>
                    </nav>
                    
                    <!-- Right Icons -->
                    <div class="header-icons d-flex align-items-center gap-3">
                        <!-- Search Icon (Mobile) -->
                        <button class="icon-btn d-lg-none open-search" style="width: 42px; height: 42px; border: none; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #333; font-size: 16px; transition: all 0.3s; cursor: pointer;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        
                        <!-- Wishlist Icon -->
                        <a href="#" class="icon-btn position-relative" style="width: 42px; height: 42px; border: none; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #333; font-size: 16px; text-decoration: none; transition: all 0.3s;">
                            <i class="fa-regular fa-heart"></i>
                            <span class="badge-count" style="position: absolute; top: -5px; right: -5px; width: 20px; height: 20px; background: #dc3545; color: #fff; border-radius: 50%; font-size: 10px; display: flex; align-items: center; justify-content: center; font-weight: 600;">0</span>
                        </a>
                        
                        <!-- Cart Icon -->
                        <button class="icon-btn position-relative open-cart" style="width: 42px; height: 42px; border: none; background: #0496ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; cursor: pointer; transition: all 0.3s;">
                            <i class="fa-solid fa-shopping-bag"></i>
                            <span class="badge-count cart-count" style="position: absolute; top: -5px; right: -5px; width: 20px; height: 20px; background: #dc3545; color: #fff; border-radius: 50%; font-size: 10px; display: flex; align-items: center; justify-content: center; font-weight: 600;">0</span>
                        </button>
                        
                        <!-- User Icon (Desktop) -->
                        @auth
                        <div class="user-dropdown position-relative d-none d-lg-block">
                            <button class="icon-btn user-btn d-flex align-items-center gap-2" style="border: none; background: #f5f5f5; border-radius: 50px; padding: 5px 15px 5px 5px; cursor: pointer; transition: all 0.3s;">
                                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <span style="font-size: 13px; font-weight: 500; color: #333;">{{ Str::limit(Auth::user()->name ?? 'User', 10) }}</span>
                                <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: #666;"></i>
                            </button>
                            <ul class="user-dropdown-menu" style="position: absolute; top: 100%; right: 0; background: #fff; min-width: 200px; padding: 15px 0; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); opacity: 0; visibility: hidden; transform: translateY(10px); transition: all 0.3s; list-style: none; margin-top: 10px; z-index: 100;">
                                <li>
                                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center" style="padding: 10px 20px; color: #666; text-decoration: none; font-size: 14px; transition: all 0.3s;">
                                        <i class="fa-solid fa-tachometer-alt me-2" style="color: #0496ff;"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="d-flex align-items-center" style="padding: 10px 20px; color: #666; text-decoration: none; font-size: 14px; transition: all 0.3s;">
                                        <i class="fa-solid fa-user-cog me-2" style="color: #0496ff;"></i> My Profile
                                    </a>
                                </li>
                                <li style="border-top: 1px solid #eee; margin-top: 10px; padding-top: 10px;">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="d-flex align-items-center w-100" style="padding: 10px 20px; color: #dc3545; background: none; border: none; font-size: 14px; cursor: pointer; transition: all 0.3s;">
                                            <i class="fa-solid fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endauth
                        
                        <!-- Mobile Menu Toggle -->
                        <button class="mobile-menu-toggle d-xl-none" style="width: 42px; height: 42px; border: none; background: #1a1a2e; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px; cursor: pointer; transition: all 0.3s;">
                            <span style="width: 20px; height: 2px; background: #fff; border-radius: 2px; transition: all 0.3s;"></span>
                            <span style="width: 20px; height: 2px; background: #fff; border-radius: 2px; transition: all 0.3s;"></span>
                            <span style="width: 14px; height: 2px; background: #fff; border-radius: 2px; transition: all 0.3s; align-self: flex-start; margin-left: 11px;"></span>
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->

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
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
