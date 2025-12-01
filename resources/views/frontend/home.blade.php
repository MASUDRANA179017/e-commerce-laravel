@extends('layouts.frontend')

@section('title', 'Home - GrowUp E-Commerce')

@section('content')
<!-- Hero Banner Section -->
<section class="hero-banner position-relative overflow-hidden">
    <div class="hero-slider swiper" id="heroSlider">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <div class="hero-slide" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); min-height: 600px;">
                    <div class="container h-100">
                        <div class="row align-items-center h-100" style="min-height: 600px;">
                            <div class="col-lg-6" data-aos="fade-right">
                                <span class="badge bg-warning text-dark mb-3 px-4 py-2 rounded-pill fw-semibold">
                                    <i class="fa-solid fa-fire me-1"></i> Hot Collection 2024
                                </span>
                                <h1 class="hero-title text-white mb-4" style="font-size: 56px; font-weight: 800; line-height: 1.1;">
                                    Discover Your <br>
                                    <span style="background: linear-gradient(90deg, #0496ff, #38ef7d); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Perfect Style</span>
                                </h1>
                                <p class="text-white-50 mb-4 lead">
                                    Explore our curated collection of premium products. Quality you can trust, prices you'll love.
                                </p>
                                <div class="d-flex gap-3 flex-wrap">
                                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-semibold" style="background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); border: none;">
                                        Shop Now <i class="fa-solid fa-arrow-right ms-2"></i>
                                    </a>
                                    <a href="{{ route('shop.index', ['on_sale' => 1]) }}" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-tag me-2"></i> View Offers
                                    </a>
                                </div>
                                <div class="hero-stats d-flex gap-5 mt-5">
                                    <div>
                                        <h3 class="text-white mb-0" style="font-weight: 700;">10K+</h3>
                                        <small class="text-white-50">Happy Customers</small>
                                    </div>
                                    <div>
                                        <h3 class="text-white mb-0" style="font-weight: 700;">5K+</h3>
                                        <small class="text-white-50">Products</small>
                                    </div>
                                    <div>
                                        <h3 class="text-white mb-0" style="font-weight: 700;">4.9</h3>
                                        <small class="text-white-50">
                                            <i class="fa-solid fa-star text-warning"></i> Rating
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 text-center d-none d-lg-block position-relative">
                                <div class="hero-image-wrapper">
                                    <div class="hero-circle" style="position: absolute; width: 450px; height: 450px; background: rgba(4, 150, 255, 0.1); border-radius: 50%; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=500&h=500&fit=crop" 
                                         alt="Shopping" 
                                         class="img-fluid rounded-4 shadow-lg position-relative"
                                         style="max-height: 450px; object-fit: cover;">
                                </div>
                                <!-- Floating Cards -->
                                <div class="floating-card" style="position: absolute; top: 20%; left: 10%; background: #fff; padding: 15px 20px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); animation: float 3s ease-in-out infinite;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 40px; height: 40px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa-solid fa-truck text-success"></i>
                                        </div>
                                        <div>
                                            <strong style="font-size: 14px;">Free Delivery</strong>
                                            <small class="d-block text-muted">On ৳5000+</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="floating-card" style="position: absolute; bottom: 15%; right: 5%; background: #fff; padding: 15px 20px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); animation: float 3s ease-in-out infinite 1.5s;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 40px; height: 40px; background: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa-solid fa-percent text-warning"></i>
                                        </div>
                                        <div>
                                            <strong style="font-size: 14px;">Up to 50%</strong>
                                            <small class="d-block text-muted">Discount</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <div class="hero-slide" style="background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); min-height: 600px;">
                    <div class="container h-100">
                        <div class="row align-items-center h-100" style="min-height: 600px;">
                            <div class="col-lg-6">
                                <span class="badge bg-danger mb-3 px-4 py-2 rounded-pill fw-semibold">
                                    <i class="fa-solid fa-bolt me-1"></i> Flash Sale
                                </span>
                                <h1 class="hero-title text-white mb-4" style="font-size: 56px; font-weight: 800; line-height: 1.1;">
                                    Mega Sale <br>Up to 
                                    <span style="color: #ffc107;">50% OFF</span>
                                </h1>
                                <p class="text-white-50 mb-4 lead">
                                    Limited time offer! Grab your favorite products at unbeatable prices before they're gone.
                                </p>
                                <a href="{{ route('shop.index', ['on_sale' => 1]) }}" class="btn btn-warning btn-lg px-5 py-3 rounded-pill fw-semibold text-dark">
                                    <i class="fa-solid fa-shopping-cart me-2"></i> Shop Sale Items
                                </a>
                            </div>
                            <div class="col-lg-6 text-center d-none d-lg-block">
                                <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=500&h=400&fit=crop" 
                                     alt="Sale" 
                                     class="img-fluid rounded-4 shadow-lg"
                                     style="max-height: 400px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <div class="hero-slide" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); min-height: 600px;">
                    <div class="container h-100">
                        <div class="row align-items-center h-100" style="min-height: 600px;">
                            <div class="col-lg-6">
                                <span class="badge bg-dark mb-3 px-4 py-2 rounded-pill fw-semibold">
                                    <i class="fa-solid fa-crown me-1"></i> Premium Quality
                                </span>
                                <h1 class="hero-title text-white mb-4" style="font-size: 56px; font-weight: 800; line-height: 1.1;">
                                    Quality Products <br>
                                    <span>Best Prices</span>
                                </h1>
                                <p class="text-white-50 mb-4 lead">
                                    We source only the finest products to ensure you get the best value for your money.
                                </p>
                                <a href="{{ route('shop.index') }}" class="btn btn-dark btn-lg px-5 py-3 rounded-pill fw-semibold">
                                    Explore Collection <i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                            <div class="col-lg-6 text-center d-none d-lg-block">
                                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=500&h=400&fit=crop" 
                                     alt="Quality" 
                                     class="img-fluid rounded-4 shadow-lg"
                                     style="max-height: 400px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navigation -->
        <div class="swiper-button-next text-white"></div>
        <div class="swiper-button-prev text-white"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5" style="background: #fff; margin-top: -60px; position: relative; z-index: 10;">
    <div class="container">
        <div class="features-wrapper bg-white rounded-4 shadow-lg p-4">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-item d-flex align-items-center gap-3 p-3 rounded-3 h-100" style="background: linear-gradient(135deg, rgba(4, 150, 255, 0.1) 0%, rgba(4, 150, 255, 0.05) 100%);">
                        <div class="feature-icon" style="width: 60px; height: 60px; background: #0496ff; border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-truck-fast text-white fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Free Shipping</h6>
                            <small class="text-muted">Orders over ৳5,000</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-item d-flex align-items-center gap-3 p-3 rounded-3 h-100" style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(40, 167, 69, 0.05) 100%);">
                        <div class="feature-icon" style="width: 60px; height: 60px; background: #28a745; border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-rotate-left text-white fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Easy Returns</h6>
                            <small class="text-muted">30-day return policy</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-item d-flex align-items-center gap-3 p-3 rounded-3 h-100" style="background: linear-gradient(135deg, rgba(111, 66, 193, 0.1) 0%, rgba(111, 66, 193, 0.05) 100%);">
                        <div class="feature-icon" style="width: 60px; height: 60px; background: #6f42c1; border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-shield-halved text-white fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Secure Payment</h6>
                            <small class="text-muted">100% protected</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-item d-flex align-items-center gap-3 p-3 rounded-3 h-100" style="background: linear-gradient(135deg, rgba(253, 126, 20, 0.1) 0%, rgba(253, 126, 20, 0.05) 100%);">
                        <div class="feature-icon" style="width: 60px; height: 60px; background: #fd7e14; border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-headset text-white fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">24/7 Support</h6>
                            <small class="text-muted">Dedicated help</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section py-5">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center mb-5">
            <div>
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-2">
                    <i class="fa-solid fa-th-large me-1"></i> Categories
                </span>
                <h2 class="section-title mb-0" style="font-size: 36px; font-weight: 700; color: #1a1a2e;">
                    Shop by Category
                </h2>
            </div>
            <a href="{{ route('shop.index') }}" class="btn btn-outline-primary rounded-pill px-4 d-none d-md-inline-flex align-items-center">
                View All <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
        
        <div class="categories-slider swiper" id="categoriesSlider">
            <div class="swiper-wrapper">
                @forelse($categories ?? [] as $category)
                <div class="swiper-slide">
                    <a href="{{ route('shop.index', ['category' => $category->slug ?? $category->name]) }}" class="category-card text-decoration-none d-block">
                        <div class="category-image position-relative overflow-hidden rounded-4" style="height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <i class="fa-solid fa-folder fa-3x text-muted"></i>
                                </div>
                            @endif
                            <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end" style="background: linear-gradient(to top, rgba(26,26,46,0.8) 0%, transparent 60%);">
                                <div class="p-3 w-100">
                                    <h5 class="text-white mb-1">{{ $category->name }}</h5>
                                    <small class="text-white-50">{{ $category->products_count ?? 0 }} Products</small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                @for($i = 1; $i <= 6; $i++)
                <div class="swiper-slide">
                    <a href="{{ route('shop.index') }}" class="category-card text-decoration-none d-block">
                        <div class="category-image position-relative overflow-hidden rounded-4" style="height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="fa-solid fa-folder fa-3x text-muted"></i>
                            </div>
                            <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end" style="background: linear-gradient(to top, rgba(26,26,46,0.8) 0%, transparent 60%);">
                                <div class="p-3 w-100">
                                    <h5 class="text-white mb-1">Category {{ $i }}</h5>
                                    <small class="text-white-50">0 Products</small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endfor
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="products-section py-5" style="background: linear-gradient(180deg, #f8f9fa 0%, #fff 100%);">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill mb-2">
                <i class="fa-solid fa-star me-1"></i> Featured
            </span>
            <h2 class="section-title" style="font-size: 36px; font-weight: 700; color: #1a1a2e;">
                Featured Products
            </h2>
            <p class="text-muted mt-2">Handpicked products just for you</p>
        </div>
        
        <div class="row g-4">
            @forelse($featuredProducts ?? [] as $product)
            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                @include('frontend.partials.product-card', ['product' => $product])
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="empty-icon mb-4" style="width: 120px; height: 120px; background: #f8f9fa; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-box-open fa-3x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-2">No Featured Products</h4>
                    <p class="text-muted mb-4">Check back soon for amazing products!</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary rounded-pill px-4">
                        Browse All Products
                    </a>
                </div>
            </div>
            @endforelse
        </div>
        
        @if(isset($featuredProducts) && count($featuredProducts) > 0)
        <div class="text-center mt-5">
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 py-3" style="background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%); border: none;">
                View All Products <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Promotional Banner -->
<section class="promo-section py-5">
    <div class="container">
        <div class="promo-banner position-relative overflow-hidden rounded-4" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
            <div class="row align-items-center">
                <div class="col-lg-7 p-5">
                    <span class="badge bg-danger px-3 py-2 rounded-pill mb-3">
                        <i class="fa-solid fa-gift me-1"></i> Special Offer
                    </span>
                    <h2 class="text-white mb-3" style="font-size: 42px; font-weight: 700;">
                        Get <span style="color: #ffc107;">20% OFF</span><br>Your First Order
                    </h2>
                    <p class="text-white-50 mb-4">
                        Subscribe to our newsletter and unlock exclusive discounts, early access to sales, and more!
                    </p>
                    <form action="#" method="POST" class="newsletter-form">
                        @csrf
                        <div class="d-flex gap-2 flex-wrap">
                            <input type="email" name="email" class="form-control form-control-lg rounded-pill" placeholder="Enter your email" style="max-width: 350px; padding: 15px 25px;">
                            <button type="submit" class="btn btn-warning btn-lg rounded-pill px-4 fw-semibold text-dark">
                                Subscribe <i class="fa-solid fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </form>
                    <p class="text-white-50 mt-3 small">
                        <i class="fa-solid fa-lock me-1"></i> We respect your privacy. Unsubscribe at any time.
                    </p>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="https://images.unsplash.com/photo-1557821552-17105176677c?w=500&h=400&fit=crop" 
                         alt="Newsletter" 
                         class="img-fluid rounded-end-4"
                         style="height: 100%; object-fit: cover;">
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="position-absolute" style="top: 20px; right: 40%; width: 100px; height: 100px; background: rgba(4, 150, 255, 0.2); border-radius: 50%; filter: blur(40px);"></div>
            <div class="position-absolute" style="bottom: 20px; left: 30%; width: 150px; height: 150px; background: rgba(255, 193, 7, 0.2); border-radius: 50%; filter: blur(60px);"></div>
        </div>
    </div>
</section>

<!-- New Arrivals Section -->
<section class="products-section py-5">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center mb-5">
            <div>
                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill mb-2">
                    <i class="fa-solid fa-sparkles me-1"></i> Just In
                </span>
                <h2 class="section-title mb-0" style="font-size: 36px; font-weight: 700; color: #1a1a2e;">
                    New Arrivals
                </h2>
            </div>
            <a href="{{ route('shop.index', ['sort' => 'newest']) }}" class="btn btn-outline-success rounded-pill px-4 d-none d-md-inline-flex align-items-center">
                View All <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @forelse($newArrivals ?? [] as $product)
            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                @include('frontend.partials.product-card', ['product' => $product])
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="empty-icon mb-4" style="width: 120px; height: 120px; background: #f8f9fa; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-clock fa-3x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-2">New Arrivals Coming Soon</h4>
                    <p class="text-muted">Stay tuned for exciting new products!</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Best Sellers Section -->
@if(isset($bestSellers) && count($bestSellers) > 0)
<section class="products-section py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center mb-5">
            <div>
                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill mb-2">
                    <i class="fa-solid fa-fire-flame-curved me-1"></i> Popular
                </span>
                <h2 class="section-title mb-0" style="font-size: 36px; font-weight: 700; color: #1a1a2e;">
                    Best Sellers
                </h2>
            </div>
            <a href="{{ route('shop.index', ['sort' => 'popularity']) }}" class="btn btn-outline-danger rounded-pill px-4 d-none d-md-inline-flex align-items-center">
                View All <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @foreach($bestSellers as $product)
            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                @include('frontend.partials.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Brands Section -->
@if(isset($brands) && count($brands) > 0)
<section class="brands-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill mb-2">
                <i class="fa-solid fa-award me-1"></i> Trusted Brands
            </span>
            <h2 class="section-title" style="font-size: 36px; font-weight: 700; color: #1a1a2e;">
                Shop Top Brands
            </h2>
        </div>
        
        <div class="brands-slider swiper" id="brandsSlider">
            <div class="swiper-wrapper align-items-center">
                @foreach($brands as $brand)
                <div class="swiper-slide">
                    <a href="{{ route('shop.index', ['brand' => $brand->slug ?? $brand->name]) }}" class="brand-card d-flex align-items-center justify-content-center p-4 bg-white rounded-3 shadow-sm" style="height: 100px; transition: all 0.3s;">
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" style="max-height: 60px; max-width: 120px; object-fit: contain;">
                        @else
                            <span class="fw-bold text-muted" style="font-size: 18px;">{{ $brand->name }}</span>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Testimonials Section -->
<section class="testimonials-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill mb-2">
                <i class="fa-solid fa-quote-left me-1"></i> Testimonials
            </span>
            <h2 class="section-title" style="font-size: 36px; font-weight: 700; color: #1a1a2e;">
                What Our Customers Say
            </h2>
        </div>
        
        <div class="testimonials-slider swiper" id="testimonialsSlider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="testimonial-card bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="d-flex gap-1 mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star text-warning"></i>
                            @endfor
                        </div>
                        <p class="mb-4 text-muted">"Amazing quality products and super fast delivery! The customer service team was incredibly helpful. I'll definitely be ordering again!"</p>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://i.pravatar.cc/60?img=1" alt="Customer" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">Sarah Johnson</h6>
                                <small class="text-success"><i class="fa-solid fa-check-circle me-1"></i> Verified Buyer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="d-flex gap-1 mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star text-warning"></i>
                            @endfor
                        </div>
                        <p class="mb-4 text-muted">"Great selection and competitive prices. The website is easy to navigate and checkout was smooth. Highly recommended for online shopping!"</p>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://i.pravatar.cc/60?img=3" alt="Customer" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">Michael Chen</h6>
                                <small class="text-success"><i class="fa-solid fa-check-circle me-1"></i> Verified Buyer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="d-flex gap-1 mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star text-warning"></i>
                            @endfor
                        </div>
                        <p class="mb-4 text-muted">"Love shopping here! Products are exactly as described and the packaging is always neat. Customer support is responsive and helpful."</p>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://i.pravatar.cc/60?img=5" alt="Customer" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">Emily Davis</h6>
                                <small class="text-success"><i class="fa-solid fa-check-circle me-1"></i> Verified Buyer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonial-card bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="d-flex gap-1 mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star text-warning"></i>
                            @endfor
                        </div>
                        <p class="mb-4 text-muted">"Best online shopping experience! Fast shipping, quality products, and excellent customer service. Will definitely recommend to friends."</p>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://i.pravatar.cc/60?img=8" alt="Customer" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">James Wilson</h6>
                                <small class="text-success"><i class="fa-solid fa-check-circle me-1"></i> Verified Buyer</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination mt-4"></div>
        </div>
    </div>
</section>

<!-- App Download Section -->
<section class="app-section py-5">
    <div class="container">
        <div class="app-banner rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);">
            <div class="row align-items-center">
                <div class="col-lg-6 p-5">
                    <span class="badge bg-white text-primary px-3 py-2 rounded-pill mb-3">
                        <i class="fa-solid fa-mobile-screen me-1"></i> Mobile App
                    </span>
                    <h2 class="text-white mb-3" style="font-size: 38px; font-weight: 700;">
                        Download Our App<br>For Better Experience
                    </h2>
                    <p class="text-white-50 mb-4">
                        Shop anytime, anywhere with our mobile app. Get exclusive app-only deals and track your orders in real-time.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#" class="btn btn-dark btn-lg rounded-pill px-4 d-flex align-items-center gap-2">
                            <i class="fa-brands fa-apple fa-lg"></i>
                            <div class="text-start">
                                <small class="d-block" style="font-size: 10px; line-height: 1;">Download on</small>
                                <span style="font-size: 14px; font-weight: 600;">App Store</span>
                            </div>
                        </a>
                        <a href="#" class="btn btn-dark btn-lg rounded-pill px-4 d-flex align-items-center gap-2">
                            <i class="fa-brands fa-google-play fa-lg"></i>
                            <div class="text-start">
                                <small class="d-block" style="font-size: 10px; line-height: 1;">Get it on</small>
                                <span style="font-size: 14px; font-weight: 600;">Google Play</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center d-none d-lg-block">
                    <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=400&h=500&fit=crop" 
                         alt="Mobile App" 
                         class="img-fluid"
                         style="max-height: 350px; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Hero Section */
    .hero-banner {
        position: relative;
    }
    
    .hero-slide {
        display: flex;
        align-items: center;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    /* Swiper Navigation */
    .swiper-button-next,
    .swiper-button-prev {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        backdrop-filter: blur(10px);
    }
    
    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 18px;
        font-weight: bold;
    }
    
    .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: rgba(255,255,255,0.5);
        opacity: 1;
    }
    
    .swiper-pagination-bullet-active {
        background: #fff;
        width: 30px;
        border-radius: 6px;
    }
    
    /* Category Cards */
    .category-card {
        transition: all 0.3s ease;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
    }
    
    .category-card:hover .category-image {
        transform: scale(1.05);
    }
    
    /* Brand Cards */
    .brand-card {
        filter: grayscale(100%);
        opacity: 0.7;
    }
    
    .brand-card:hover {
        filter: grayscale(0%);
        opacity: 1;
        transform: scale(1.05);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 36px !important;
        }
        
        .section-title {
            font-size: 28px !important;
        }
        
        .hero-stats {
            gap: 20px !important;
        }
        
        .features-wrapper {
            margin-top: 0 !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Hero Slider
    var heroSwiper = new Swiper('#heroSlider', {
        loop: true,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        }
    });
    
    // Categories Slider
    var categoriesSwiper = new Swiper('#categoriesSlider', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: { slidesPerView: 3 },
            768: { slidesPerView: 4 },
            992: { slidesPerView: 5 },
            1200: { slidesPerView: 6 }
        }
    });
    
    // Brands Slider
    var brandsSwiper = new Swiper('#brandsSlider', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: { slidesPerView: 3 },
            768: { slidesPerView: 4 },
            992: { slidesPerView: 5 },
            1200: { slidesPerView: 6 }
        }
    });
    
    // Testimonials Slider
    var testimonialsSwiper = new Swiper('#testimonialsSlider', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            768: { slidesPerView: 2 },
            992: { slidesPerView: 3 }
        }
    });
</script>
@endpush
