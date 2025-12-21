<div class="sidebar-area" id="sidebar-area">
    <div class="logo position-relative">
        <a href="{{ route('user.dashboard') }}" class="d-flex align-items-center text-decoration-none position-relative">
            <img src="{{ asset('assets/images/landing/logo.svg') }}" class="h-37px" alt="logo-icon">
            <!-- <span class="logo-text fw-bold text-dark ms-2">QBit Ecommerce</span> -->
        </a>
        <button class="sidebar-burger-menu bg-transparent p-0 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y" id="sidebar-burger-menu">
            <i data-feather="x"></i>
        </button>
    </div>

    <aside id="layout-menu" class="layout-menu menu-vertical menu active" data-simplebar>
        <ul class="menu-inner">
            <!-- Dashboard -->
            <li class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <a href="{{ route('user.dashboard') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">dashboard</span>
                    <span class="title">Dashboard</span>
                </a>
            </li>

            <li class="menu-title small text-uppercase">
                <span class="menu-title-text">Account</span>
            </li>

            <!-- Account Details -->
            <li class="menu-item {{ request()->routeIs('user.account-details') ? 'active' : '' }}">
                <a href="{{ route('user.account-details') }}" class="menu-link">
                    <span class="material-symbols-outlined menu-icon">person</span>
                    <span class="title">Account Details</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="menu-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="menu-link">
                        <span class="material-symbols-outlined menu-icon">logout</span>
                        <span class="title">Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </aside>
</div>
