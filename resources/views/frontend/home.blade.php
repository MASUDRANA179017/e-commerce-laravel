@extends('layouts.frontend')

@section('title', 'Home - ' . config('app.name', 'E-Commerce'))

@section('content')
    <!-- Banner Section -->
    <section class="banner-two">
        <div class="banner-two__slider swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="banner-two__slider-single">
                        <div class="banner-two__slider-bg"
                            data-background="{{ asset('frontend/assets/images/web-banner-1.png') }}"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="banner-two__slider-content">
                                        <span class="sub-title-main text-white"><i class='bx bxs-tag'></i> New
                                            Arrival</span>
                                        <h1 class="title-animation text-white mb-0">Trendy Fashion Collection</h1>
                                        <p class="text-white mt-0 fs-13 text-white-50 mb-5">Discover the latest trends in
                                            clothing, accessories, and more. Shop now for exclusive deals!</p>
                                        <div class="d-flex gap-2 mt-4">
                                            <a href="{{ route('shop.index') }}" class="btn--primary p-2 px-5">Shop Now <i
                                                    class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="banner-two__slider-single">
                        <div class="banner-two__slider-bg"
                            data-background="{{ asset('frontend/assets/images/web-banner-2.png') }}"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="banner-two__slider-content">
                                        <span class="sub-title-main text-white"><i class='bx bxs-star'></i>
                                            Bestsellers</span>
                                        <h1 class="title-animation text-white mb-0">Electronics & Gadgets</h1>
                                        <p class="text-white mt-0 fs-13 text-white-50 mb-5">Find the best smartphones,
                                            laptops, and smart devices. Get flexible payment options!</p>
                                        <div class="d-flex gap-2 mt-4">
                                            <a href="{{ route('shop.index') }}" class="btn--primary p-2 px-5">Explore Now <i
                                                    class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="banner-two__slider-single">
                        <div class="banner-two__slider-bg"
                            data-background="{{ asset('frontend/assets/images/web-banner-3.png') }}"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="banner-two__slider-content">
                                        <span class="sub-title-main text-white"><i class='bx bxs-shopping-bags'></i> Special
                                            Offers</span>
                                        <h1 class="title-animation text-white mb-0">Home & Living Essentials</h1>
                                        <p class="text-white mt-0 fs-13 text-white-50 mb-5">High-quality furniture,
                                            kitchenware, and decor to brighten up your home. Free delivery on select items!
                                        </p>
                                        <div class="d-flex gap-2 mt-4">
                                            <a href="{{ route('shop.index') }}" class="btn--primary p-2 px-5">View Deals <i
                                                    class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-six-slide-dot swiper-pagination"></div>
    </section>

    <!-- Category Section -->
    @php
        $categories = \App\Models\Admin\Product\ProductCategory::take(4)->get();
    @endphp
    <section class="ministrie-eight-area">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="section-eight-wrapper mb-0" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <h6 class="sub-title-main"><i class="fa-solid fa-cart-shopping"></i> Our Top Picks</h6>
                    <h2 class="title-animation">Explore Our <span>Product Categories</span></h2>
                </div>
                <a href="{{ route('shop.index') }}" aria-label="all products" title="all products"
                    class="btn--primary p-2 px-5">
                    View All Products<i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="ministrie-eight-slide p-relative" data-aos="fade-up" data-aos-duration="1000"
                        data-aos-delay="200">
                        <div class="ministrie-eight-active swiper-container swiper mySwiper">
                            <div class="ministrie-eight-swiper-wrapper swiper-wrapper">
                                @foreach($categories as $index => $category)
                                    @php
                                        $categoryImages = [
                                            'frontend/assets/images/ministrie-eight-thumb1.jpg',
                                            'frontend/assets/images/ministrie-eight-thumb2.jpg',
                                            'frontend/assets/images/ministrie-eight-thumb3.jpg',
                                        ];
                                        $catImage = $category->thumb_url
                                            ? asset('storage/' . $category->thumb_url)
                                            : asset($categoryImages[$index % count($categoryImages)]);
                                    @endphp
                                    <div class="ministrie-eight-wrapper swiper-slide">
                                        <div class="ministrie-eight-thumb position-relative z-1">
                                            <img src="{{ $catImage }}" alt="{{ $category->name }}">
                                            <div class="ministrie-eight-wrap">
                                                <div class="ministrie-eight-button">
                                                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}"><i
                                                            class="fa-solid fa-arrow-right"></i></a>
                                                </div>
                                                <div class="ministrie-eight-content">
                                                    <h4 class="ministrie-eight-title"><a
                                                            href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                                    </h4>
                                                    <p class="ministrie-eight-paragraph">
                                                        {{ Str::limit($category->description ?? 'Explore our amazing collection of products in this category.', 100) }}
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-between pt-2">
                                                        <span
                                                            class="fw-700 title-lg text-white d-inline-flex align-items-center">Products</span>
                                                        <p class="title-lg fw-500 text-white w-60">
                                                            {{ $category->products_count ?? $category->products()->count() }}
                                                            items</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ministrie-eight-dot text-center m-auto mt-2"></div>
        </div>
    </section>

    <!-- Featured Products Section -->
    @php
        $featuredProducts = \App\Models\Product::with(['images', 'coverImage', 'categories', 'brand'])
            ->whereIn('status', ['active', 'Active', 1])
            ->where('featured', 1)
            ->take(8)
            ->get();

        $newArrivals = \App\Models\Product::with(['images', 'coverImage', 'categories', 'brand'])
            ->whereIn('status', ['active', 'Active', 1])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $topSelling = \App\Models\Product::with(['images', 'coverImage', 'categories', 'brand'])
            ->whereIn('status', ['active', 'Active', 1])
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();
    @endphp
    <section class="team ff-team difference-two">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="section-eight-wrapper mb-0" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <h6 class="sub-title-main"><i class="fa-solid fa-building"></i> Explore by Category</h6>
                    <h2 class="title-animation">Browse Our <span>Featured Products</span></h2>
                </div>
                <div class="difference-two__inner cta mt-0">
                    <div class="difference-two__inner-content">
                        <div class="difference-two__tab">
                            <div class="difference-two__tab-btns border-0">
                                <button class="difference-two__tab-btn fs-15 fw-600 p-2 px-4 active" data-target="#all"
                                    aria-label="all" title="all">
                                    <i class='bx bx-fullscreen bx-tada fs-15'></i> New Arrivals
                                </button>
                                <button class="difference-two__tab-btn fs-15 fw-600 p-2 px-4" data-target="#trending"
                                    aria-label="trending" title="trending">
                                    <i class='bx bxs-hot bx-flashing fs-15'></i> Trending
                                </button>
                                <button class="difference-two__tab-btn fs-15 fw-600 p-2 px-4" data-target="#topselling"
                                    aria-label="topselling" title="topselling">
                                    <i class='bx bxs-star bx-flashing fs-15'></i> Top Selling
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="difference-two__tab-content">
                    <!-- New Arrivals Tab -->
                    <div class="difference-two__content-single" id="all">
                        <div class="row">
                            @foreach($newArrivals as $product)
                                @include('frontend.partials.product-card-template', ['product' => $product])
                            @endforeach
                        </div>
                    </div>

                    <!-- Trending Tab -->
                    <div class="difference-two__content-single" id="trending">
                        <div class="row">
                            @foreach($featuredProducts as $product)
                                @include('frontend.partials.product-card-template', ['product' => $product])
                            @endforeach
                        </div>
                    </div>

                    <!-- Top Selling Tab -->
                    <div class="difference-two__content-single" id="topselling">
                        <div class="row">
                            @foreach($topSelling as $product)
                                @include('frontend.partials.product-card-template', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text-center mt-5">
                        <a href="{{ route('shop.index') }}" aria-label="all products" title="all products"
                            class="btn--primary p-2 px-5">
                            View All Products<i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Flash Sale / Countdown Section -->
    @if(isset($flashSale) && $flashSale)
        @php
            $isActiveFlash = $flashSale->status === 'active';
        @endphp
        <section id="countdownSection" class="countdown-eight-area"
            data-background="{{ $flashSale->banner_image ? asset('storage/' . $flashSale->banner_image) : asset('frontend/assets/images/shop/Ad-1.jpg') }}">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-8 col-lg-10 text-center">
                        <div class="countdown-eight-wrapper" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                            <div class="section-eight-wrapper">
                                <h6 class="section-eight-subtitle d-inline-block">
                                    {{ $isActiveFlash ? 'Limited Time Offer' : 'Coming Soon' }}
                                </h6>
                                <h2 class="section-eight-title char-animation text-white">
                                    {{ $isActiveFlash ? $flashSale->title : ($flashSale->title . ' Starts Soon!') }}
                                </h2>
                                @if($flashSale->description)
                                    <p class="text-white opacity-75 mt-2">{{ $flashSale->description }}</p>
                                @endif
                                @if($flashSale->discount_percent > 0)
                                    <div class="mt-3">
                                        <span class="badge bg-danger fs-5 p-2 px-3">Up to {{ $flashSale->discount_percent }}%
                                            OFF</span>
                                    </div>
                                @endif
                            </div>
                            <div class="countdown-eight-timer d-flex justify-content-center" id="countdown"
                                data-end-time="{{ $flashSale->end_time->timestamp * 1000 }}">
                                <ul>
                                    <li><span id="days">00</span>Days</li>
                                    <li><span id="hours">00</span>Hours</li>
                                    <li><span id="minutes">00</span>Minutes</li>
                                    <li><span id="seconds">00</span>Seconds</li>
                                </ul>
                            </div>
                            <a href="{{ route('flash-sale.index') }}" class="btn--primary p-2 px-5">
                                {{ $isActiveFlash ? 'Shop Flash Sale' : 'View Upcoming Deals' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- No active flash sale - show default banner -->
        <section id="countdownSection" class="countdown-eight-area"
            data-background="{{ asset('frontend/assets/images/shop/Ad-1.jpg') }}">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-8 col-lg-10 text-center">
                        <div class="countdown-eight-wrapper" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                            <div class="section-eight-wrapper">
                                <h6 class="section-eight-subtitle d-inline-block">Special Offers</h6>
                                <h2 class="section-eight-title char-animation text-white">Check Our Latest Deals!</h2>
                            </div>
                            <a href="{{ route('shop.index') }}" class="btn--primary p-2 px-5 mt-4">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Testimonial Section -->
    <section class="testimonial-six-area">
        <div class="container">
            <div class="row align-items-center testimonial-six-frist-row">
                <div class="col-xl-6 col-lg-6">
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="testimonial-six-slide position-relative overflow-hidden" data-aos="fade-up">
                                <div class="testimonial-six-active swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="testimonial-six-wrapper swiper-slide">
                                            <div class="testimonial-six-top">
                                                <div class="testimonial-six-top-content">
                                                    <h6>Customer Story</h6>
                                                    <div class="testimonial-six-review">
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                    </div>
                                                </div>
                                                <p class="testimonial-six-paragraph">
                                                    "I'm very happy with my purchase. The website was easy to navigate,
                                                    and the checkout process was simple. The delivery was incredibly fast
                                                    and the product was exactly as described. Great experience overall!"
                                                </p>
                                            </div>
                                            <div class="testimonial-six-bottom">
                                                <div class="testimonial-six-author">
                                                    <div class="testimonial-six-author-img">
                                                        <img src="https://randomuser.me/api/portraits/men/32.jpg"
                                                            alt="Customer">
                                                    </div>
                                                    <div class="testimonial-six-author-content">
                                                        <h6>John Doe</h6>
                                                        <p>Verified Buyer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testimonial-six-wrapper swiper-slide">
                                            <div class="testimonial-six-top">
                                                <div class="testimonial-six-top-content">
                                                    <h6>Customer Story</h6>
                                                    <div class="testimonial-six-review">
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                    </div>
                                                </div>
                                                <p class="testimonial-six-paragraph">
                                                    "The quality of the products is fantastic! Everything looks even better
                                                    in person than online. The size chart was accurate, and the
                                                    package arrived safely. I will definitely be a returning customer!"
                                                </p>
                                            </div>
                                            <div class="testimonial-six-bottom">
                                                <div class="testimonial-six-author">
                                                    <div class="testimonial-six-author-img">
                                                        <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                                            alt="Customer">
                                                    </div>
                                                    <div class="testimonial-six-author-content">
                                                        <h6>Sarah Smith</h6>
                                                        <p>Regular Customer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial-six-dot"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="testimonial-six-right" data-aos="fade-up">
                        <div class="section-six-wrapper mb-4">
                            <h6 class="sub-title-main">Testimonials</h6>
                            <h2 class="title-animation">Real Reviews from Our Customers</h2>
                            <p class="section-six-paragraph">
                                We pride ourselves on providing high-quality products and an exceptional shopping
                                experience. Hear directly from our satisfied customers about their purchases, fast
                                delivery, and excellent customer service.
                            </p>
                        </div>
                        <div class="testimonial-six-wrap">
                            <div class="testimonial-six-rating">
                                <h6>4.9/5 Rating</h6>
                                <p>Based on verified purchases & feedback.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="testimonial-six-down-content text-center">
                        <h3 class="testimonial-six-down-title">
                            Trusted by 10,000+ Happy Customers
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Blog Posts Section -->
    @if(isset($latestBlogs) && $latestBlogs->count() > 0)
    <section class="blog-eight-area pt-100 pb-70 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="section-eight-wrapper mb-50" data-aos="fade-up" data-aos-duration="1000">
                        <h6 class="section-eight-subtitle d-inline-block text-primary">From Our Blog</h6>
                        <h2 class="section-eight-title title-animation">Latest News & Articles</h2>
                        <p class="section-eight-paragraph mt-2">Stay updated with the latest trends, tips, and insights</p>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                @foreach($latestBlogs as $blog)
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="blog-eight-item mb-30 bg-white rounded-4 overflow-hidden shadow-sm h-100 d-flex flex-column" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ 200 + ($loop->index * 100) }}">
                            <div class="blog-eight-thumb position-relative overflow-hidden">
                                <a href="{{ route('blog.show', $blog->slug) }}" class="d-block w-100">
                                    @if($blog->featured_image)
                                        <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                             alt="{{ $blog->title }}" 
                                             class="w-100" 
                                             style="height: 250px; object-fit: cover; transition: transform 0.5s ease;">
                                    @else
                                        <div class="w-100 bg-secondary d-flex align-items-center justify-content-center" style="height: 250px;">
                                            <i class="bx bx-image text-white" style="font-size: 48px;"></i>
                                        </div>
                                    @endif
                                </a>
                                @if($blog->category)
                                    <span class="badge bg-primary position-absolute top-0 start-0 m-3">{{ $blog->category }}</span>
                                @endif
                            </div>
                            <div class="blog-eight-content p-4 d-flex flex-column flex-grow-1">
                                <div class="blog-meta mb-2 text-muted small">
                                    <span class="me-3"><i class="fa-regular fa-calendar me-1"></i> {{ $blog->formatted_date }}</span>
                                    <span><i class="fa-regular fa-clock me-1"></i> {{ $blog->reading_time }} min read</span>
                                </div>
                                <h4 class="mb-3">
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="text-dark text-decoration-none fw-bold hover-primary">
                                        {{ Str::limit($blog->title, 60) }}
                                    </a>
                                </h4>
                                @if($blog->excerpt)
                                    <p class="mb-4 text-muted">{{ Str::limit($blog->excerpt, 100) }}</p>
                                @endif
                                <div class="mt-auto">
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="btn--primary p-2 px-4 w-100 text-center">
                                        Read More <i class="fa-solid fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="row">
                <div class="col-12 text-center mt-4">
                    <a href="{{ route('blog.index') }}" class="btn btn-outline-primary rounded-pill px-5 py-2 fw-bold">
                        View All Articles <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- FAQ Section -->
    <section class="faq-eight-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="faq-eight-wrapper" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="accordion" id="general_faqaccordion">
                            <div class="accordion-item faq-eight-accordion-item">
                                <h2 class="accordion-header" id="order_one">
                                    <button class="accordion-button faq-eight-accordion-button" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#order__collapse_one" aria-expanded="true"
                                        aria-controls="order__collapse_one">
                                        1. How do I place an order?
                                    </button>
                                </h2>
                                <div id="order__collapse_one" class="accordion-collapse collapse show"
                                    aria-labelledby="order_one" data-bs-parent="#general_faqaccordion">
                                    <div class="accordion-body faq-eight-accordion-body">
                                        <p>Simply browse our products, add items to your cart, and proceed to checkout.
                                            Follow the steps to enter your shipping address and payment details.
                                            Once your order is confirmed, you'll receive a confirmation email.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item faq-eight-accordion-item">
                                <h2 class="accordion-header" id="order_two">
                                    <button class="accordion-button faq-eight-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#order__collapse_two"
                                        aria-expanded="false" aria-controls="order__collapse_two">
                                        2. What payment methods do you accept?
                                    </button>
                                </h2>
                                <div id="order__collapse_two" class="accordion-collapse collapse"
                                    aria-labelledby="order_two" data-bs-parent="#general_faqaccordion">
                                    <div class="accordion-body faq-eight-accordion-body">
                                        <p>We accept Cash on Delivery (COD), bKash, Nagad, and all major credit/debit cards.
                                            Choose your preferred payment method at checkout.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item faq-eight-accordion-item">
                                <h2 class="accordion-header" id="order_three">
                                    <button class="accordion-button collapsed faq-eight-accordion-button" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#order__collapse_three"
                                        aria-expanded="false" aria-controls="order__collapse_three">
                                        3. How long does delivery take?
                                    </button>
                                </h2>
                                <div id="order__collapse_three" class="accordion-collapse collapse"
                                    aria-labelledby="order_three" data-bs-parent="#general_faqaccordion">
                                    <div class="accordion-body faq-eight-accordion-body">
                                        <p>Delivery typically takes 2-5 business days within Dhaka and 5-7 business days
                                            for other areas in Bangladesh. Express delivery options are also available.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item faq-eight-accordion-item">
                                <h2 class="accordion-header" id="order_four">
                                    <button class="accordion-button collapsed faq-eight-accordion-button" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#order__collapse_four"
                                        aria-expanded="false" aria-controls="order__collapse_four">
                                        4. Can I return or exchange products?
                                    </button>
                                </h2>
                                <div id="order__collapse_four" class="accordion-collapse collapse"
                                    aria-labelledby="order_four" data-bs-parent="#general_faqaccordion">
                                    <div class="accordion-body faq-eight-accordion-body">
                                        <p>Yes! We offer a 7-day return policy for most products. Items must be unused and
                                            in original packaging. Contact our support team to initiate a return.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-10">
                    <div class="faq-eight-right" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="section-eight-wrapper mb-0">
                            <h6 class="sub-title-main">Question & Answer</h6>
                            <h2 class="title-animation">Frequently Asked Questions</h2>
                            <p class="section-eight-paragraph mb-2">
                                Have questions about shopping with us? Find answers to common queries about ordering,
                                shipping, payments, and returns. If you need more help, our customer support team
                                is always ready to assist you.
                            </p>
                            <div class="about-eight-button event-eight-btn d-inline-block mt-3 mb-4">
                                <a href="{{ route('frontend.contact') }}" class="btn--primary">Contact with Us <i
                                        class="bx bx-right-arrow-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Blog Posts Section -->
    @if($latestBlogs && $latestBlogs->count() > 0)
    <section class="py-5 bg-light">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <div class="section-eight-wrapper" data-aos="fade-up" data-aos-duration="1000">
                        <h6 class="sub-title-main"><i class="bx bxs-news"></i> From Our Blog</h6>
                        <h2 class="title-animation">Latest <span>News & Articles</span></h2>
                        <p class="mt-2 text-muted">Stay updated with the latest trends, tips, and insights</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                @foreach($latestBlogs as $blog)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <article class="blog-card h-100" data-aos="fade-up" data-aos-duration="1000">
                            <div class="blog-card__image">
                                <a href="{{ route('blog.show', $blog->slug) }}">
                                    @if($blog->featured_image)
                                        <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                             alt="{{ $blog->title }}" 
                                             class="w-100" 
                                             style="height: 250px; object-fit: cover;">
                                    @else
                                        <div class="w-100 bg-secondary d-flex align-items-center justify-content-center" style="height: 250px;">
                                            <i class="bx bx-image" style="font-size: 48px; color: #999;"></i>
                                        </div>
                                    @endif
                                </a>
                                @if($blog->category)
                                    <span class="blog-card__category">{{ $blog->category }}</span>
                                @endif
                            </div>
                            <div class="blog-card__content p-4">
                                <div class="blog-card__meta mb-2">
                                    <span><i class="bx bx-calendar"></i> {{ $blog->formatted_date }}</span>
                                    <span><i class="bx bx-time-five"></i> {{ $blog->reading_time }} min read</span>
                                </div>
                                <h4 class="blog-card__title">
                                    <a href="{{ route('blog.show', $blog->slug) }}">{{ Str::limit($blog->title, 60) }}</a>
                                </h4>
                                @if($blog->excerpt)
                                    <p class="blog-card__excerpt">{{ Str::limit($blog->excerpt, 100) }}</p>
                                @endif
                                <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-link p-0 text-primary">
                                    Read More <i class="bx bx-right-arrow-alt"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <a href="{{ route('blog.index') }}" class="btn--primary p-2 px-5">
                        View All Articles <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

@push('styles')
    <style>
        /* Fix countdown timer shaking - use fixed width and tabular numbers */
        .countdown-eight-timer ul li {
            min-width: 100px;
            width: 100px;
        }

        .countdown-eight-timer ul li span {
            font-variant-numeric: tabular-nums;
            font-feature-settings: "tnum";
            min-width: 80px;
            text-align: center;
            display: inline-block;
        }

        /* Blog Card Styles */
        .blog-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }
        .blog-card__image {
            position: relative;
            overflow: hidden;
        }
        .blog-card__image img {
            transition: transform 0.3s ease;
        }
        .blog-card:hover .blog-card__image img {
            transform: scale(1.05);
        }
        .blog-card__category {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary-color, #0496ff);
            color: #fff;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 2;
        }
        .blog-card__meta {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #666;
        }
        .blog-card__meta i {
            margin-right: 5px;
        }
        .blog-card__title {
            font-size: 18px;
            margin-bottom: 12px;
            line-height: 1.4;
        }
        .blog-card__title a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .blog-card__title a:hover {
            color: var(--primary-color, #0496ff);
        }
        .blog-card__excerpt {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
            line-height: 1.6;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Countdown Timer - Always counts down to flash sale end time from database
        (function () {
            const countdownEl = document.getElementById('countdown');
            if (!countdownEl) return;

            const endAttr = countdownEl.getAttribute('data-end-time');

            if (!endAttr) {
                return;
            }

            const endTime = parseInt(endAttr, 10);

            function updateCountdown() {
                const daysEl = document.getElementById('days');
                const hoursEl = document.getElementById('hours');
                const minutesEl = document.getElementById('minutes');
                const secondsEl = document.getElementById('seconds');

                if (!daysEl || !hoursEl || !minutesEl || !secondsEl) return;

                const now = Date.now();

                // Otherwise count down to end time
                const distanceToEnd = endTime - now;

                if (distanceToEnd <= 0) {
                    // Sale ended
                    daysEl.textContent = '00';
                    hoursEl.textContent = '00';
                    minutesEl.textContent = '00';
                    secondsEl.textContent = '00';
                    return;
                }

                const days = Math.floor(distanceToEnd / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distanceToEnd % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distanceToEnd % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distanceToEnd % (1000 * 60)) / 1000);

                daysEl.textContent = String(days).padStart(2, '0');
                hoursEl.textContent = String(hours).padStart(2, '0');
                minutesEl.textContent = String(minutes).padStart(2, '0');
                secondsEl.textContent = String(seconds).padStart(2, '0');
            }

            // Update every second
            setInterval(updateCountdown, 1000);
            updateCountdown();
        })();

        // Product Tabs Functionality
        (function () {
            const tabButtons = document.querySelectorAll('.difference-two__tab-btn');
            const tabContents = document.querySelectorAll('.difference-two__content-single');

            if (tabButtons.length === 0 || tabContents.length === 0) return;

            // Hide all tabs except the first one
            tabContents.forEach((content, index) => {
                if (index === 0) {
                    content.style.display = 'block';
                } else {
                    content.style.display = 'none';
                }
            });

            // Add click event to each tab button
            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');

                    // Remove active class from all buttons
                    tabButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.style.display = 'none';
                    });

                    // Show target tab content
                    const targetContent = document.querySelector(targetId);
                    if (targetContent) {
                        targetContent.style.display = 'block';
                    }
                });
            });
        })();
    </script>
@endpush
