<header class="header header-tertiary header-six-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="main-header__menu-box">
                    <nav class="navbar p-0">
                        <div class="navbar-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('frontend/images/logo.png') }}" alt="GrowUp E-Commerce" height="50" onerror="this.src='https://via.placeholder.com/150x50?text=LOGO'">
                            </a>
                        </div>
                        <div class="navbar__options">
                            <div class="header-six-navbar-space d-flex justify-content-end">
                                <nav class="navbar__menu d-none d-xl-block">
                                    <ul class="navbar__list">
                                        <li class="navbar__item nav-fade">
                                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                                        </li>
                                        <li class="navbar__item nav-fade">
                                            <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop</a>
                                        </li>
                                        <li class="navbar__item navbar__item--has-children nav-fade">
                                            <a href="#" aria-label="dropdown menu">Categories</a>
                                            <ul class="navbar__sub-menu">
                                                @php
                                                    try {
                                                        $navCategories = \App\Models\Admin\Product\ProductCategory::whereNull('parent_id')->where('show_on_menu', true)->limit(8)->get();
                                                    } catch (\Exception $e) {
                                                        $navCategories = collect();
                                                    }
                                                @endphp
                                                @foreach($navCategories as $category)
                                                    <li><a href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                                                @endforeach
                                                <li><a href="{{ route('shop.index') }}">View All</a></li>
                                            </ul>
                                        </li>
                                        <li class="navbar__item nav-fade">
                                            <a href="{{ route('frontend.about') }}" class="{{ request()->routeIs('frontend.about') ? 'active' : '' }}">About Us</a>
                                        </li>
                                        <li class="navbar__item nav-fade">
                                            <a href="{{ route('frontend.contact') }}" class="{{ request()->routeIs('frontend.contact') ? 'active' : '' }}">Contact</a>
                                        </li>
                                        <li>
                                            <a href="#" class="open-search" aria-label="search products" title="Search">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="open-cart position-relative" aria-label="cart" title="Cart">
                                                <i class="fa-solid fa-shopping-cart"></i>
                                                <span class="cart-count badge bg-danger rounded-circle">0</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="contact-btn ms-4">
                                <a href="{{ route('shop.index') }}" class="btn--primary">Shop Now</a>
                            </div>
                            <button class="open-offcanvas-nav d-flex d-xl-none ms-3" aria-label="toggle mobile menu"
                                title="open offcanvas menu" style="background: none; border: none;">
                                <span class="icon-bar top-bar" style="display: block; width: 25px; height: 3px; background: #333; margin: 5px 0;"></span>
                                <span class="icon-bar middle-bar" style="display: block; width: 25px; height: 3px; background: #333; margin: 5px 0;"></span>
                                <span class="icon-bar bottom-bar" style="display: block; width: 25px; height: 3px; background: #333; margin: 5px 0;"></span>
                            </button>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

