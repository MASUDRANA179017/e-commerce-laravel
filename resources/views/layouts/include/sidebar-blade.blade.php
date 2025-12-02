<div class="sidebar-area" id="sidebar-area">
    <div class="logo position-relative">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-decoration-none position-relative">
            <img src="{{ asset('assets/images/QBit-Tech_Fevicon.png') }}" class="h-37px" alt="logo-icon">
            <span class="logo-text fw-bold text-dark"><img src="{{ asset('assets/images/QBit-BMS_Logo-3.png') }}" class="h-20px" alt="logo-icon"></span>
        </a>
        <button class="sidebar-burger-menu bg-transparent p-0 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y" id="sidebar-burger-menu">
            <i data-feather="x"></i>
        </button>
    </div>

    <aside id="layout-menu" class="layout-menu menu-vertical menu active" data-simplebar>
        <ul class="menu-inner">
            <!-- Dashboard -->
            <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">dashboard</span>
                    <span class="title">Dashboard</span>
                </a>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">Core Business</span>
            </li>

            <!-- Orders -->
            <li class="menu-item {{ request()->routeIs('admin.orders.*') ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <span class="material-symbols-outlined menu-icon">shopping_bag</span>
                    <span class="title">Orders</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.orders.index') }}" class="menu-link">All Orders</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.orders.abandoned') ? 'active' : '' }}">
                        <a href="{{ route('admin.orders.abandoned') }}" class="menu-link">Abandoned Carts</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.orders.returns') ? 'active' : '' }}">
                        <a href="{{ route('admin.orders.returns') }}" class="menu-link">Returns (RMAs)</a>
                    </li>
                </ul>
            </li>

            <!-- Products -->
            <li class="menu-item {{ request()->routeIs('admin.product.*') || request()->routeIs('admin.product-create.*') ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <span class="material-symbols-outlined menu-icon">inventory_2</span>
                    <span class="title">Products</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.product-create.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.product-create.index') }}" class="menu-link">Create Product</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.product.all') ? 'active' : '' }}">
                        <a href="{{ route('admin.product.all') }}" class="menu-link">All Products</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.product.category.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.product.category.index') }}" class="menu-link">Categories</a>
                    </li>
                </ul>
            </li>

            <!-- Business Setup -->
            <li class="menu-item {{ request()->routeIs('admin.users.business-setup.*') || request()->routeIs('admin.all-attributes.*') || request()->routeIs('admin.users.varient-build.*') ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <span class="material-symbols-outlined menu-icon">settings</span>
                    <span class="title">Business Setup</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.users.business-setup.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.business-setup.index') }}" class="menu-link">Business Settings</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.all-attributes.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.all-attributes.all-attributes.index') }}" class="menu-link">All Attributes</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.users.varient-build.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.varient-build.index') }}" class="menu-link">Variant Build</a>
                    </li>
                    @if(Route::has('catalog.size_charts.view'))
                    <li class="menu-item {{ request()->routeIs('catalog.size_charts.view') ? 'active' : '' }}">
                        <a href="{{ route('catalog.size_charts.view') }}" class="menu-link">Size Charts</a>
                    </li>
                    @endif
                </ul>
            </li>

            <!-- Brand -->
            <li class="menu-item {{ request()->routeIs('admin.brand.*') ? 'active' : '' }}">
                <a href="{{ route('admin.brand.index') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">branding_watermark</span>
                    <span class="title">Brands</span>
                </a>
            </li>

            <!-- Customers -->
            <li class="menu-item {{ request()->routeIs('admin.customers.*') ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <span class="material-symbols-outlined menu-icon">group</span>
                    <span class="title">Customers</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.customers.index') }}" class="menu-link">All Customers</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.customers.groups') ? 'active' : '' }}">
                        <a href="{{ route('admin.customers.groups') }}" class="menu-link">Customer Groups</a>
                    </li>
                </ul>
            </li>

            <!-- Analytics -->
            <li class="menu-item {{ request()->routeIs('admin.reports.*') ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <span class="material-symbols-outlined menu-icon">analytics</span>
                    <span class="title">Analytics</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                        <a href="{{ route('admin.reports.sales') }}" class="menu-link">Sales Reports</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.reports.inventory') ? 'active' : '' }}">
                        <a href="{{ route('admin.reports.inventory') }}" class="menu-link">Inventory Reports</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.reports.customers') ? 'active' : '' }}">
                        <a href="{{ route('admin.reports.customers') }}" class="menu-link">Customer Analytics</a>
                    </li>
                </ul>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">Store Management</span>
            </li>

            <!-- Storefront -->
            <li class="menu-item {{ request()->routeIs('admin.storefront.*') ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <span class="material-symbols-outlined menu-icon">storefront</span>
                    <span class="title">Storefront</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.storefront.customizer') ? 'active' : '' }}">
                        <a href="{{ route('admin.storefront.customizer') }}" class="menu-link">Theme Customizer</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.storefront.pages') ? 'active' : '' }}">
                        <a href="{{ route('admin.storefront.pages') }}" class="menu-link">Page Builder</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.storefront.menus') ? 'active' : '' }}">
                        <a href="{{ route('admin.storefront.menus') }}" class="menu-link">Navigation Menus</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.storefront.blog') ? 'active' : '' }}">
                        <a href="{{ route('admin.storefront.blog') }}" class="menu-link">Blog Management</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.storefront.banners') ? 'active' : '' }}">
                        <a href="{{ route('admin.storefront.banners') }}" class="menu-link">Banners & Sliders</a>
                    </li>
                </ul>
            </li>

            <!-- Marketing -->
            <li class="menu-item {{ request()->routeIs('admin.marketing.*') ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <span class="material-symbols-outlined menu-icon">campaign</span>
                    <span class="title">Marketing</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.marketing.coupons') ? 'active' : '' }}">
                        <a href="{{ route('admin.marketing.coupons') }}" class="menu-link">Coupons & Discounts</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.marketing.flash-sales') ? 'active' : '' }}">
                        <a href="{{ route('admin.marketing.flash-sales') }}" class="menu-link">Flash Sales</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.marketing.newsletters') ? 'active' : '' }}">
                        <a href="{{ route('admin.marketing.newsletters') }}" class="menu-link">Newsletters</a>
                    </li>
                </ul>
            </li>

            <!-- Stock & Inventory -->
            <li class="menu-item {{ request()->routeIs('admin.inventory.*') ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <span class="material-symbols-outlined menu-icon">inventory</span>
                    <span class="title">Inventory</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.inventory.stock') ? 'active' : '' }}">
                        <a href="{{ route('admin.inventory.stock') }}" class="menu-link">Stock On Hand</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.inventory.purchases') ? 'active' : '' }}">
                        <a href="{{ route('admin.inventory.purchases') }}" class="menu-link">Purchase Orders</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.inventory.vendors') ? 'active' : '' }}">
                        <a href="{{ route('admin.inventory.vendors') }}" class="menu-link">Vendors</a>
                    </li>
                </ul>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">System</span>
            </li>

            <!-- User Management -->
            <li class="menu-item {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'open active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <span class="material-symbols-outlined menu-icon">manage_accounts</span>
                    <span class="title">User Management</span>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}" class="menu-link">All Users</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.roles.index') }}" class="menu-link">Roles</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.permissions.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.permissions.index') }}" class="menu-link">Permissions</a>
                    </li>
                </ul>
            </li>

            <!-- Units -->
            <li class="menu-item {{ request()->routeIs('admin.units.*') ? 'active' : '' }}">
                <a href="{{ route('admin.units.index') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">straighten</span>
                    <span class="title">Units</span>
                </a>
            </li>

            <!-- Contact Us -->
            <li class="menu-item {{ request()->routeIs('admin.contact') ? 'active' : '' }}">
                <a href="{{ route('admin.contact') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">contact_mail</span>
                    <span class="title">Contact Messages</span>
                </a>
            </li>

            <!-- Support Tickets -->
            <li class="menu-item {{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
                <a href="{{ route('admin.support.create') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">support_agent</span>
                    <span class="title">Support Tickets</span>
                </a>
            </li>

            <!-- Terms & Conditions -->
            @if(Route::has('terms.index'))
            <li class="menu-item {{ request()->routeIs('terms.*') ? 'active' : '' }}">
                <a href="{{ route('terms.index') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">description</span>
                    <span class="title">Terms & Conditions</span>
                </a>
            </li>
            @endif

            <!-- Settings -->
            <li class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.index') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">settings</span>
                    <span class="title">Settings</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
