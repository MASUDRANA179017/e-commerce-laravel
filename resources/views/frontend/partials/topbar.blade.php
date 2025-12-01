<!-- Topbar Start -->
<div class="topbar-area d-none d-lg-block" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); padding: 10px 0;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Side - Contact Info -->
            <div class="col-lg-8">
                <ul class="topbar-list d-flex align-items-center gap-4 mb-0 list-unstyled">
                    <li>
                        <a href="mailto:info@growup.com" class="d-flex align-items-center text-white-50 text-decoration-none" style="font-size: 13px; transition: all 0.3s;">
                            <i class="fa-regular fa-envelope me-2" style="color: #0496ff;"></i>
                            info@growup.com
                        </a>
                    </li>
                    <li>
                        <a href="tel:+8801713269591" class="d-flex align-items-center text-white-50 text-decoration-none" style="font-size: 13px; transition: all 0.3s;">
                            <i class="fa-solid fa-phone me-2" style="color: #0496ff;"></i>
                            +880 1713-269591
                        </a>
                    </li>
                    <li>
                        <span class="d-flex align-items-center text-white-50" style="font-size: 13px;">
                            <i class="fa-solid fa-location-dot me-2" style="color: #0496ff;"></i>
                            Dhaka, Bangladesh
                        </span>
                    </li>
                </ul>
            </div>
            
            <!-- Right Side - Auth Links & Social -->
            <div class="col-lg-4">
                <div class="d-flex align-items-center justify-content-end gap-4">
                    <!-- Social Icons -->
                    <div class="social-icons d-flex gap-2">
                        <a href="#" target="_blank" class="social-icon" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.1); border-radius: 50%; color: #fff; font-size: 12px; transition: all 0.3s;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" target="_blank" class="social-icon" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.1); border-radius: 50%; color: #fff; font-size: 12px; transition: all 0.3s;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" target="_blank" class="social-icon" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.1); border-radius: 50%; color: #fff; font-size: 12px; transition: all 0.3s;">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                    
                    <!-- Divider -->
                    <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.2);"></div>
                    
                    <!-- Auth Links -->
                    <ul class="auth-links d-flex align-items-center gap-3 mb-0 list-unstyled">
                        @guest
                            <li>
                                <a href="{{ route('login') }}" class="text-white-50 text-decoration-none d-flex align-items-center" style="font-size: 13px; transition: all 0.3s;">
                                    <i class="fa-regular fa-user me-1"></i> Login
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}" class="text-white text-decoration-none d-flex align-items-center" style="font-size: 13px; background: #0496ff; padding: 5px 15px; border-radius: 20px; transition: all 0.3s;">
                                    <i class="fa-solid fa-user-plus me-1"></i> Sign Up
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('dashboard') }}" class="text-white-50 text-decoration-none d-flex align-items-center" style="font-size: 13px; transition: all 0.3s;">
                                    <i class="fa-solid fa-user-circle me-1"></i> My Account
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-white-50 text-decoration-none p-0 d-flex align-items-center" style="font-size: 13px;">
                                        <i class="fa-solid fa-sign-out-alt me-1"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->

<style>
    .topbar-area .topbar-list li a:hover,
    .topbar-area .auth-links li a:hover {
        color: #fff !important;
    }
    .topbar-area .social-icon:hover {
        background: #0496ff !important;
        transform: translateY(-2px);
    }
</style>
