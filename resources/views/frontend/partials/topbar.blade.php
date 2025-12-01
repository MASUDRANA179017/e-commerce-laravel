<div class="topbar topbar-six-area d-none d-lg-block overflow-visible z-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="topbar-six__wrapper d-flex justify-content-between align-items-center">
                    <div class="topbar__list-wrapper">
                        <ul class="topbar__list topbar-six-list">
                            <li><a class="fw-normal" href="mailto:info@growup.com"><i class="fa-regular fa-envelope"></i> info@growup.com</a></li>
                            <li><a class="fw-normal" href="tel:+8801713269591"><i class="fa-solid fa-phone"></i> +880 1713-269591</a></li>
                            <li><a class="fw-normal" href="#"><i class='bx bxs-map-pin'></i> Dhaka, Bangladesh</a></li>
                        </ul>
                    </div>
                    <div class="topbar-six-right">
                        <ul class="d-flex footer__bottom-list gap-4 justify-content-center justify-content-lg-end">
                            @guest
                                <li><a href="{{ route('register') }}">Sign up</a></li>
                                <li><a href="{{ route('login') }}">Login</a></li>
                            @else
                                <li><a href="{{ route('dashboard') }}">My Account</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 text-white text-decoration-none" style="font-size: 14px;">Logout</button>
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

