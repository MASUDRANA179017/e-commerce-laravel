@extends('layouts.frontend')

@section('title', 'Home - GrowUp E-Commerce')

@section('content')
<!-- Hero Banner Section -->
<section class="banner-two">
    <div class="banner-two__slider swiper" id="heroSlider">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="banner-two__slider-single" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="container">
                        <div class="row align-items-center" style="min-height: 550px;">
                            <div class="col-lg-6">
                                <span class="badge bg-warning text-dark mb-3 px-3 py-2">New Collection</span>
                                <h1 class="text-white mb-4" style="font-size: 52px; font-weight: 700; line-height: 1.2;">
                                    Discover Amazing Products
                                </h1>
                                <p class="text-white-50 mb-4" style="font-size: 18px;">
                                    Shop the latest trends with unbeatable prices. Quality products delivered to your doorstep.
                                </p>
                                <a href="{{ route('shop.index') }}" class="apece-primary-button">
                                    Shop Now <i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                            <div class="col-lg-6 text-center d-none d-lg-block">
                                <img src="https://via.placeholder.com/500x400?text=Products" alt="Banner" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="banner-two__slider-single" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="container">
                        <div class="row align-items-center" style="min-height: 550px;">
                            <div class="col-lg-6">
                                <span class="badge bg-danger mb-3 px-3 py-2">Hot Sale</span>
                                <h1 class="text-white mb-4" style="font-size: 52px; font-weight: 700; line-height: 1.2;">
                                    Up to 50% Off
                                </h1>
                                <p class="text-white-50 mb-4" style="font-size: 18px;">
                                    Limited time offer! Don't miss out on our biggest sale of the season.
                                </p>
                                <a href="{{ route('shop.index') }}" class="apece-primary-button">
                                    Shop Sale <i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                            <div class="col-lg-6 text-center d-none d-lg-block">
                                <img src="https://via.placeholder.com/500x400?text=Sale" alt="Banner" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="banner-two__slider-single" style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);">
                    <div class="container">
                        <div class="row align-items-center" style="min-height: 550px;">
                            <div class="col-lg-6">
                                <span class="badge bg-light text-dark mb-3 px-3 py-2">Free Shipping</span>
                                <h1 class="text-white mb-4" style="font-size: 52px; font-weight: 700; line-height: 1.2;">
                                    Free Delivery on Orders $50+
                                </h1>
                                <p class="text-white-50 mb-4" style="font-size: 18px;">
                                    Enjoy free shipping on all orders over $50. Fast & secure delivery guaranteed.
                                </p>
                                <a href="{{ route('shop.index') }}" class="apece-primary-button">
                                    Start Shopping <i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                            <div class="col-lg-6 text-center d-none d-lg-block">
                                <img src="https://via.placeholder.com/500x400?text=Delivery" alt="Banner" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Features Section -->
<section class="feature-six-area position-relative z-2 py-5" style="margin-top: -50px;">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                <div class="feature-six-wrapper" data-aos="fade-up" data-aos-duration="1000">
                    <div class="feature-six-icon">
                        <span><i class='bx bx-package'></i></span>
                    </div>
                    <div class="feature-six-content">
                        <h4>Free Shipping</h4>
                        <p>On orders over $50</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                <div class="feature-six-wrapper" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="feature-six-icon">
                        <span><i class='bx bx-refresh'></i></span>
                    </div>
                    <div class="feature-six-content">
                        <h4>Easy Returns</h4>
                        <p>30-day return policy</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                <div class="feature-six-wrapper" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="feature-six-icon">
                        <span><i class='bx bx-lock-alt'></i></span>
                    </div>
                    <div class="feature-six-content">
                        <h4>Secure Payment</h4>
                        <p>100% secure checkout</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                <div class="feature-six-wrapper" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="feature-six-icon">
                        <span><i class='bx bx-support'></i></span>
                    </div>
                    <div class="feature-six-content">
                        <h4>24/7 Support</h4>
                        <p>Contact us anytime</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sub-title-main"><i class="fa-solid fa-th-large"></i> Browse Categories</span>
            <h2 class="title-animation">Shop by <span>Category</span></h2>
        </div>
        <div class="row">
            @forelse($categories ?? [] as $category)
            <div class="col-lg-3 col-md-4 col-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="category-card text-decoration-none d-block text-center p-4 bg-white rounded-4 shadow-sm" style="transition: all 0.3s ease;">
                    <div class="category-icon mb-3" style="width: 80px; height: 80px; margin: 0 auto; background: rgba(4, 150, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class='bx bx-category' style="font-size: 36px; color: #0496ff;"></i>
                    </div>
                    <h5 class="mb-1" style="color: #1a1a2e;">{{ $category->name }}</h5>
                    <small class="text-muted">{{ $category->products_count ?? 0 }} Products</small>
                </a>
            </div>
            @empty
            @for($i = 1; $i <= 8; $i++)
            <div class="col-lg-3 col-md-4 col-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">
                <a href="{{ route('shop.index') }}" class="category-card text-decoration-none d-block text-center p-4 bg-white rounded-4 shadow-sm" style="transition: all 0.3s ease;">
                    <div class="category-icon mb-3" style="width: 80px; height: 80px; margin: 0 auto; background: rgba(4, 150, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class='bx bx-category' style="font-size: 36px; color: #0496ff;"></i>
                    </div>
                    <h5 class="mb-1" style="color: #1a1a2e;">Category {{ $i }}</h5>
                    <small class="text-muted">0 Products</small>
                </a>
            </div>
            @endfor
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="products-section py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sub-title-main"><i class="fa-solid fa-star"></i> Our Products</span>
            <h2 class="title-animation">Featured <span>Products</span></h2>
        </div>
        <div class="row">
            @forelse($featuredProducts ?? [] as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                @include('frontend.partials.product-card', ['product' => $product])
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fa-solid fa-box-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No featured products available</h4>
                    <p class="text-muted">Check back soon for new arrivals!</p>
                    <a href="{{ route('shop.index') }}" class="btn--primary mt-3">Browse All Products</a>
                </div>
            </div>
            @endforelse
        </div>
        @if(isset($featuredProducts) && count($featuredProducts) > 0)
        <div class="text-center mt-4">
            <a href="{{ route('shop.index') }}" class="btn--primary px-5 py-3">
                View All Products <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Promotional Banner -->
<section class="promo-banner py-5" style="background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="text-white mb-2" style="font-size: 36px; font-weight: 700;">Get 20% Off Your First Order!</h2>
                <p class="text-white-50 mb-0">Subscribe to our newsletter and receive exclusive offers and updates.</p>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <form action="#" method="POST" class="d-flex">
                    @csrf
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" style="border-radius: 5px 0 0 5px; padding: 15px;">
                    <button type="submit" class="btn btn-dark" style="border-radius: 0 5px 5px 0; padding: 15px 25px;">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- New Arrivals Section -->
<section class="products-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sub-title-main"><i class="fa-solid fa-sparkles"></i> Just Arrived</span>
            <h2 class="title-animation">New <span>Arrivals</span></h2>
        </div>
        <div class="row">
            @forelse($newArrivals ?? [] as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                @include('frontend.partials.product-card', ['product' => $product])
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fa-solid fa-clock fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">New arrivals coming soon</h4>
                    <p class="text-muted">Stay tuned for exciting new products!</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sub-title-main"><i class="fa-solid fa-quote-left"></i> Testimonials</span>
            <h2 class="title-animation">What Our <span>Customers Say</span></h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
                <div class="testimonial-card bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="stars mb-3">
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                    </div>
                    <p class="mb-4">"Amazing quality products and super fast delivery! I'm impressed with the customer service. Will definitely order again."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://via.placeholder.com/50" alt="Customer" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">Sarah Johnson</h6>
                            <small class="text-muted">Verified Buyer</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="stars mb-3">
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                    </div>
                    <p class="mb-4">"Great selection and competitive prices. The website is easy to navigate and checkout was smooth. Highly recommended!"</p>
                    <div class="d-flex align-items-center">
                        <img src="https://via.placeholder.com/50" alt="Customer" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">Michael Chen</h6>
                            <small class="text-muted">Verified Buyer</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="stars mb-3">
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star text-warning"></i>
                        <i class="fa-solid fa-star-half-stroke text-warning"></i>
                    </div>
                    <p class="mb-4">"Love shopping here! The products are exactly as described and the packaging is always neat. Customer support is responsive."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://via.placeholder.com/50" alt="Customer" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">Emily Davis</h6>
                            <small class="text-muted">Verified Buyer</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Initialize Hero Slider
    var heroSwiper = new Swiper('#heroSlider', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        }
    });
</script>
@endpush

