<!-- Header Start -->
<header class="header header-tertiary header-six-area">
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
                                <style>
                                    /* Header Menu Color Overrides */
                                    .header-six-area .navbar__list > .navbar__item > a {
                                        color: var(--primary-color) !important;
                                        font-weight: 600;
                                        transition: color 0.3s ease;
                                    }
                                    .header-six-area .navbar__list > .navbar__item > a:hover,
                                    .header-six-area .navbar__list > .navbar__item.active > a {
                                        color: var(--secondary-color) !important;
                                    }
                                    
                                    /* Dropdown Links */
                                    .navbar__sub-menu li a {
                                        color: var(--primary-color) !important;
                                        transition: all 0.2s ease;
                                    }
                                    .navbar__sub-menu li a:hover {
                                        color: var(--secondary-color) !important;
                                        background-color: rgba(var(--secondary-color-rgb), 0.05);
                                        padding-left: 25px; /* slight indent effect */
                                    }

                                    /* Mobile Menu Overrides (if needed) */
                                    .mobile-menu .navbar__item > a {
                                        color: var(--primary-color) !important;
                                    }
                                    .mobile-menu .navbar__item > a:hover {
                                        color: var(--secondary-color) !important;
                                    }
                                </style>
                                <nav class="navbar__menu d-none d-xl-block" aria-label="Primary">
                                    @php
                                        // Load main menu from database
                                        $mainMenuModel = \App\Models\Menu::where('key', 'main')
                                            ->with('children')
                                            ->first();

                                        // Build nested array from MenuItem relationships
                                        $mainMenu = [];
                                        if ($mainMenuModel && $mainMenuModel->children) {
                                            $buildTree = function ($items) use (&$buildTree) {
                                                return $items
                                                    ->map(function ($item) use (&$buildTree) {
                                                        return [
                                                            'label' => $item->label,
                                                            'url' => $item->url,
                                                            'children' => $buildTree($item->children),
                                                        ];
                                                    })
                                                    ->values()
                                                    ->toArray();
                                            };
                                            $mainMenu = $buildTree($mainMenuModel->children->where('parent_id', null));
                                        }
                                    @endphp
                                    @php
                                        $renderDesktopMenu = function ($items) {
                                            echo '<ul class="navbar__list">';
                                            foreach ($items as $m) {
                                                $hasChildren =
                                                    is_array($m) &&
                                                    isset($m['children']) &&
                                                    is_array($m['children']) &&
                                                    count($m['children']) > 0;
                                                if ($hasChildren) {
                                                    echo '<li class="navbar__item navbar__item--has-children nav-fade">';
                                                    echo '<a href="' . e($m['url']) . '">' . e($m['label']) . '</a>';
                                                    // First-level dropdown
                                                    echo '<ul class="navbar__sub-menu">';
                                                    foreach ($m['children'] as $c) {
                                                        $cHasChildren =
                                                            is_array($c) &&
                                                            isset($c['children']) &&
                                                            is_array($c['children']) &&
                                                            count($c['children']) > 0;
                                                        if ($cHasChildren) {
                                                            echo '<li class="navbar__item has-nested">';
                                                            echo '<a href="' .
                                                                e($c['url']) .
                                                                '" class="desktop-sub-toggle d-flex align-items-center justify-content-between">' .
                                                                e($c['label']) .
                                                                ' <i class="fa-solid fa-chevron-down fs-12"></i></a>';
                                                            echo '<ul class="navbar__sub-menu nested">';
                                                            foreach ($c['children'] as $cc) {
                                                                echo '<li><a href="' .
                                                                    e($cc['url']) .
                                                                    '">' .
                                                                    e($cc['label']) .
                                                                    '</a></li>';
                                                            }
                                                            echo '</ul>';
                                                            echo '</li>';
                                                        } else {
                                                            echo '<li><a href="' .
                                                                e($c['url']) .
                                                                '">' .
                                                                e($c['label']) .
                                                                '</a></li>';
                                                        }
                                                    }
                                                    echo '</ul>';
                                                    echo '</li>';
                                                } else {
                                                    echo '<li class="navbar__item nav-fade"><a href="' .
                                                        e($m['url']) .
                                                        '">' .
                                                        e($m['label']) .
                                                        '</a></li>';
                                                }
                                            }
                                            echo '</ul>';
                                        };
                                    @endphp
                                    {!! $renderDesktopMenu($mainMenu) !!}
                                </nav>
                            </div>

                            <!-- Cart & Wishlist -->
                            <div class="contact-btn d-flex align-items-center gap-3">
                                <a href="#" class="open-search" aria-label="Open search">
                                    <i class="fa-solid fa-magnifying-glass fs-4"></i>
                                </a>

                                <a class="btn open-cart position-relative text-dark border-0 bg-transparent"
                                    title="Wishlist" style="text-decoration: none; cursor: pointer;"
                                    href="{{ route('wishlist.index') }}">
                                    <i class='bx bx-heart fs-4'></i>
                                    @php $wishlistCount = count(session('wishlist', [])); @endphp
                                    <span class="cart-count"
                                        style="{{ $wishlistCount > 0 ? '' : 'display: none;' }}">{{ $wishlistCount }}</span>
                                </a>
                                <button type="button"
                                    class="open-cart position-relative text-dark border-0 bg-transparent" title="Cart"
                                    style="text-decoration: none; cursor: pointer;" onclick="openSidebarCart()">
                                    <i class='bx bx-cart fs-4'></i>
                                    @php $cartCount = array_sum(array_column(session('cart', []), 'qty')); @endphp
                                    <span class="cart-count"
                                        style="{{ $cartCount > 0 ? '' : 'display: none;' }}">{{ $cartCount }}</span>
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
<!-- Header End -->

@push('styles')
    <style>
        .contact-btn .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            border-radius: 99px;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            line-height: 18px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border: 1px solid #fff;
        }
    </style>
@endpush

<!-- Mobile Menu Sidebar -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"
    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.5); z-index: 1001; opacity: 0; visibility: hidden; transition: all 0.3s;">
</div>
<div class="mobile-menu-sidebar" id="mobileMenuSidebar"
    style="position: fixed; top: 0; left: -300px; width: 300px; height: 100%; background: #fff; z-index: 1002; transition: all 0.3s; overflow-y: auto; box-shadow: 2px 0 10px rgba(0,0,0,0.1);">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
        <h5 class="m-0 fw-bold">Menu</h5>
        <button class="btn-close" id="closeMobileMenu"></button>
    </div>
    <div class="p-3">
        <!-- Mobile Search -->
        <form action="{{ route('shop.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>

        <!-- Mobile Nav Links (dynamic from database) -->
        @php
            // Load main menu from database for mobile
            $mainMenuModel = \App\Models\Menu::where('key', 'main')->with('children')->first();
            $mainMenu = [];
            if ($mainMenuModel && $mainMenuModel->children) {
                $buildTree = function ($items) use (&$buildTree) {
                    return $items
                        ->map(function ($item) use (&$buildTree) {
                            return [
                                'label' => $item->label,
                                'url' => $item->url,
                                'children' => $buildTree($item->children),
                            ];
                        })
                        ->values()
                        ->toArray();
                };
                $mainMenu = $buildTree($mainMenuModel->children->where('parent_id', null));
            }
        @endphp

        @php
            $renderMobileMenu = function ($items) use (&$renderMobileMenu) {
                echo '<ul class="list-unstyled d-flex flex-column gap-2">';
                foreach ($items as $m) {
                    $hasChildren =
                        is_array($m) && isset($m['children']) && is_array($m['children']) && count($m['children']) > 0;
                    if ($hasChildren) {
                        echo '<li class="mb-1">';
                        echo '<a href="' .
                            e($m['url']) .
                            '" class="mobile-item-toggle d-flex align-items-center justify-content-between text-dark text-decoration-none fw-medium d-block py-2 px-2">';
                        echo '<span class="d-flex align-items-center gap-2"><i class="fa-regular fa-folder" style="font-size:14px;"></i>' .
                            e($m['label']) .
                            '</span>';
                        echo '<i class="fa-solid fa-chevron-down text-muted fs-12"></i>';
                        echo '</a>';
                        echo '<div class="ps-2 mt-1 mobile-submenu navbar__sub-menu" style="display:none; padding:6px 0;">';
                        echo $renderMobileMenu($m['children']);
                        echo '</div>';
                        echo '</li>';
                    } else {
                        echo '<li class="mb-1"><a href="' .
                            e($m['url']) .
                            '" class="text-dark text-decoration-none d-block py-2 px-3">' .
                            e($m['label']) .
                            '</a></li>';
                    }
                }
                echo '</ul>';
            };
        @endphp

        {!! $renderMobileMenu($mainMenu) !!}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggles = document.querySelectorAll('.mobile-menu-toggle, .open-offcanvas-nav');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        const mobileMenuSidebar = document.getElementById('mobileMenuSidebar');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const shopToggle = document.querySelector('.shop-toggle');
        const shopDropdown = document.querySelector('.shop-dropdown');
        const mobileItemToggles = document.querySelectorAll('.mobile-item-toggle');
        const desktopDropdownItems = document.querySelectorAll('.navbar__menu .navbar__item--has-children');

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

        if (mobileMenuToggles && mobileMenuToggles.length) {
            mobileMenuToggles.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openMenu();
                });
            });
        }

        // Mobile submenu toggles
        if (mobileItemToggles && mobileItemToggles.length) {
            mobileItemToggles.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Allow the link to act as toggle without navigating immediately
                    e.preventDefault();
                    const submenu = this.nextElementSibling;
                    const chevron = this.querySelector('i');
                    const isOpen = submenu && submenu.style.display === 'block';
                    if (!submenu) return;
                    if (!isOpen) {
                        submenu.style.display = 'block';
                        if (chevron) chevron.style.transform = 'rotate(180deg)';
                    } else {
                        submenu.style.display = 'none';
                        if (chevron) chevron.style.transform = 'rotate(0deg)';
                    }
                });
            });
        }

        // Desktop submenu (hover/click) toggle
        function bindDesktopDropdowns() {
            const isDesktop = window.matchMedia('(min-width: 1200px)').matches;
            // Close any open menus when switching to mobile
            if (!isDesktop) {
                document.querySelectorAll('.navbar__menu .navbar__item--has-children.open').forEach(el => el
                    .classList.remove('open'));
                return;
            }
            desktopDropdownItems.forEach(item => {
                const link = item.querySelector(':scope > a');
                const submenu = item.querySelector(':scope > .navbar__sub-menu');
                if (!link || !submenu) return;
                // Hover behavior
                item.addEventListener('mouseenter', () => {
                    // Close siblings
                    document.querySelectorAll('.navbar__menu .navbar__item--has-children.open')
                        .forEach(el => {
                            if (el !== item) el.classList.remove('open');
                        });
                    item.classList.add('open');
                });
                item.addEventListener('mouseleave', () => {
                    item.classList.remove('open');
                });
                // Click to toggle (for touch/keyboard)
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isOpen = item.classList.contains('open');
                    document.querySelectorAll('.navbar__menu .navbar__item--has-children.open')
                        .forEach(el => el.classList.remove('open'));
                    if (!isOpen) item.classList.add('open');
                });
            });
            // Close when clicking outside
            document.addEventListener('click', function(e) {
                const menu = document.querySelector('.navbar__menu');
                if (!menu) return;
                if (!menu.contains(e.target)) {
                    document.querySelectorAll('.navbar__menu .navbar__item--has-children.open').forEach(
                        el => el.classList.remove('open'));
                }
            });
        }
        bindDesktopDropdowns();
        window.addEventListener('resize', bindDesktopDropdowns);

        // Click to expand nested submenu inside desktop dropdown
        document.addEventListener('click', function(e) {
            const toggle = e.target.closest('.desktop-sub-toggle');
            if (toggle && window.matchMedia('(min-width: 1200px)').matches) {
                e.preventDefault();
                const li = toggle.parentElement;
                if (li && li.classList.contains('has-nested')) {
                    li.classList.toggle('open');
                }
            }
        });

        if (closeMobileMenu) {
            closeMobileMenu.addEventListener('click', closeMenu);
        }

        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', closeMenu);
        }

        // Shop dropdown toggle
        if (shopToggle && shopDropdown) {
            shopToggle.addEventListener('click', function(e) {
                e.preventDefault();
                const chevron = shopToggle.querySelector('i');
                const isOpen = shopDropdown.style.display === 'block';

                if (!isOpen) {
                    shopDropdown.style.display = 'block';
                    setTimeout(() => {
                        shopDropdown.style.opacity = '1';
                        shopDropdown.style.visibility = 'visible';
                        shopDropdown.style.transform = 'translateY(0)';
                        shopDropdown.style.pointerEvents = 'auto';
                    }, 10);
                } else {
                    shopDropdown.style.opacity = '0';
                    shopDropdown.style.visibility = 'hidden';
                    shopDropdown.style.transform = 'translateY(12px)';
                    shopDropdown.style.pointerEvents = 'none';
                    setTimeout(() => {
                        shopDropdown.style.display = 'none';
                    }, 300);
                }

                if (chevron) {
                    chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
                }
            });
        }

        // Close shop dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (shopDropdown && !shopDropdown.contains(e.target) && !shopToggle.contains(e.target)) {
                shopDropdown.style.opacity = '0';
                shopDropdown.style.visibility = 'hidden';
                shopDropdown.style.transform = 'translateY(12px)';
                shopDropdown.style.pointerEvents = 'none';
                setTimeout(() => {
                    shopDropdown.style.display = 'none';
                }, 300);
                const chevron = shopToggle.querySelector('i');
                if (chevron) {
                    chevron.style.transform = 'rotate(0deg)';
                }
            }
        });

        // Category toggle
        document.querySelectorAll('.category-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                const chevron = this.querySelector('i:last-child');
                const isOpen = submenu.style.display === 'block';

                // Toggle current submenu
                if (!isOpen) {
                    submenu.style.display = 'block';
                    if (chevron) chevron.style.transform = 'rotate(180deg)';
                } else {
                    submenu.style.display = 'none';
                    if (chevron) chevron.style.transform = 'rotate(0deg)';
                }
            });
        });

        // Subcategory toggle with dynamic height
        document.querySelectorAll('.subcategory-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                const chevron = this.querySelector('i:last-child');
                const isOpen = submenu.classList.contains('active');

                if (!isOpen) {
                    // Calculate actual height
                    const children = submenu.querySelectorAll('a');
                    let totalHeight = 0;
                    children.forEach(child => {
                        totalHeight += child.offsetHeight;
                    });

                    submenu.classList.add('active');
                    submenu.style.maxHeight = (totalHeight + 10) + 'px';
                    if (chevron) chevron.style.transform = 'rotate(180deg)';
                } else {
                    submenu.classList.remove('active');
                    submenu.style.maxHeight = '0px';
                    if (chevron) chevron.style.transform = 'rotate(0deg)';
                }
            });
        });
    });
</script>

<style>
    /* Minimal responsive utilities (Bootstrap-like) for header */
    .open-offcanvas-nav {
        display: none;
    }

    @media (max-width: 1199.98px) {
        .navbar__menu {
            display: none !important;
        }

        .open-offcanvas-nav {
            display: flex !important;
        }
    }

    @media (min-width: 1200px) {
        .navbar__menu {
            display: block !important;
        }
    }

    /* Desktop dropdown positioning and animation */
    @media (min-width: 1200px) {
        .navbar__menu .navbar__item {
            position: relative;
        }

        .navbar__menu .navbar__sub-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 240px;
            border-radius: 6px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
            transform: translateY(10px);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: all 0.2s ease;
            display: block;
            /* keep block, hidden via visibility */
            /* z-index: 1050; */
        }

        .navbar__menu .navbar__item.open>.navbar__sub-menu {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .navbar__menu .navbar__sub-menu li a {
            display: block;
            /* padding: 10px 14px; */
        }

        /* nested submenu shows downward inside dropdown */
        .navbar__menu .navbar__sub-menu .nested {
            position: static;
            margin-left: 6px;
            border-left: 2px solid #374151;
            padding-left: 6px;
            display: none;
            box-shadow: none;
            min-width: auto;
        }

        .navbar__menu .navbar__sub-menu li.open>.nested {
            display: block;
        }

        .navbar__menu .navbar__sub-menu .desktop-sub-toggle {
            /* padding: 10px 14px; */
        }

        .navbar__menu .navbar__sub-menu .desktop-sub-toggle i {
            transition: transform 0.2s ease;
        }

        .navbar__menu .navbar__sub-menu li.open>.desktop-sub-toggle i {
            transform: rotate(180deg);
        }
    }

    /* Mobile sidebar sizing for small devices */
    .mobile-menu-sidebar {
        width: 80vw;
        max-width: 340px;
    }

    @media (max-width: 360px) {
        .mobile-menu-sidebar {
            width: 90vw;
        }
    }

    /* Ensure dark submenu styling if needed */
    .navbar__sub-menu,
    .navbar__sub-menu .navbar__sub-menu {
        background-color: #ffffff !important;
        color: #000000 !important;
        /* border: 1px solid #374151 !important; */
    }

    .navbar__sub-menu a {
        color: #000000 !important;
    }

    .navbar__sub-menu a:hover {
        background-color: var(--apece-primary) !important;
        color: #fff !important;
    }

    /* Mobile submenu indentation and dividers */
    .mobile-submenu ul {
        margin: 0;
        padding: 0;
    }

    .mobile-submenu li>a {
        border-left: 2px solid rgba(255, 255, 255, 0.18);
        padding-left: 14px;
    }

    .mobile-submenu .navbar__sub-menu {
        border-color: #374151 !important;
    }

    .mobile-item-toggle:hover {
        background: rgba(255, 255, 255, 0.06);
    }

    /* Keep hamburger bars color and shape stable on hover/active */
    .header .open-offcanvas-nav span {
        background-color: var(--apece-primary) !important;
    }

    .header .open-offcanvas-nav:hover span {
        background-color: var(--apece-primary) !important;
    }

    .header .open-offcanvas-nav-active .middle-bar {
        opacity: 1 !important;
    }

    .header .open-offcanvas-nav-active .top-bar,
    .header .open-offcanvas-nav-active .bottom-bar {
        transform: none !important;
    }

    .header .open-offcanvas-nav-active .top-bar {
        width: 30px !important;
        background-color: var(--apece-primary) !important;
    }

    .header .open-offcanvas-nav-active .bottom-bar {
        width: 16px !important;
        background-color: var(--apece-primary) !important;
    }
</style>
