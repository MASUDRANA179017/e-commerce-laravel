<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <a href="{{ route('home') }}" class="footer-logo d-inline-block mb-3">
                        <img src="{{ asset('frontend/images/logo-white.png') }}" alt="GrowUp E-Commerce" height="50" onerror="this.src='https://via.placeholder.com/150x50/1a1a2e/ffffff?text=LOGO'">
                    </a>
                    <p class="text-white-50">Your trusted online shopping destination. Quality products, great prices, and excellent customer service.</p>
                    <div class="social mt-4">
                        <a href="#" target="_blank" aria-label="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" target="_blank" aria-label="twitter"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" target="_blank" aria-label="instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" target="_blank" aria-label="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="footer-widget">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('shop.index') }}">Shop</a></li>
                        <li><a href="{{ route('frontend.about') }}">About Us</a></li>
                        <li><a href="{{ route('frontend.contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h5>Customer Service</h5>
                    <ul class="footer-links">
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Track Order</a></li>
                        <li><a href="#">Returns & Refunds</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h5>Contact Info</h5>
                    <ul class="footer-contact">
                        <li><i class="fa-solid fa-location-dot"></i> Dhaka, Bangladesh</li>
                        <li><i class="fa-solid fa-phone"></i> +880 1713-269591</li>
                        <li><i class="fa-solid fa-envelope"></i> info@growup.com</li>
                        <li><i class="fa-solid fa-clock"></i> Mon - Sat: 9AM - 6PM</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} GrowUp E-Commerce. All Rights Reserved. Developed by <a href="https://qbit-tech.com" target="_blank" class="text-white">QBit Tech</a></p>
        </div>
    </div>
</footer>

