<!-- Topbar Start -->
<div class="topbar topbar-six-area d-none d-lg-block overflow-visible z-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="topbar-six__wrapper d-flex justify-content-between align-items-center">
                            <!-- left -->
                            <div class="topbar__list-wrapper">
                                <ul class="topbar__list topbar-six-list">
                                    @if($business_setup && ($business_setup->email_address[0] ?? null))
                                    <li>
                                        <a class="fw-normal"
                                            href="mailto:{{ $business_setup->email_address[0] }}">
                                            <i class="fa-regular fa-envelope"></i> {{ $business_setup->email_address[0] }}
                                        </a>
                                    </li>
                                    @endif
                                    @if($business_setup && ($business_setup->official_contact_number[0] ?? null))
                                    <li>
                                        <a class="fw-normal" href="tel:{{ str_replace([' ', '-'], '', $business_setup->official_contact_number[0]) }}">
                                            <i class="fa-solid fa-phone"></i> Sales: {{ $business_setup->official_contact_number[0] }}
                                        </a>
                                    </li>
                                    @endif
                                    @if($business_setup && ($business_setup->hotline_number[0] ?? null))
                                    <li>
                                        <a class="fw-normal" href="tel:{{ str_replace([' ', '-'], '', $business_setup->hotline_number[0]) }}">
                                            <i class="fa-solid fa-headset"></i> Hotline: {{ $business_setup->hotline_number[0] }}
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- right -->
                            <div class="topbar-six-right">
                                <ul
                                    class="d-flex footer__bottom-list gap-4 justify-content-center justify-content-lg-end">
                                    @guest
                                        <li><a class="fw-normal" href="{{ route('login') }}"><i class='bx bx-user'></i>
                                                Login</a></li>
                                        <li><a class="fw-normal" href="{{ route('register') }}"><i
                                                    class='bx bx-user-plus'></i> Register</a></li>
                                    @else
                                        <li><a class="fw-normal" href="{{ route('dashboard') }}"><i class='bx bx-user'></i>
                                                My Account</a></li>
                                    @endguest
                                </ul>
                            </div>
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
        background: #122f2a !important;
        transform: translateY(-2px);
    }
</style>
