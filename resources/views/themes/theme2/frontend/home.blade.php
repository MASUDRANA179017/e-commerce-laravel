@extends('themes.theme2.layouts.frontend')

@section('title', 'Home')

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper-slider.css') }}">
    <style>
        /* Ensure banner text is visible on top of images */
        .banner-two__slider-content h1,
        .banner-two__slider-content p,
        .banner-two__slider-content span {
            color: #fff !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        .banner-two__slider-bg {
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }
        .banner-two__slider-single {
            position: relative;
            height: 600px; /* Adjust height as needed */
            display: flex;
            align-items: center;
        }
    </style>
@endpush

<!-- Hero Section (Dynamic Slider like Theme 1) -->
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
                        <div class="banner-two__slider-bg" style="background-image: url('{{ asset('storage/' . $slider->image) }}');"></div>
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
                                                    <a href="{{ $slider->link }}" class="p-2 px-5 btn--primary btn-primary-red">Shop
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
                <!-- Fallback Slide (Theme 2 Style) -->
                <div class="swiper-slide">
                    <div class="banner-two__slider-single">
                        <div class="banner-two__slider-bg" style="background: linear-gradient(90deg, var(--primary-red) 0%, var(--dark-red) 100%);"></div>
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6 text-white">
                                    <h1 class="display-4 fw-bold mb-4" style="font-family: 'Hind Siliguri', sans-serif;">
                                        দেশি আচারের <br>
                                        স্বাদে মিশে আছে <br>
                                        ঐতিহ্য
                                    </h1>
                                </div>
                                <div class="col-md-6 text-center">
                                    <img src="https://placehold.co/600x400/transparent/white?text=Product+Banner" class="img-fluid" alt="Products">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="banner-six-slide-dot swiper-pagination"></div>
        <!-- Add Navigation Arrows if desired -->
        <!-- <div class="next-banner">Next</div> <div class="prev-banner">Prev</div> -->
    </div>
</section>

@push('scripts')
    <script src="{{ asset('frontend/js/swiper-slider.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var bannerOne = new Swiper(".banner-two__slider", {
                loop: true,
                speed: 2000,
                slidesPerView: 1,
                slidesPerGroup: 1,
                spaceBetween: 0,
                effect: "fade",
                fadeEffect: {
                  crossFade: true,
                },
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                pagination: {
                    el: ".banner-six-slide-dot",
                    clickable: true,
                },
            });
        });
    </script>
@endpush

<!-- Featured Products Section -->
@if($featuredProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-gold-brown fw-bold display-5">Featured Products</h2>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            @foreach($featuredProducts as $product)
                <div class="col">
                    @include('themes.theme2.frontend.partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Trending Products Section -->
@if($newArrivals->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-gold-brown fw-bold display-5">Trending Products</h2>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            @foreach($newArrivals as $product)
                <div class="col">
                    @include('themes.theme2.frontend.partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Best Selling Products Section -->
@if($bestSellers->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-gold-brown fw-bold display-5">Best Selling Products</h2>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            @foreach($bestSellers as $product)
                <div class="col">
                    @include('themes.theme2.frontend.partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Contact/Enquiry Section -->
<section class="py-5" style="background-color: #FFFDE7;">
    <div class="container">
        <div class="card border-0 shadow-sm" style="background-color: white; border-radius: 20px; overflow: hidden;">
            <div class="row g-0">
                <div class="col-lg-5 p-5 d-flex flex-column justify-content-center">
                    <h5 class="text-muted">We are here to help you</h5>
                    <h2 class="display-4 fw-bold mb-4">
                        <span class="text-gold-brown">Discuss</span> Your <br>
                        <span class="text-gold-brown">Thoughts</span> <br>
                        with us
                    </h2>
                    <p class="mb-4">Are you looking for top quality products? Then you are in the right place</p>

                    <div class="d-flex align-items-center mb-3">
                        <div class="btn btn-danger rounded-circle me-3 p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <small class="d-block text-muted">E-mail</small>
                            <strong>info@azeenagrofood.com</strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="btn btn-danger rounded-circle me-3 p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <small class="d-block text-muted">Mobile Number</small>
                            <strong>+880 9600 435 967</strong>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 p-5 bg-light">
                    <form>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Name</label>
                            <input type="text" class="form-control bg-white border-0 py-2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Mobile Number</label>
                            <input type="text" class="form-control bg-white border-0 py-2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Address</label>
                            <input type="text" class="form-control bg-white border-0 py-2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Message</label>
                            <textarea class="form-control bg-white border-0" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary-red px-5 py-2">
                            <i class="fas fa-paper-plane me-2"></i> Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quality Assurance Section -->
<section class="py-5 bg-white text-center">
    <div class="container">
        <h2 class="mb-5">We Never <span class="text-gold-brown fw-bold">Compromise</span> in Quality</h2>

        <div class="row justify-content-center g-4">
            <div class="col-6 col-md-2">
                <div class="p-3 border rounded h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-tint fa-3x mb-3 text-secondary"></i>
                    <small class="fw-bold">100% Pure</small>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 border rounded h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-flask fa-3x mb-3 text-secondary"></i>
                    <small class="fw-bold">No Chemicals</small>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 border rounded h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-certificate fa-3x mb-3 text-secondary"></i>
                    <small class="fw-bold">ISO Certified</small>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 border rounded h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-check-circle fa-3x mb-3 text-secondary"></i>
                    <small class="fw-bold">FDA Approved</small>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="p-3 border rounded h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-stamp fa-3x mb-3 text-secondary"></i>
                    <small class="fw-bold">BSTI Approved</small>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
