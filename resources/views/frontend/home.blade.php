@extends('layouts.frontend')

@section('title', $business_setup->meta_title ?? 'Home - ' . config('app.name', 'Care ur Baby'))

@section('content')
    @php
        // Theme colors from customizer
        $themePrimary = $business_setup->theme_color_primary ?? '#0496ff';
        $themeSecondary = $business_setup->theme_color_secondary ?? '#1a1a2e';
        $themeAccent = $business_setup->theme_color_accent ?? '#f9c123';
        $themeButtonTextColor = '#ffffff';
        $themeSecondaryButtonBg = $business_setup->theme_secondary_button_bg ?? '#f5f5f5';
        $themeSecondaryButtonText = $business_setup->theme_secondary_button_text ?? '#333333';
        $themeLinkColor = $business_setup->theme_color_link ?? '#0496ff';
        $themeTextColor = $business_setup->theme_color_text ?? '#333333';
        $themeHeadingColor = $business_setup->theme_color_heading ?? '#1a1a2e';
        $themeBadgeColor = $business_setup->theme_color_badge ?? '#f9c123';
        $themeBorderColor = $business_setup->theme_color_border ?? '#e0e0e0';
        $themeInputFocusColor = $business_setup->theme_color_input_focus ?? '#0496ff';
        $themeSuccessColor = $business_setup->theme_color_success ?? '#28a745';
        $themeDangerColor = $business_setup->theme_color_danger ?? '#dc3545';
        $themeFont = $business_setup->theme_font_primary ?? 'Outfit';
    @endphp

    <style>
        /* Dynamic theme colors and fonts from customizer */
        :root {
            --home-primary: {{ $themePrimary }};
            --home-secondary: {{ $themeSecondary }};
            --home-accent: {{ $themeAccent }};
            --home-button-text: {{ $themeButtonTextColor }};
            --home-secondary-button-bg: {{ $themeSecondaryButtonBg }};
            --home-secondary-button-text: {{ $themeSecondaryButtonText }};
            --home-link-color: {{ $themeLinkColor }};
            --home-text-color: {{ $themeTextColor }};
            --home-heading-color: {{ $themeHeadingColor }};
            --home-badge-color: {{ $themeBadgeColor }};
            --home-border-color: {{ $themeBorderColor }};
            --home-input-focus-color: {{ $themeInputFocusColor }};
            --home-success-color: {{ $themeSuccessColor }};
            --home-danger-color: {{ $themeDangerColor }};
            --home-font: '{{ $themeFont }}', sans-serif;
        }

        /* Override all home page typography to use theme font */
        .home-section h1,
        .home-section h2,
        .home-section h3,
        .home-section h4,
        .home-section h5,
        .home-section h6,
        span {
            font-family: var(--home-font) !important;
            color: var(--home-primary) !important;
        }

        /* Make customer review images smaller in testimonial section */
        .testimonial-six-author-img img {
            width: 60px !important;
            height: 60px !important;
            object-fit: cover;
            border-radius: 50%;
        }

        /* Also make the fallback initial avatar div same size */
        .testimonial-six-author-img>div {
            width: 60px !important;
            height: 60px !important;
            font-size: 1.5rem !important;
        }

        .tag span {
            font-family: var(--home-font) !important;
            color: var(--home-secondary) !important;
        }

        .home-section h1,
        .home-section h2,
        .home-section h3,
        .home-section h4,
        .home-section h5,
        .home-section h6,
        .section-eight-title,
        .sub-title-main,
        .title-animation,
        .char-animation {
            font-family: var(--home-font) !important;
            color: var(--home-secondary) !important;
        }

        .title-animation {
            white-space: nowrap !important;
        }

        .title-animation span {
            display: inline-block !important;
            vertical-align: baseline !important;
        }

        .title-animation div {
            display: inline-block !important;
            vertical-align: baseline !important;
        }

        /* Home-only: use customizer primary color for subtitles */
        .sub-title-main {
            color: var(--home-primary) !important;
        }

        .sub-title-main i {
            color: var(--home-primary) !important;
        }

        /* Button styling - use customizer primary color and button text color */
        .btn--primary {
            background: var(--home-primary) !important;
            border-color: var(--home-primary) !important;
            color: var(--home-button-text) !important;
            transition: all 0.3s ease;
        }

        .btn--primary:hover {
            background: color-mix(in srgb, var(--home-primary) 85%, black) !important;
            border-color: color-mix(in srgb, var(--home-primary) 85%, black) !important;
            color: var(--home-button-text) !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(var(--home-primary), 0.3);
        }

        /* Secondary button styling */
        .btn--white,
        .select-btn-white,
        .create-btn-white {
            background: var(--home-secondary-button-bg) !important;
            color: var(--home-secondary-button-text) !important;
            border-color: var(--home-secondary-button-bg) !important;
        }

        .btn--white:hover,
        .select-btn-white:hover,
        .create-btn-white:hover {
            background: color-mix(in srgb, var(--home-secondary-button-bg) 85%, black) !important;
            color: var(--home-secondary-button-text) !important;
            border-color: color-mix(in srgb, var(--home-secondary-button-bg) 85%, black) !important;
        }

        /* Accent color for badges and highlights */
        .badge-accent {
            background: var(--home-accent) !important;
        }

        /* Heading colors */
        .section-eight-title,
        .section-title,
        .home-section h1,
        .home-section h2,
        .home-section h3,
        .home-section h4,
        .home-section h5,
        .home-section h6 {
            color: var(--home-primary) !important;
        }

        /* Body text color */
        .section-eight-subtitle {
            color: var(--home-button-text) !important;
        };
        .product-description,
        .product-text {
            color: var(--home-text-color) !important;
        }

        /* Link colors */
        .home-section a:not(.btn):not(.dropdown-item):not(.nav-link) {
            color: var(--home-link-color) !important;
        }

        .home-section a:not(.btn):not(.dropdown-item):not(.nav-link):hover {
            color: color-mix(in srgb, var(--home-link-color) 85%, black) !important;
        }

        /* Badge color */
        .badge,
        .qbit-badge {
            background-color: var(--home-badge-color) !important;
            color: #fff !important;
        }

        /* Border color */
        .home-section .border {
            border-color: var(--home-border-color) !important;
        }

        /* Success and danger colors */
        .alert-success,
        .badge-success {
            background-color: var(--home-success-color) !important;
            color: #fff !important;
        }

        .alert-danger,
        .badge-danger {
            background-color: var(--home-danger-color) !important;
            color: #fff !important;
        }

        /* Section title accent color */
        .section-eight-title span {
            color: var(--home-primary) !important;
        }

        /* faq section color  */
        .faq-eight-accordion-button {
            color: var(--home-primary) !important;
        }
        .faq-eight-accordion-button:hover {
            color: color-mix(in srgb, var(--home-secondary) 85%, black) !important;
        }


        /* Category card button - use primary color and button text color */
        .ministrie-eight-button a {
            background: var(--home-primary) !important;
            border-color: var(--home-primary) !important;
            color: var(--home-button-text) !important;
        }

        .ministrie-eight-button a:hover {
            background: color-mix(in srgb, var(--home-primary) 85%, black) !important;
            color: var(--home-button-text) !important;
        }

        /* Tab buttons - primary color active state */
        .difference-two__tab-btn.active {
            color: var(--home-button-text) !important;
            border-bottom-color: var(--home-primary) !important;
        }

        .difference-two__tab-btn:hover {
           color: var(--home-button-text) !important;
        }

        /* Flash sale badge */
        .badge.bg-danger {
            background: var(--home-primary) !important;
            color: rgba(var(--home-primary), 0.3) !important;
        }

        /* Countdown timer text */
        .countdown-eight-timer {
            font-family: var(--home-font) !important;
        }

        /* All section text use theme font */
        .ministrie-eight-title,
        .ministrie-eight-paragraph,
        .section-six-paragraph,
        .testimonial-six-top-content h6,
        .testimonial-six-wrapper p {
            font-family: var(--home-font) !important;
        }

        /* Hero banner: fixed height + hide bullets */
        .banner-two__slider,
        .banner-two__slider .swiper-slide,
        .banner-two__slider-single,
        .banner-two__slider-bg {
            min-height: 700px;
            height: 700px;
        }

        /* Fix header overlap - ensure banner starts below header */
        .header-area, .header-two, .header-six-area {
            position: relative !important;
            background: white !important;
            width: 100% !important;
            z-index: 999 !important;
        }

        /* Adjust main content spacing if needed */
        body {
            padding-top: 0 !important;
        }

        .banner-two__slider-single {
            display: flex;
            align-items: center;
        }

        .banner-two__slider-bg {
            background-size: cover !important; /* Show full image with aspect ratio */
            background-repeat: no-repeat;
            background-position: center;
            background-color: var(--home-secondary);
        }

        /* Banner content text uses theme font */
        .banner-two__slider-content {
            font-family: var(--home-font) !important;
        }

        /* Ecosystem store section - make images circular and centered */
        .ecosystem-card {
            height: auto !important;
            padding: 16px 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            overflow: visible !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .ecosystem-image {
            width: clamp(140px, 12vw, 240px) !important;
            height: clamp(140px, 12vw, 240px) !important;
            border-radius: 50% !important;
            background-size: cover !important;
            background-position: center !important;
            margin: 0 auto !important;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .ecosystem-card-title {
            position: static !important;
            margin-top: 12px !important;
            text-align: center !important;
            color: var(--home-primary) !important;
            font-weight: 600 !important;
        }

        .banner-two__slider-content h1 {
            color: #fff;
            font-family: var(--home-font) !important;
        }

        .banner-two__slider-content p {
            color: rgba(255, 255, 255, 0.8);
            font-family: var(--home-font) !important;
        }
    </style>
    <!-- Banner Section -->
    <section class="banner-two">
        <div class="banner-two__slider swiper">
            <div class="swiper-wrapper">
                @forelse($sliders as $slider)
                    @php
                        $hasContent =
                            !empty($slider->title) ||
                            !empty($slider->sub_title) ||
                            !empty($slider->description) ||
                            !empty($slider->link);
                    @endphp
                    <div class="swiper-slide">
                        <div class="banner-two__slider-single">
                            <div class="banner-two__slider-bg" data-background="{{ asset('storage/' . $slider->image) }}">
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-7">
                                        @if ($hasContent)
                                            <div class="banner-two__slider-content">
                                                @if (!empty($slider->sub_title))
                                                    <span class="text-white sub-title-main"><i class='bx bxs-tag'></i>
                                                        {{ $slider->sub_title }}</span>
                                                @endif
                                                @if (!empty($slider->title))
                                                    <h1 class="mb-0 text-white title-animation">{{ $slider->title }}</h1>
                                                @endif
                                                @if (!empty($slider->description))
                                                    <p class="mt-0 mb-5 text-white fs-13 text-white-50">
                                                        {{ $slider->description }}
                                                    </p>
                                                @endif
                                                @if (!empty($slider->link))
                                                    <div class="gap-2 mt-4 d-flex">
                                                        <a href="{{ $slider->link }}" class="p-2 px-5 btn--primary">Shop
                                                            Now <i class="fa-solid fa-arrow-right"></i></a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="banner-two__slider-single">
                            <div class="banner-two__slider-bg"
                                data-background="{{ asset('frontend/assets/images/web-banner-1.png') }}"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-7">
                                        <div class="banner-two__slider-content">
                                            <!-- subtitle intentionally removed per request -->
                                            <h1 class="mb-0 text-white title-animation">Trendy Fashion Collection</h1>
                                            <p class="mt-0 mb-5 text-white fs-13 text-white-50">Discover the latest trends
                                                in
                                                clothing, accessories, and more. Shop now for exclusive deals!</p>
                                            <div class="gap-2 mt-4 d-flex">
                                                <a href="{{ route('shop.index') }}" class="p-2 px-5 btn--primary">Shop Now
                                                    <i class="fa-solid fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="banner-six-slide-dot swiper-pagination"></div>
    </section>

    <!-- Ads Section -->
    @if($ads_sections->isNotEmpty())
    <section class="py-4 bg-white">
        <div class="container">
            <div class="row g-3">
                @foreach($ads_sections as $banner)
                <div class="col-12 col-md-4">
                    <a href="{{ $banner->link ?? '#' }}" class="overflow-hidden rounded d-block">
                        <img src="{{ asset('storage/' . $banner->image) }}" class="img-fluid w-100" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" alt="{{ $banner->title ?? 'Ad Banner' }}">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Category Section -->
    <section class="ministrie-eight-area">
        <style>
            /* Custom category card - blur only on text section */
            .ministrie-eight-wrap {
                background: transparent !important;
            }

            .ministrie-eight-content {
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(1px);
                /* -webkit-backdrop-filter: blur(10px); */
                border-radius: 15px;
                padding: 15px 20px;
                margin-top: auto;
            }

            .ministrie-eight-button {
                position: absolute;
                top: 15px;
                right: 15px;
            }
        </style>
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="mb-0 text-center section-eight-wrapper text-sm-center text-md-start text-lg-start"
                    data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <h6 class="sub-title-main"><i class="fa-solid fa-cart-shopping"></i> Our Top Picks</h6>
                    <h2 class="title-animation">Explore Our <span>Product Categories</span></h2>
                </div>
                <a href="{{ route('shop.index') }}" aria-label="all products" title="all products"
                    class="p-2 px-5 btn--primary d-none d-md-inline-block">
                    View All Products<i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="ministrie-eight-slide p-relative" data-aos="fade-up" data-aos-duration="1000"
                        data-aos-delay="200">
                        <div class="ministrie-eight-active swiper-container swiper">
                            <div class="ministrie-eight-swiper-wrapper swiper-wrapper">
                                @foreach ($categories as $index => $category)
                                    @php
                                        $categoryImages = [
                                            'frontend/assets/images/ministrie-eight-thumb1.jpg',
                                            'frontend/assets/images/ministrie-eight-thumb2.jpg',
                                            'frontend/assets/images/ministrie-eight-thumb3.jpg',
                                        ];
                                        $catImage = $category->thumb_url
                                            ? asset('storage/' . $category->thumb_url)
                                            : asset($categoryImages[$index % count($categoryImages)]);

                                        // Count products including all descendant categories (children, grandchildren, etc.)
                                        $getAllDescendantIds = function ($cat) use (&$getAllDescendantIds) {
                                            $ids = [$cat->id];
                                            foreach ($cat->children as $child) {
                                                $ids = array_merge($ids, $getAllDescendantIds($child));
                                            }
                                            return $ids;
                                        };
                                        $allCategoryIds = $getAllDescendantIds($category);
                                        $totalProducts = \App\Models\Product::whereHas('categories', function ($q) use (
                                            $allCategoryIds,
                                        ) {
                                            $q->whereIn('product_categories.id', $allCategoryIds);
                                        })->count();
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
                                                        {{ Str::limit($category->description ?? 'Explore Our Amazing Collection Of Products In This Category.', 100) }}
                                                    </p>
                                                    <div class="pt-2 d-flex align-items-center justify-content-between">
                                                        <span
                                                            class="text-white fw-700 title-lg d-inline-flex align-items-center">Products</span>
                                                        <p class="w-60 text-white title-lg fw-500">
                                                            {{ $totalProducts }} Items</p>
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
            <div class="m-auto mt-4 text-center ministrie-eight-dot"></div>
            <div class="mt-4 text-center d-md-none">
                <a href="{{ route('shop.index') }}" aria-label="all products" title="all products"
                    class="p-2 px-5 btn--primary d-md-none">
                    View All Products<i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="team ff-team difference-two">
        <div class="container-fluid">
            <div class="gap-3 d-flex flex-column flex-md-row align-items-center justify-content-between gap-md-0">

                <div class="mb-0 text-center section-eight-wrapper text-md-start" data-aos="fade-up"
                    data-aos-duration="1000" data-aos-delay="200">
                    <h6 class="sub-title-main"><i class="fa-solid fa-building"></i> Explore by Category</h6>
                    <h2 class="title-animation">Browse Our <span>Featured Products</span></h2>
                </div>
                <div class="mt-0 difference-two__inner cta">
                    <div class="difference-two__inner-content">
                        <div class="difference-two__tab">
                            <!-- Desktop: show all buttons in a row -->
                            <div class="border-0 difference-two__tab-btns d-none d-md-flex">
                                <button class="p-2 px-4 text-white difference-two__tab-btn fs-15 fw-600 active" data-target="#all"
                                    aria-label="all" title="all">
                                    <i class='bx bx-fullscreen bx-tada fs-15'></i> New Arrivals
                                </button>
                                <button class="p-2 px-4 text-white difference-two__tab-btn fs-15 fw-600" data-target="#trending"
                                    aria-label="trending" title="trending">
                                    <i class='bx bxs-hot bx-flashing fs-15'></i> Trending
                                </button>
                                <button class="p-2 px-4 text-white difference-two__tab-btn fs-15 fw-600" data-target="#topselling"
                                    aria-label="topselling" title="topselling">
                                    <i class='bx bxs-star bx-flashing fs-15'></i> Top Selling
                                </button>
                            </div>

                            <!-- Mobile: remove dropdown, keep buttons stacked -->
                            <div class="d-md-none w-100">
                                <div class="gap-2 border-0 difference-two__tab-btns d-flex flex-column">
                                    <button class="p-3 px-4 difference-two__tab-btn fs-15 fw-600 active w-100"
                                        data-target="#all" aria-label="all" title="all">
                                        <i class='bx bx-fullscreen bx-tada fs-15'></i> New Arrivals
                                    </button>
                                    <button class="p-3 px-4 difference-two__tab-btn fs-15 fw-600 w-100"
                                        data-target="#trending" aria-label="trending" title="trending">
                                        <i class='bx bxs-hot bx-flashing fs-15'></i> Trending
                                    </button>
                                    <button class="p-3 px-4 difference-two__tab-btn fs-15 fw-600 w-100"
                                        data-target="#topselling" aria-label="topselling" title="topselling">
                                        <i class='bx bxs-star bx-flashing fs-15'></i> Top Selling
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="difference-two__tab-content">
                    <!-- New Arrivals Tab -->
                    <div class="difference-two__content-single active" id="all">
                        <div class="row">
                            @foreach ($newArrivals->take(4) as $product)
                                @include('frontend.partials.product-card-template', [
                                    'product' => $product,
                                    'colClass' => 'col-12 col-md-6 col-lg-3 mb-4',
                                ])
                            @endforeach
                        </div>
                    </div>

                    <!-- Trending Tab -->
                    <div class="difference-two__content-single" id="trending">
                        <div class="row">
                            @foreach ($featuredProducts->take(4) as $product)
                                @include('frontend.partials.product-card-template', [
                                    'product' => $product,
                                    'colClass' => 'col-12 col-md-6 col-lg-3 mb-4',
                                ])
                            @endforeach
                        </div>
                    </div>

                    <!-- Top Selling Tab -->
                    <div class="difference-two__content-single" id="topselling">
                        <div class="row">
                            @foreach ($bestSellers->take(4) as $product)
                                @include('frontend.partials.product-card-template', [
                                    'product' => $product,
                                    'colClass' => 'col-12 col-md-6 col-lg-3 mb-4',
                                ])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mt-4 text-center">
                        <a href="{{ route('shop.index') }}" aria-label="view more products" title="view more products"
                            class="p-2 px-5 btn--primary d-none d-md-inline-block">
                            View More<i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Flash Sale / Countdown Section -->
    @if (isset($flashSale) && $flashSale)
        @php
            $isActiveFlash = $flashSale->status === 'active';
        @endphp
        <section class="countdown-eight-area"
            data-background="{{ \App\Models\SystemSetting::get('flash_sale_image') ? asset('storage/' . \App\Models\SystemSetting::get('flash_sale_image')) : ($flashSale->banner_image ? asset('storage/' . $flashSale->banner_image) : asset('frontend/assets/images/shop/Ad-1.jpg')) }}">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-12 col-sm-12 col-lg-8 col-xl-6">
                        <div class="countdown-eight-wrapper" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="200">
                            <div class="section-eight-wrapper">
                                <h6 class="section-eight-subtitle d-inline-block">
                                    {{ $flashSale->status === 'active' ? 'Limited Time Offer' : 'Coming Soon' }}
                                </h6>
                                <h2 class="text-white section-eight-title char-animation">
                                    {{ $flashSale->status === 'active' ? $flashSale->title : $flashSale->title . ' Starts Soon!' }}
                                </h2>
                                @if ($flashSale->description)
                                    <p class="mt-2 text-white opacity-75">{{ $flashSale->description }}</p>
                                @endif
                                @if ($flashSale->discount_percent > 0)
                                    <div class="mt-3">
                                        <span class="p-2 px-3 badge bg-danger fs-1">Up to
                                            {{ $flashSale->discount_percent }}%
                                            OFF</span>
                                    </div>
                                @endif
                            </div>
                            <!-- Mobile: centered single-row countdown -->
                            <div class="text-center countdown-eight-timer d-md-none" id="flashSaleCountdown"
                                data-end-time="{{ $flashSale->end_time->timestamp * 1000 }}">
                                <ul class="flex-nowrap mb-0 list-inline d-flex justify-content-center small fs-6">
                                    <li class="list-inline-item"><span id="fs-days" class="fs-2">00</span>D</li>
                                    <li class="list-inline-item"><span id="fs-hours" class="fs-2">00</span>H</li>
                                    <li class="list-inline-item"><span id="fs-minutes" class="fs-2">00</span>M</li>
                                    <li class="list-inline-item"><span id="fs-seconds" class="fs-2">00</span>S</li>
                                </ul>
                            </div>
                            <!-- Desktop: original multi-row countdown -->
                            <div class="countdown-eight-timer d-none d-md-block" id="flashSaleCountdownDesktop"
                                data-end-time="{{ $flashSale->end_time->timestamp * 1000 }}">
                                <ul>
                                    <li><span id="fs-days-desktop">00</span>Days</li>
                                    <li><span id="fs-hours-desktop">00</span>Hours</li>
                                    <li><span id="fs-minutes-desktop">00</span>Minutes</li>
                                    <li><span id="fs-seconds-desktop">00</span>Seconds</li>
                                </ul>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('flash-sale.index') }}" class="p-2 px-5 btn--primary d-inline-block">
                                    View Offers <i class="fa-solid fa-arrow-right ms-2"></i>
                                </a>
                            </div>
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
                    <div class="px-3 text-center col-12 col-sm-12 col-lg-8 col-xl-6">
                        <div class="countdown-eight-wrapper" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="200">
                            <div class="section-eight-wrapper">
                                <h6 class="text-white">Special Offers</h6>
                                <h2 class="title-animation"><span> Our Latest Deals!</span></h2>
                            </div>
                            <a href="{{ route('shop.index') }}" class="p-2 px-4 mt-3 btn--primary d-inline-block">Shop
                                Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endif

    <!-- Testimonial Section -->
    @php
        $featuredReviews = \App\Models\ProductReview::featured()
            ->with('product:id,title')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $avgRating = \App\Models\ProductReview::approved()->avg('rating') ?? 4.9;
        $totalReviews = \App\Models\ProductReview::approved()->count();
    @endphp
    <section class="testimonial-six-area">
        <div class="container">
            <div class="text-center col-xl-6 col-lg-6 d-block d-lg-none">
                <div class="testimonial-six-right" data-aos="fade-up">
                    <div class="mb-0 text-center section-eight-wrapper text-md-start" data-aos="fade-up"
                        data-aos-duration="1000" data-aos-delay="200">
                        <h6 class="sub-title-main"><i class="fa-solid fa-building"></i> Explore by Category</h6>
                        <h2 class="title-animation">Browse Our <span>Featured Products</span></h2>
                    </div>
                    <div class="mb-4 section-six-wrapper">
                        <h6 class="sub-title-main">Testimonials</h6>
                        <h2 class="title-animation">Real Reviews<span>from Our Customers</span></h2>
                        <p class="section-six-paragraph">
                            We pride ourselves on providing high-quality products and an exceptional shopping
                            experience. Hear directly from our satisfied customers about their purchases, fast
                            delivery, and excellent customer service.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="testimonial-six-rating">
                            <h6>{{ number_format($avgRating, 1) }}/5 Rating</h6>
                            <p class="text-center">Based on {{ $totalReviews }} verified purchases & feedback.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center testimonial-six-frist-row">
                <div class="col-xl-6 col-lg-6">
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="overflow-hidden testimonial-six-slide position-relative" data-aos="fade-up">
                                <div class="testimonial-six-active swiper-container">
                                    <div class="swiper-wrapper">
                                        @forelse($featuredReviews as $review)
                                            <div class="testimonial-six-wrapper swiper-slide">
                                                <div class="testimonial-six-top">
                                                    <div class="testimonial-six-top-content">
                                                        <h6>Customer Story</h6>
                                                        <div class="testimonial-six-review">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="fa-solid fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <p class="testimonial-six-paragraph">
                                                        "{{ $review->comment }}"
                                                    </p>
                                                </div>
                                                <div class="testimonial-six-bottom">
                                                    <div class="testimonial-six-author">
                                                        <div class="testimonial-six-author-img">
                                                            @if ($review->reviewer_image)
                                                                <img src="{{ asset('storage/' . $review->reviewer_image) }}"
                                                                    alt="{{ $review->reviewer_name }}">
                                                            @else
                                                                <div class="text-white d-flex align-items-center justify-content-center bg-primary rounded-circle"
                                                                    style="width: 60px; height: 60px; font-size: 1.5rem;">
                                                                    {{ strtoupper(substr($review->reviewer_name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="testimonial-six-author-content">
                                                            <h6>{{ $review->reviewer_name }}</h6>
                                                            <p>{{ $review->verified_purchase ? 'Verified Buyer' : 'Customer' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <!-- Default testimonials when no featured reviews -->
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
                                                        and the checkout process was simple. The delivery was incredibly
                                                        fast
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
                                                        "The quality of the products is fantastic! Everything looks even
                                                        better
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
                                        @endforelse
                                    </div>
                                </div>
                                <div class="testimonial-six-dot"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 d-none d-lg-block">
                    <div class="testimonial-six-right" data-aos="fade-up">
                        <div class="mb-4 section-six-wrapper">
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
                                <h6>{{ number_format($avgRating, 1) }}/5 Rating</h6>
                                <p>Based on {{ $totalReviews > 0 ? $totalReviews : 'verified purchases &' }} feedback.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    @if (!empty($promotional_banners) && $promotional_banners->count() > 0)
                        <div class="text-center testimonial-six-down-content">
                            <h3 class="testimonial-six-down-title">
                                Trusted by 10,000+ Happy Customers
                            </h3>
                        </div>
                    @endif
                </div>
                <div class="col-xl-12">
                    @if (isset($promotional_banners) && $promotional_banners->count() > 0)
                        <div id="partnersSlider" class="mt-4 swiper partners-slider">
                            <div class="mb-4 swiper-wrapper">
                                @foreach ($promotional_banners as $banner)
                                    @if (!empty($banner->image))
                                        <div class="swiper-slide">
                                            @php
                                                $hasTitle = !empty($banner->title);
                                            @endphp
                                            @if ($banner->link)
                                                <a href="{{ $banner->link }}" target="_blank" class="d-block">
                                                    <img src="{{ asset('storage/' . $banner->image) }}"
                                                        @if($hasTitle) alt="{{ $banner->title }}" title="{{ $banner->title }}" @else alt="Partner" @endif
                                                        class="mx-auto rounded shadow-sm img-fluid"
                                                        style="width: auto; object-fit: contain;">
                                                </a>
                                            @else
                                                <img src="{{ asset('storage/' . $banner->image) }}"
                                                    @if($hasTitle) alt="{{ $banner->title }}" title="{{ $banner->title }}" @else alt="Partner" @endif
                                                    class="mx-auto rounded shadow-sm img-fluid"
                                                    style="width: auto; object-fit: contain;">
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="mt-20 mb-8 swiper-pagination partners-pagination"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if (isset($store_sections) && $store_sections->count() > 0)
        <section class="py-5 ecosystem-section">
            <div class="container">
                <div class="mb-4 row justify-content-center">
                    <div class="text-center col-lg-8">
                        <h6 class="sub-title-main"><i class="fa-solid fa-layer-group"></i> Partners</h6>
                        <h2 class="title-animation">
                            Part Of <span>{{ config('app.name', 'E-Commerce') }}</span>
                        </h2>
                    </div>
                </div>
                <div class="position-relative">
                    <div id="storeSectionSlider" class="swiper ecosystem-slider">
                        <div class="swiper-wrapper">
                            @foreach ($store_sections as $section)
                                <div class="swiper-slide">
                                    <div class="ecosystem-card">
                                        @if ($section->link)
                                            <a href="{{ $section->link }}" class="stretched-link"></a>
                                        @endif
                                        <div class="ecosystem-image"
                                            style="background-image: url('{{ asset('storage/' . $section->image) }}');">
                                        </div>
                                        @if ($section->title)
                                            <div class="ecosystem-card-title">{{ $section->title }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="ecosystem-nav ecosystem-prev" aria-label="Previous">
                        <i class="fa-solid fa-chevron-left"></i>
                    </div>
                    <div class="ecosystem-nav ecosystem-next" aria-label="Next">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </div>
            </div>
        </section>
    @endif


    <!-- FAQ Section -->
    <section class="faq-eight-area">
        <div class="container">
            <div class="text-center col-xl-6 col-lg-10 d-block d-xl-none">
                <div class="faq-eight-right" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="mb-0 section-eight-wrapper">
                        <h6 class="sub-title-main">Question & Answer</h6>
                        <h2 class="title-animation">Frequently Asked Questions</h2>
                        <p class="mb-2 section-eight-paragraph">
                            Have questions about shopping with us? Find answers to common queries about ordering,
                            shipping, payments, and returns. If you need more help, our customer support team
                            is always ready to assist you.
                        </p>

                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="faq-eight-wrapper" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="accordion" id="general_faqaccordion">
                            <div class="accordion-item faq-eight-accordion-item">
                                <h2 class="accordion-header" id="order_one">
                                    <button class="accordion-button faq-eight-accordion-button" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#order__collapse_one"
                                        aria-expanded="true" aria-controls="order__collapse_one">
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
                <div class="col-xl-6 col-lg-10 d-none d-xl-block">
                    <div class="faq-eight-right" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="mb-0 section-eight-wrapper">
                            <h6 class="sub-title-main">Question & Answer</h6>
                            <h2 class="title-animation">Frequently Asked Questions</h2>
                            <p class="mb-2 section-eight-paragraph">
                                Have questions about shopping with us? Find answers to common queries about ordering,
                                shipping, payments, and returns. If you need more help, our customer support team
                                is always ready to assist you.
                            </p>
                            <div class="mt-3 mb-4 d-inline-block">
                                <a href="{{ route('frontend.contact') }}"
                                    class="p-2 px-5 btn--primary d-none d-md-inline-block">Contact with Us <i
                                        class="bx bx-right-arrow-alt"></i>
                                </a>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Blog Posts Section -->
    @if ($latestBlogs && $latestBlogs->count() > 0)
        <section class="py-5 blog fc-blog bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="text-center section-six-wrapper" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="200">
                            <h6 class="sub-title-main"><i class="fa-solid fa-user-graduate"></i>News &amp; Blog</h6>
                            <h2 class="mb-5 title-animation">
                                Latest Articles &amp; News
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($latestBlogs as $blog)
                        <div class="col-12 col-lg-6 col-xl-4">
                            <div class="m-3 blog__single-wrapper" data-aos="fade-up" data-aos-duration="1000">
                                <div class="blog__single van-tilt">
                                    <div class="blog__single-thumb">
                                        <a href="{{ route('blog.show', $blog->slug) }}">
                                            @if ($blog->featured_image)
                                                <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                                    alt="{{ $blog->title }}" class="rounded img-fluid w-100"
                                                    style="height: 220px; object-fit: cover;" loading="lazy">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/event-1.jpg') }}"
                                                    alt="{{ $blog->title }}" class="rounded img-fluid w-100"
                                                    style="height: 220px; object-fit: cover;" loading="lazy">
                                            @endif
                                        </a>
                                        <div class="tag flex-column" style="color: var(--home-text-color);">
                                            <span>{{ \Carbon\Carbon::parse($blog->created_at)->format('M') }}</span>
                                            <span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d') }} </span>
                                            <span> {{ \Carbon\Carbon::parse($blog->created_at)->format('y') }}</span>
                                        </div>
                                    </div>
                                    <div class="px-3 py-4 blog__single-inner">
                                        <div class="blog__single-content">
                                            <div class="mb-0 blog__single-meta">
                                                <p><i class="icon-user"></i> {{ $blog->author->name ?? 'Admin' }}</p>
                                            </div>
                                            <h6 class="blog-title">
                                                <a
                                                    href="{{ route('blog.show', $blog->slug) }}">{{ Str::limit($blog->title, 60) }}</a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection


@push('scripts')
    <script>
        (function() {
            const elSingle = document.getElementById('countdown');
            const elMobile = document.getElementById('flashSaleCountdown');
            const elDesktop = document.getElementById('flashSaleCountdownDesktop');
            const endAttr =
                (elMobile && elMobile.getAttribute('data-end-time')) ||
                (elDesktop && elDesktop.getAttribute('data-end-time')) ||
                (elSingle && elSingle.getAttribute('data-end-time'));
            if (!endAttr) return;
            const endTime = parseInt(endAttr, 10);

            function setTexts(days, hours, minutes, seconds) {
                const sets = [
                    ['days', 'hours', 'minutes', 'seconds'],
                    ['fs-days', 'fs-hours', 'fs-minutes', 'fs-seconds'],
                    ['fs-days-desktop', 'fs-hours-desktop', 'fs-minutes-desktop', 'fs-seconds-desktop']
                ];
                sets.forEach(ids => {
                    const d = document.getElementById(ids[0]);
                    if (d) d.textContent = String(days).padStart(2, '0');
                    const h = document.getElementById(ids[1]);
                    if (h) h.textContent = String(hours).padStart(2, '0');
                    const m = document.getElementById(ids[2]);
                    if (m) m.textContent = String(minutes).padStart(2, '0');
                    const s = document.getElementById(ids[3]);
                    if (s) s.textContent = String(seconds).padStart(2, '0');
                });
            }

            function updateCountdown() {
                const now = Date.now();
                const distanceToEnd = endTime - now;
                if (distanceToEnd <= 0) {
                    setTexts(0, 0, 0, 0);
                    return;
                }
                const days = Math.floor(distanceToEnd / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distanceToEnd % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distanceToEnd % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distanceToEnd % (1000 * 60)) / 1000);
                setTexts(days, hours, minutes, seconds);
            }
            setInterval(updateCountdown, 1000);
            updateCountdown();
        })();

        // Product Tabs Functionality
        (function() {
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
                button.addEventListener('click', function() {
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

        // Partners Slider Initialization
        @if (isset($promotional_banners) && $promotional_banners->count() > 0)
            document.addEventListener('DOMContentLoaded', function() {
                const partnersSlider = new Swiper('#partnersSlider', {
                    loop: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    slidesPerView: 1,
                    slidesPerGroup: 1,
                    spaceBetween: 20,
                    pagination: {
                        el: '.partners-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        576: {
                            slidesPerView: 2,
                        },
                        768: {
                            slidesPerView: 3,
                        },
                        1024: {
                            slidesPerView: 4,
                        }
                    }
                });
            });
        @endif

        // Store Sections Slider
        @if (isset($store_sections) && $store_sections->count() > 0)
            document.addEventListener('DOMContentLoaded', function() {
                const slidesCount = document.querySelectorAll('#storeSectionSlider .swiper-slide').length;
                const perView576 = Math.min(3, slidesCount);
                const perView768 = Math.min(4, slidesCount);
                const perView1024 = Math.min(5, slidesCount);
                const loopEnabled = slidesCount > 1;

                const storeSectionSlider = new Swiper('#storeSectionSlider', {
                    loop: loopEnabled,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    slidesPerView: 1.2,
                    spaceBetween: 20,
                    centeredSlides: false,
                    navigation: {
                        nextEl: '.ecosystem-next',
                        prevEl: '.ecosystem-prev',
                    },
                    breakpoints: {
                        576: { slidesPerView: perView576 },
                        768: { slidesPerView: perView768 },
                        1024: { slidesPerView: perView1024 }
                    }
                });
            });
        @endif
    </script>
@endpush
