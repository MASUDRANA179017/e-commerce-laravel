@extends('layouts.frontend')

@section('title', ($flashSale->title ?? 'Flash Sale') . ' - ' . config('app.name', 'E-Commerce'))

@section('content')
    <!-- Flash Sale Banner / Countdown -->
    <section class="countdown-eight-area"
        data-background="{{ $flashSale->banner_image ? asset('storage/' . $flashSale->banner_image) : asset('frontend/assets/images/shop/Ad-1.jpg') }}">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6 col-lg-8">
                    <div class="countdown-eight-wrapper" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="section-eight-wrapper">
                            <h6 class="section-eight-subtitle d-inline-block">
                                {{ $flashSale->status === 'active' ? 'Limited Time Offer' : 'Coming Soon' }}
                            </h6>
                            <h2 class="section-eight-title char-animation text-white">
                                {{ $flashSale->status === 'active' ? $flashSale->title : ($flashSale->title . ' Starts Soon!') }}
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
                        <div class="countdown-eight-timer" id="flashSaleCountdown"
                            data-end-time="{{ $flashSale->end_time->timestamp * 1000 }}">
                            <ul>
                                <li><span id="fs-days">00</span>Days</li>
                                <li><span id="fs-hours">00</span>Hours</li>
                                <li><span id="fs-minutes">00</span>Minutes</li>
                                <li><span id="fs-seconds">00</span>Seconds</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Flash Sale Products Grid -->
    <section class="shop pt-0">
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
                                    <div class="text-center py-5">
                                        <i class="bx bx-package" style="font-size: 80px; color: #ddd;"></i>
                                        <h4 class="mt-3">No Flash Sale Products</h4>
                                        <p class="text-muted">Please check back later for new deals.</p>
                                        <a href="{{ route('shop.index') }}" class="btn--primary mt-3">Go to Shop</a>
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
        // Flash Sale page countdown
        (function () {
            const countdownEl = document.getElementById('flashSaleCountdown');
            if (!countdownEl) return;

            const endAttr = countdownEl.getAttribute('data-end-time');
            if (!endAttr) return;

            const endTime = parseInt(endAttr, 10);

            function updateFsCountdown() {
                const daysEl = document.getElementById('fs-days');
                const hoursEl = document.getElementById('fs-hours');
                const minutesEl = document.getElementById('fs-minutes');
                const secondsEl = document.getElementById('fs-seconds');

                if (!daysEl || !hoursEl || !minutesEl || !secondsEl) return;

                const now = Date.now();
                const distance = endTime - now;

                if (distance <= 0) {
                    daysEl.textContent = '00';
                    hoursEl.textContent = '00';
                    minutesEl.textContent = '00';
                    secondsEl.textContent = '00';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                daysEl.textContent = String(days).padStart(2, '0');
                hoursEl.textContent = String(hours).padStart(2, '0');
                minutesEl.textContent = String(minutes).padStart(2, '0');
                secondsEl.textContent = String(seconds).padStart(2, '0');
            }

            setInterval(updateFsCountdown, 1000);
            updateFsCountdown();
        })();
    </script>
@endpush