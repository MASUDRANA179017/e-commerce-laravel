<!-- Footer Start -->
<footer class="footer-two footer-six-area footer-eight-area"
            data-background="{{ asset('frontend/assets/images/footer-eight-bg.jpg') }}">
            <div class="container">
                <div class="footer-eight-top">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 d-flex align-items-center">
                            <div class="footer-eight-top-wrap">
                                <h4>Subscribe to Our Newsletter</h4>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 d-flex align-items-center">
                            <div class="footer-eight-top-wrap">
                                <div class="subscribe-six-input">
                                    <input type="email" placeholder="Enter your email">
                                    <div class="subscribe-six-button subscribe-eight-button">
                                        <button
                                            class="btn--primary btn-six-primary d-none d-md-flex text-white fw-medium rounded-5">Subscribe</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($business_setup && ($business_setup->official_contact_number[0] ?? null))
                        <div class="col-xl-3 col-lg-3 col-md-3 d-flex align-items-center">
                            <div class="footer-eight-top-info position-relative call">
                                <div class="footer-eight-top-icon">
                                    <span><i class="fa-solid fa-phone"></i></span>
                                </div>
                                <div class="footer-eight-top-info-con">
                                    <p>Sales Hotline</p>
                                    <a class="apece-link-line" href="tel:{{ str_replace([' ', '-'], '', $business_setup->official_contact_number[0]) }}">{{ $business_setup->official_contact_number[0] }}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($business_setup && ($business_setup->hotline_number[0] ?? null))
                        <div class="col-xl-3 col-lg-3 col-md-3 d-flex align-items-center">
                            <div class="footer-eight-top-info position-relative gamil">
                                <div class="footer-eight-top-icon">
                                    <span><i class="fa-solid fa-headset"></i></span>
                                </div>
                                <div class="footer-eight-top-info-con">
                                    <p>Support</p>
                                    <a class="apece-link-line" href="tel:{{ str_replace([' ', '-'], '', $business_setup->hotline_number[0]) }}">{{ $business_setup->hotline_number[0] }}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <!-- Brand / About -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="footer-two__widget">
                            <div class="footer-two__widget-logo mb-2">
                                <a href="{{ route('home') }}">
                                    <img src="{{ $business_setup && $business_setup->logo ? asset('storage/' . $business_setup->logo) : asset('frontend/assets/images/logo.png') }}"
                                        alt="{{ config('app.name') }}" height="50">
                                </a>
                            </div>
                            <div class="footer-two__widget-content">
                                <p class="sub-itle-lg">
                                    {{ $business_setup->footer_text ?? 'Your one-stop destination for quality products at affordable prices. Shop with confidence and enjoy fast delivery.' }}
                                </p>
                                <div class="social">
                                    @if($business_setup && $business_setup->facebook_status && $business_setup->facebook_url)
                                        <a href="{{ $business_setup->facebook_url }}" target="_blank" aria-label="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                    @endif
                                    @if(isset($business_setup->instagram_status) && isset($business_setup->instagram_url) && $business_setup->instagram_status && $business_setup->instagram_url)
                                        <a href="{{ $business_setup->instagram_url }}" target="_blank" aria-label="instagram"><i class="fa-brands fa-instagram"></i></a>
                                    @endif
                                    @if($business_setup && $business_setup->twitter_status && $business_setup->twitter_url)
                                        <a href="{{ $business_setup->twitter_url }}" target="_blank" aria-label="twitter"><i class="fa-brands fa-twitter"></i></a>
                                    @endif
                                    @if($business_setup && $business_setup->youtube_status && $business_setup->youtube_url)
                                        <a href="{{ $business_setup->youtube_url }}" target="_blank" aria-label="youtube"><i class="fa-brands fa-youtube"></i></a>
                                    @endif
                                    @if($business_setup && $business_setup->linkedin_status && $business_setup->linkedin_url)
                                        <a href="{{ $business_setup->linkedin_url }}" target="_blank" aria-label="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-12 col-md-6 col-xl-2 offset-xl-1">
                        <div class="footer-two__widget">
                            <div class="footer-two__widget-intro">
                                <h5>Quick Links</h5>
                                <div class="line">
                                    <span class="large-line"></span>
                                    <span class="small-line"></span>
                                    <span class="small-line"></span>
                                </div>
                            </div>
                            <div class="footer-two__widget-content">
                                <ul>
                                    @php
                                        // Load footer menu from database
                                        $footerMenuModel = \App\Models\Menu::where('key', 'footer')->first();
                                        $footerMenu = [];
                                        if ($footerMenuModel && $footerMenuModel->children) {
                                            $footerMenu = $footerMenuModel->children->where('parent_id', null)->map(function($item) {
                                                return ['label' => $item->label, 'url' => $item->url];
                                            })->values()->toArray();
                                        }
                                    @endphp
                                    @foreach($footerMenu as $m)
                                        <li>
                                            <a class="text-white sub-title-lg" href="{{ $m['url'] }}">
                                                <span><i class="fa-solid fa-angle-right me-2"></i></span> {{ $m['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Service -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="footer-two__widget footer-two__widget--alternate">
                            <div class="footer-two__widget-intro">
                                <h5>Customer Service</h5>
                                <div class="line">
                                    <span class="large-line"></span>
                                    <span class="small-line"></span>
                                    <span class="small-line"></span>
                                </div>
                            </div>
                            <div class="footer-two__widget-content">
                                <ul>
                                    <li><a class="text-white sub-title-lg" href="{{ route('cart.index') }}"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> My Cart</a></li>
                                    <li><a class="text-white sub-title-lg" href="{{ route('wishlist.index') }}"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> Wishlist</a></li>
                                    <li><a class="text-white sub-title-lg" href="#"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> Track Order</a>
                                    </li>
                                    <li><a class="text-white sub-title-lg" href="#"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> Returns &
                                            Refunds</a></li>
                                    <li><a class="text-white sub-title-lg" href="#"><span><i
                                                    class="fa-solid fa-angle-right me-2"></i></span> FAQs</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="footer-two__widget footer-two__widget--alternate">
                            <div class="footer-two__widget-intro">
                                <h5>Get In Touch</h5>
                                <div class="line">
                                    <span class="large-line"></span>
                                    <span class="small-line"></span>
                                    <span class="small-line"></span>
                                </div>
                            </div>
                            <div class="footer-two__widget-content footer-two__widget-content--contact">
                                <ul>
                                    @if($business_setup && ($business_setup->street_address || $business_setup->city_thana || $business_setup->district))
                                    <li>
                                        <a class="text-white sub-title-lg footer-address" href="#">
                                            <i class="fa-solid fa-location-dot"></i> {{ $business_setup->street_address ?? '' }}{{ ($business_setup->street_address ?? '') && ($business_setup->city_thana ?? '') ? ', ' : '' }}{{ $business_setup->city_thana ?? '' }}{{ ($business_setup->district ?? '') ? ', ' . $business_setup->district : '' }}
                                        </a>
                                    </li>
                                    @endif
                                    @if($business_setup && ($business_setup->official_contact_number[0] ?? null))
                                    <li><a class="text-white sub-title-lg" href="tel:{{ str_replace([' ', '-'], '', $business_setup->official_contact_number[0]) }}"><i
                                                class="fa-solid fa-phone"></i> {{ $business_setup->official_contact_number[0] }}</a></li>
                                    @endif
                                    @if($business_setup && ($business_setup->email_address[0] ?? null))
                                    <li><a class="text-white sub-title-lg" href="mailto:{{ $business_setup->email_address[0] }}"><i
                                                class="fa-solid fa-envelope"></i> {{ $business_setup->email_address[0] }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-two__copyright footer-six-copyright">
                <div class="container">
                    <div class="row align-items-center gutter-12 footer-six-copyright-border position-relative">
                        <div class="col-12 col-lg-6">
                            <div class="footer-two__copyright-inner text-center text-lg-start">
                                <p>
                                    @if($business_setup && $business_setup->copyright_text)
                                        {{ $business_setup->copyright_text }}
                                    @else
                                        Copyright &copy; <span id="copyrightYear">{{ date('Y') }}</span> <a href="{{ url('/') }}">{{ $business_setup->company_name ?? config('app.name') }}</a>. All rights reserved.
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="footer__bottom-left">
                                <ul class="footer__bottom-list justify-content-center justify-content-lg-end">
                                    <li><a href="{{ route('frontend.terms') }}">Terms & Conditions</a></li>
                                    <li><a href="{{ route('frontend.privacy') }}">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
<!-- Footer End -->

<style>
    .footer-area .social-icon:hover {
        background: #0496ff !important;
        transform: translateY(-3px);
    }
    .footer-area a:hover {
        color: #fff !important;
        padding-left: 5px;
    }
        /* Keep store address casing as entered */
        .footer-address {
            text-transform: none !important;
        }
    .contact-card:hover {
        background: rgba(255,255,255,0.08) !important;
    }
</style>
