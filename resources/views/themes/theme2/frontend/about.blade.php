@extends('themes.theme2.layouts.frontend')

@section('title', 'About Us')

@section('content')
@push('styles')
<style>
    .about-section {
        padding: 80px 0;
    }
    .about-header {
        text-align: center;
        margin-bottom: 3rem;
    }
    .text-gold {
        color: var(--gold-brown);
    }
    .brand-logos {
        padding: 50px 0;
        background-color: #f9f9f9;
    }
    .brand-logos img {
        height: 60px;
        object-fit: contain;
        margin: 0 20px;
        transition: transform 0.3s;
        filter: grayscale(100%);
        opacity: 0.7;
    }
    .brand-logos img:hover {
        transform: scale(1.1);
        filter: grayscale(0%);
        opacity: 1;
    }

    /* Curved Section */
    .curved-section-wrapper {
        position: relative;
        margin-top: 50px;
        padding-top: 50px; /* Space for the curve */
        overflow: hidden;
    }

    .curved-bg {
        background-color: var(--primary-red); /* Red color matching logo */
        color: white;
        padding-top: 80px;
        padding-bottom: 80px;
        position: relative;
    }

    /* The curve effect */
    .curve-shape {
        position: absolute;
        top: -1px;
        left: 0;
        width: 100%;
        height: 80px;
        background-color: #fff;
        border-bottom-left-radius: 50% 100%;
        border-bottom-right-radius: 50% 100%;
        z-index: 1;
    }

    .chairman-content {
        position: relative;
        z-index: 2;
    }

    .chairman-img-container {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        align-items: flex-end;
        justify-content: center;
    }

    .chairman-img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        border: 5px solid rgba(255,255,255,0.2);
    }

    .signature-block h4 {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 5px;
    }

    .about-image-main {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .about-feature-icon {
        width: 60px;
        height: 60px;
        background-color: #FFFDE7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #B71C1C;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .section-title-wrapper .subtitle {
        color: #E53935;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        display: block;
        margin-bottom: 10px;
    }

    .section-title-wrapper h2 {
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }
</style>
@endpush

<!-- Breadcrumb -->
<div class="breadcrumb-area" style="background-color: #f5f5f5; padding: 40px 0;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-2">About Us</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item active text-primary-red" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Main About Section -->
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="about-image-main position-relative">
                    <img src="{{ asset('frontend/assets/images/About-11.jpg') }}" class="img-fluid w-100" alt="About Azeen Agro" onerror="this.src='https://placehold.co/600x600?text=About+Image'">
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5">
                <div class="section-title-wrapper">
                    <span class="subtitle">Since 2020</span>
                    <h2>We Deliver The Best Quality <span class="text-primary-red">Agro Products</span></h2>
                </div>
                <p class="text-muted mb-4">
                    Azeen Agro Food is dedicated to bringing you the authentic taste of tradition. We specialize in premium quality pickles, spices, and agro-products that are processed with the utmost care and hygiene.
                </p>
                <p class="text-muted mb-4">
                    আমাদের লক্ষ্য হলো গ্রাহকদের হাতে সম্পূর্ণ প্রাকৃতিক ও কেমিক্যালমুক্ত খাবার পৌঁছে দেওয়া। আমরা বিশ্বাস করি সুস্থতাই সকল সুখের মূল।
                </p>

                <div class="row mt-4">
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div class="about-feature-icon me-3 flex-shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">100% Natural</h5>
                                <p class="text-muted fs-14 mb-0">No artificial preservatives or colors added.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div class="about-feature-icon me-3 flex-shrink-0">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Fast Delivery</h5>
                                <p class="text-muted fs-14 mb-0">We ensure quick and safe delivery to your doorstep.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('shop') }}" class="btn btn-primary-red px-5 py-3 rounded-pill mt-3">Discover Products</a>
            </div>
        </div>
    </div>
</section>

<!-- Curved Chairman Message Section -->
<section class="curved-section-wrapper">
    <div class="curve-shape"></div>
    <div class="curved-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="chairman-img-container">
                        <!-- Using About-12.jpg as placeholder for Chairman/Person -->
                        <img src="{{ asset('frontend/assets/images/About-12.jpg') }}" class="chairman-img" alt="Chairman" onerror="this.src='https://placehold.co/400x500?text=Chairman'">
                    </div>
                </div>
                <div class="col-lg-7 text-white">
                    <div class="chairman-content ps-lg-4">
                        <h5 class="text-gold mb-3 text-uppercase ls-2">Message from Chairman</h5>
                        <h2 class="display-6 fw-bold mb-4">Dedicated to Quality, <br>Committed to Health</h2>
                        <p class="mb-4 opacity-75 lead">
                            "At Azeen Agro Food, we don't just sell products; we share the heritage of our culinary culture. Every jar of pickle and every packet of spice carries the love and care of our mothers and grandmothers."
                        </p>
                        <p class="mb-5 opacity-75">
                            আমরা সর্বদা চেষ্টা করি আপনাদের জন্য সেরা মানের পণ্য নিশ্চিত করতে। আপনাদের সন্তুষ্টিই আমাদের অনুপ্রেরণা।
                        </p>

                        <div class="signature-block">
                            <h4 class="text-gold">Md. Ariful Islam</h4>
                            <p class="mb-0 opacity-75">Founder & Chairman</p>
                            <p class="mb-0 opacity-75 fs-14">Azeen Agro Food</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Brand Logos -->
<div class="brand-logos">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center flex-wrap align-items-center">
                    <!-- Placeholders for partner logos -->
                    <img src="{{ asset('frontend/assets/images/brand/brand-six-thumb1.png') }}" alt="Brand 1" onerror="this.style.display='none'">
                    <img src="{{ asset('frontend/assets/images/brand/brand-six-thumb2.png') }}" alt="Brand 2" onerror="this.style.display='none'">
                    <img src="{{ asset('frontend/assets/images/brand/brand-six-thumb3.png') }}" alt="Brand 3" onerror="this.style.display='none'">
                    <img src="{{ asset('frontend/assets/images/brand/brand-six-thumb4.png') }}" alt="Brand 4" onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
