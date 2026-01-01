<!-- Footer Start -->
<footer class="footer-area" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); padding-top: 80px;">
    <div class="container">
        <!-- Footer Top -->
        <div class="row g-4 pb-5">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center text-decoration-none mb-4">
                        @if($business_setup && $business_setup->logo)
                            <img src="{{ asset('storage/' . $business_setup->logo) }}" alt="{{ $business_setup->company_name }}" style="height: 50px;">
                        @else
                            <div class="logo-icon me-2" style="width: 50px; height: 50px; background: #0496ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-cart-shopping text-white" style="font-size: 22px;"></i>
                            </div>
                            <div class="logo-text">
                                <h4 class="mb-0 text-white" style="font-weight: 700;">{{ $business_setup->company_name ?? 'GrowUp' }}</h4>
                                <small style="font-size: 10px; color: rgba(255,255,255,0.5); letter-spacing: 1px;">E-COMMERCE</small>
                            </div>
                        @endif
                    </a>
                    <p style="color: rgba(255,255,255,0.6); font-size: 14px; line-height: 1.8; margin-bottom: 25px;">
                        {{ $business_setup->footer_text ?? 'Your ultimate shopping destination for quality products at the best prices. We deliver happiness right to your doorstep.' }}
                    </p>
                    
                    <!-- Social Icons -->
                    <div class="social-icons d-flex gap-2">
                        @if($business_setup && $business_setup->facebook_status && $business_setup->facebook_url)
                        <a href="{{ $business_setup->facebook_url }}" target="_blank" class="social-icon" style="width: 42px; height: 42px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if($business_setup && $business_setup->twitter_status && $business_setup->twitter_url)
                        <a href="{{ $business_setup->twitter_url }}" target="_blank" class="social-icon" style="width: 42px; height: 42px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                        @if($business_setup && $business_setup->instagram_status && $business_setup->instagram_url)
                        <a href="{{ $business_setup->instagram_url }}" target="_blank" class="social-icon" style="width: 42px; height: 42px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if($business_setup && $business_setup->youtube_status && $business_setup->youtube_url)
                        <a href="{{ $business_setup->youtube_url }}" target="_blank" class="social-icon" style="width: 42px; height: 42px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;">
                            <i class="fab fa-youtube"></i>
                        </a>
                        @endif
                        @if($business_setup && $business_setup->linkedin_status && $business_setup->linkedin_url)
                        <a href="{{ $business_setup->linkedin_url }}" target="_blank" class="social-icon" style="width: 42px; height: 42px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <div class="footer-widget">
                    <h5 style="color: #fff; font-weight: 600; margin-bottom: 25px; position: relative; padding-bottom: 15px;">
                        Quick Links
                        <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background: #0496ff; border-radius: 2px;"></span>
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a href="{{ route('home') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; transition: all 0.3s; display: flex; align-items: center;">
                                <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i> Home
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('shop.index') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; transition: all 0.3s; display: flex; align-items: center;">
                                <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i> Shop
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('frontend.about') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; transition: all 0.3s; display: flex; align-items: center;">
                                <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i> About Us
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('frontend.contact') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; transition: all 0.3s; display: flex; align-items: center;">
                                <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i> Contact
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Customer Service -->
            <div class="col-lg-2 col-md-6">
                <div class="footer-widget">
                    <h5 style="color: #fff; font-weight: 600; margin-bottom: 25px; position: relative; padding-bottom: 15px;">
                        Support
                        <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background: #0496ff; border-radius: 2px;"></span>
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; transition: all 0.3s; display: flex; align-items: center;">
                                <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i> FAQs
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; transition: all 0.3s; display: flex; align-items: center;">
                                <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i> Shipping Info
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="#" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; transition: all 0.3s; display: flex; align-items: center;">
                                <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i> Returns
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('frontend.terms') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; transition: all 0.3s; display: flex; align-items: center;">
                                <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i> Terms & Conditions
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('frontend.privacy') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px; transition: all 0.3s; display: flex; align-items: center;">
                                <i class="fa-solid fa-angle-right me-2" style="color: #0496ff; font-size: 12px;"></i> Privacy Policy
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h5 style="color: #fff; font-weight: 600; margin-bottom: 25px; position: relative; padding-bottom: 15px;">
                        Contact Us
                        <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 3px; background: #0496ff; border-radius: 2px;"></span>
                    </h5>
                    
                    <!-- Contact Cards -->
                    <div class="contact-cards">
                        <div class="contact-card d-flex align-items-start gap-3 mb-4" style="padding: 15px; background: rgba(255,255,255,0.05); border-radius: 12px;">
                            <div style="width: 45px; height: 45px; background: rgba(4, 150, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-location-dot" style="color: #0496ff; font-size: 18px;"></i>
                            </div>
                            <div>
                                <h6 style="color: #fff; font-weight: 500; margin-bottom: 5px; font-size: 14px;">Address</h6>
                                <p style="color: rgba(255,255,255,0.6); font-size: 13px; margin-bottom: 0; line-height: 1.6;">
                                    {{ $business_setup->street_address ?? '123 Commerce Street' }}<br>
                                    {{ $business_setup->city_thana ?? '' }} {{ $business_setup->district ?? 'Dhaka-1000, Bangladesh' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="contact-card d-flex align-items-start gap-3 mb-4" style="padding: 15px; background: rgba(255,255,255,0.05); border-radius: 12px;">
                            <div style="width: 45px; height: 45px; background: rgba(4, 150, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-phone" style="color: #0496ff; font-size: 18px;"></i>
                            </div>
                            <div>
                                <h6 style="color: #fff; font-weight: 500; margin-bottom: 5px; font-size: 14px;">Phone</h6>
                                <a href="tel:{{ $business_setup->official_contact_number[0] ?? '+8801713269591' }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px;">{{ $business_setup->official_contact_number[0] ?? '+880 1713-269591' }}</a>
                            </div>
                        </div>
                        
                        <div class="contact-card d-flex align-items-start gap-3" style="padding: 15px; background: rgba(255,255,255,0.05); border-radius: 12px;">
                            <div style="width: 45px; height: 45px; background: rgba(4, 150, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-regular fa-envelope" style="color: #0496ff; font-size: 18px;"></i>
                            </div>
                            <div>
                                <h6 style="color: #fff; font-weight: 500; margin-bottom: 5px; font-size: 14px;">Email</h6>
                                <a href="mailto:{{ $business_setup->email_address[0] ?? 'info@growup.com' }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px;">{{ $business_setup->email_address[0] ?? 'info@growup.com' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Newsletter -->
        <div class="newsletter-area py-5" style="border-top: 1px solid rgba(255,255,255,0.1); border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 60px; height: 60px; background: rgba(4, 150, 255, 0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-regular fa-paper-plane" style="color: #0496ff; font-size: 24px;"></i>
                        </div>
                        <div>
                            <h5 style="color: #fff; font-weight: 600; margin-bottom: 5px;">Subscribe Newsletter</h5>
                            <p style="color: rgba(255,255,255,0.6); font-size: 14px; margin-bottom: 0;">Get updates about new products and special offers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form class="newsletter-form">
                        <div class="input-group" style="border-radius: 50px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                            <input type="email" class="form-control" placeholder="Enter your email address..." style="padding: 18px 25px; border: none; font-size: 14px;">
                            <button type="submit" class="btn" style=" color: #fff; padding: 0 35px; font-weight: 500;">
                                Subscribe <i class="fa-solid fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Payment Methods -->
        <div class="payment-area py-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0 text-center text-lg-start">
                    <span style="color: rgba(255,255,255,0.5); font-size: 14px;">We Accept:</span>
                    <div class="payment-methods d-inline-flex align-items-center gap-3 ms-3">
                        @php
                            $methods = [
                                'visa' => ['icon' => 'fab fa-cc-visa', 'color' => '#1A1F71'],
                                'mastercard' => ['icon' => 'fab fa-cc-mastercard', 'color' => '#EB001B'],
                                'paypal' => ['icon' => 'fab fa-cc-paypal', 'color' => '#003087'],
                                'amex' => ['icon' => 'fab fa-cc-amex', 'color' => '#006FCF'],
                                'stripe' => ['icon' => 'fab fa-cc-stripe', 'color' => '#6772E5'],
                                'discover' => ['icon' => 'fab fa-cc-discover', 'color' => '#FF6000'],
                                'jcb' => ['icon' => 'fab fa-cc-jcb', 'color' => '#007940'],
                                'apple-pay' => ['icon' => 'fab fa-cc-apple-pay', 'color' => '#000000'],
                            ];
                            $selectedMethods = $business_setup->payment_methods ?? [];
                        @endphp
                        @forelse($selectedMethods as $methodKey)
                            @if(isset($methods[$methodKey]))
                                <div style="width: 50px; height: 32px; background: #fff; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                    <i class="{{ $methods[$methodKey]['icon'] }}" style="font-size: 24px; color: {{ $methods[$methodKey]['color'] }};"></i>
                                </div>
                            @endif
                        @empty
                            <div style="width: 50px; height: 32px; background: #fff; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                <i class="fab fa-cc-visa" style="font-size: 24px; color: #1A1F71;"></i>
                            </div>
                            <div style="width: 50px; height: 32px; background: #fff; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                <i class="fab fa-cc-mastercard" style="font-size: 24px; color: #EB001B;"></i>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-end">
                    <div class="security-badges d-inline-flex align-items-center gap-3">
                        <span style="color: rgba(255,255,255,0.5); font-size: 13px;">
                            <i class="fa-solid fa-shield-halved me-1" style="color: #0496ff;"></i> Secure Checkout
                        </span>
                        <span style="color: rgba(255,255,255,0.5); font-size: 13px;">
                            <i class="fa-solid fa-lock me-1" style="color: #0496ff;"></i> SSL Encrypted
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom" style="background: rgba(0,0,0,0.2); padding: 20px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <p style="color: rgba(255,255,255,0.5); font-size: 14px; margin-bottom: 0;">
                        @if($business_setup->copyright_text)
                            {{ $business_setup->copyright_text }}
                        @else
                            © {{ date('Y') }} <span style="color: #0496ff;">{{ $business_setup->company_name ?? 'GrowUp' }}</span>. All Rights Reserved.
                        @endif
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p style="color: rgba(255,255,255,0.4); font-size: 13px; margin-bottom: 0;">
                        Made with <i class="fa-solid fa-heart" style="color: #dc3545;"></i> by QBit Technology
                    </p>
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
    .contact-card:hover {
        background: rgba(255,255,255,0.08) !important;
    }
</style>
