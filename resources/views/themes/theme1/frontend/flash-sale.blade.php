@extends('layouts.frontend')

@section('title', ($flashSale->title ?? 'Flash Sale') . ' - ' . config('app.name', 'E-Commerce'))

@section('content')
    <!-- Flash Sale Banner / Countdown -->
    @php
        $activeTheme = request()->get('theme_preview') ?? ($business_setup->active_theme ?? 'theme1');
        $flashSaleImg = \App\Models\SystemSetting::get('flash_sale_image_' . $activeTheme) ?: \App\Models\SystemSetting::get('flash_sale_image');
        $flashSaleBg = $flashSaleImg ? asset('storage/' . $flashSaleImg) : ($flashSale->banner_image ? asset('storage/' . $flashSale->banner_image) : asset('frontend/assets/images/shop/Ad-1.jpg'));
    @endphp
    <section class="countdown-eight-area"
            data-background="{{ $flashSaleBg }}">
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

    <!-- Flash Sale Products Grid -->
    <section class="pt-0 shop">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="shop__content">
                        <div class="shop__content-intro">
                            <div class="shop-intro__left">
                                <p>
                                    Showing
                                    <strong>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong>
                                    of {{ $products->total() }} Flash Sale Products
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            @forelse($products as $product)
                                @include('frontend.partials.product-card-template', ['product' => $product])
                            @empty
                                <div class="col-12">
                                    <div class="py-5 text-center">
                                        <i class="bx bx-package" style="font-size: 80px; color: #ddd;"></i>
                                        <h4 class="mt-3">No Flash Sale Products</h4>
                                        <p class="text-muted">Please check back later for new deals.</p>
                                        <a href="{{ route('shop.index') }}" class="mt-3 btn--primary">Go to Shop</a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        @if($products->hasPages())
                            <div class="row">
                                <div class="col-12">
                                    <div class="pagination-wrapper" data-aos="fade-up" data-aos-duration="1000">
                                        {{ $products->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Reuse countdown typography fix */
        #flashSaleCountdown ul li {
            min-width: 100px;
            width: 100px;
        }

        #flashSaleCountdown ul li span {
            font-variant-numeric: tabular-nums;
            font-feature-settings: "tnum";
            min-width: 80px;
            text-align: center;
            display: inline-block;
        }
    </style>
@endpush

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

