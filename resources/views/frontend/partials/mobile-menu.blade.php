<div class="mobile-menu d-block d-xl-none">
    <nav class="mobile-menu__wrapper">
        <div class="mobile-menu__header nav-fade">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo" height="40" onerror="this.src='https://via.placeholder.com/120x40?text=LOGO'">
                </a>
            </div>
            <button aria-label="close mobile menu" class="close-mobile-menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="mobile-menu__list" style="padding: 20px;">
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="border-bottom: 1px solid #eee;">
                    <a href="{{ route('home') }}" style="display: block; padding: 15px 0; color: #333; text-decoration: none; font-weight: 500;">Home</a>
                </li>
                <li style="border-bottom: 1px solid #eee;">
                    <a href="{{ route('shop.index') }}" style="display: block; padding: 15px 0; color: #333; text-decoration: none; font-weight: 500;">Shop</a>
                </li>
                <li style="border-bottom: 1px solid #eee;">
                    <a href="{{ route('frontend.about') }}" style="display: block; padding: 15px 0; color: #333; text-decoration: none; font-weight: 500;">About Us</a>
                </li>
                <li style="border-bottom: 1px solid #eee;">
                    <a href="{{ route('frontend.contact') }}" style="display: block; padding: 15px 0; color: #333; text-decoration: none; font-weight: 500;">Contact</a>
                </li>
                <li style="border-bottom: 1px solid #eee;">
                    <a href="{{ route('cart.index') }}" style="display: block; padding: 15px 0; color: #333; text-decoration: none; font-weight: 500;">Cart</a>
                </li>
                @guest
                <li style="border-bottom: 1px solid #eee;">
                    <a href="{{ route('login') }}" style="display: block; padding: 15px 0; color: #333; text-decoration: none; font-weight: 500;">Login</a>
                </li>
                <li style="border-bottom: 1px solid #eee;">
                    <a href="{{ route('register') }}" style="display: block; padding: 15px 0; color: #333; text-decoration: none; font-weight: 500;">Register</a>
                </li>
                @else
                <li style="border-bottom: 1px solid #eee;">
                    <a href="{{ route('dashboard') }}" style="display: block; padding: 15px 0; color: #333; text-decoration: none; font-weight: 500;">My Account</a>
                </li>
                @endguest
            </ul>
        </div>
        <div class="mobile-menu__social social nav-fade" style="padding: 20px; text-align: center;">
            <a href="#" target="_blank" style="display: inline-flex; width: 40px; height: 40px; align-items: center; justify-content: center; background: #f5f5f5; border-radius: 50%; margin: 0 5px; color: #333;">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="#" target="_blank" style="display: inline-flex; width: 40px; height: 40px; align-items: center; justify-content: center; background: #f5f5f5; border-radius: 50%; margin: 0 5px; color: #333;">
                <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="#" target="_blank" style="display: inline-flex; width: 40px; height: 40px; align-items: center; justify-content: center; background: #f5f5f5; border-radius: 50%; margin: 0 5px; color: #333;">
                <i class="fa-brands fa-instagram"></i>
            </a>
        </div>
    </nav>
</div>
<div class="mobile-menu__backdrop"></div>

