@extends('layouts.frontend')

@section('title', 'About Us - GrowUp E-Commerce')

@push('styles')
<style>
    /* Banner */
    .about-banner {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }
    
    .about-banner::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(4, 150, 255, 0.1);
        border-radius: 50%;
        top: -100px;
        right: -100px;
    }
    
    .about-banner::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(4, 150, 255, 0.05);
        border-radius: 50%;
        bottom: -100px;
        left: 10%;
    }
    
    /* About Image Section */
    .about-image-wrapper {
        position: relative;
    }
    
    .about-image-main {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }
    
    .about-image-main img {
        width: 100%;
        height: 500px;
        object-fit: cover;
    }
    
    .about-image-secondary {
        position: absolute;
        bottom: -40px;
        right: -40px;
        width: 200px;
        height: 200px;
        border-radius: 20px;
        overflow: hidden;
        border: 5px solid #fff;
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }
    
    .about-image-secondary img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .experience-badge {
        position: absolute;
        top: 30px;
        left: -30px;
        background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
        color: #fff;
        padding: 25px 30px;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(4, 150, 255, 0.4);
        z-index: 2;
    }
    
    .experience-badge h2 {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 5px;
        line-height: 1;
    }
    
    .experience-badge p {
        font-size: 14px;
        margin: 0;
        opacity: 0.9;
    }
    
    /* Feature List */
    .feature-check-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 0;
    }
    
    .feature-check-item .icon {
        width: 45px;
        height: 45px;
        background: rgba(4, 150, 255, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0496ff;
        flex-shrink: 0;
    }
    
    .feature-check-item h6 {
        margin: 0;
        font-weight: 600;
        color: #1a1a2e;
    }
    
    /* Stats Section */
    .stats-section {
        background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
        position: relative;
        overflow: hidden;
    }
    
    .stats-section::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></svg>');
        background-size: 50px;
    }
    
    .stat-card {
        text-align: center;
        padding: 30px;
    }
    
    .stat-card .number {
        font-size: 56px;
        font-weight: 800;
        color: #fff;
        line-height: 1;
        margin-bottom: 10px;
    }
    
    .stat-card .label {
        color: rgba(255,255,255,0.8);
        font-size: 16px;
    }
    
    /* Mission Vision Cards */
    .mv-card {
        background: #fff;
        border-radius: 24px;
        padding: 40px;
        height: 100%;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .mv-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .mv-card .icon-box {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(4, 150, 255, 0.1) 0%, rgba(4, 150, 255, 0.05) 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
    }
    
    .mv-card .icon-box i {
        font-size: 32px;
        color: #0496ff;
    }
    
    .mv-card h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 15px;
    }
    
    .mv-card p {
        color: #666;
        line-height: 1.8;
    }
    
    /* Value Cards */
    .value-card {
        background: #fff;
        border-radius: 20px;
        padding: 35px 30px;
        text-align: center;
        height: 100%;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(4, 150, 255, 0.15);
        border-color: rgba(4, 150, 255, 0.2);
    }
    
    .value-card .icon-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        box-shadow: 0 10px 25px rgba(4, 150, 255, 0.3);
    }
    
    .value-card .icon-circle i {
        font-size: 28px;
        color: #fff;
    }
    
    .value-card h4 {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 15px;
    }
    
    .value-card p {
        color: #666;
        font-size: 15px;
        line-height: 1.7;
    }
    
    /* Team Section */
    .team-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .team-card__image {
        position: relative;
        overflow: hidden;
    }
    
    .team-card__image img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .team-card:hover .team-card__image img {
        transform: scale(1.1);
    }
    
    .team-card__social {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        background: linear-gradient(to top, rgba(26,26,46,0.9) 0%, transparent 100%);
        display: flex;
        justify-content: center;
        gap: 12px;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }
    
    .team-card:hover .team-card__social {
        opacity: 1;
        transform: translateY(0);
    }
    
    .team-card__social a {
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1a1a2e;
        transition: all 0.3s ease;
    }
    
    .team-card__social a:hover {
        background: #0496ff;
        color: #fff;
    }
    
    .team-card__info {
        padding: 25px;
        text-align: center;
    }
    
    .team-card__info h5 {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 5px;
    }
    
    .team-card__info span {
        color: #0496ff;
        font-size: 14px;
        font-weight: 500;
    }
    
    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(4, 150, 255, 0.1);
        border-radius: 50%;
        top: -200px;
        right: -200px;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .about-image-secondary {
            width: 150px;
            height: 150px;
            right: -20px;
            bottom: -20px;
        }
        
        .experience-badge {
            left: 10px;
            top: 10px;
            padding: 20px;
        }
        
        .experience-badge h2 {
            font-size: 36px;
        }
    }
    
    @media (max-width: 767px) {
        .about-image-wrapper {
            margin-bottom: 80px;
        }
        
        .stat-card .number {
            font-size: 42px;
        }
    }
</style>
@endpush

@section('content')
<!-- Banner Section -->
<section class="about-banner">
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <span class="badge bg-primary-subtle text-primary px-4 py-2 rounded-pill mb-3">
                    <i class="fa-solid fa-building me-2"></i>About Our Company
                </span>
                <h1 class="text-white mb-4" style="font-size: 52px; font-weight: 800;">About Us</h1>
                <p class="text-white-50 lead mb-4">Discover who we are and what drives us to deliver exceptional shopping experiences</p>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5 py-lg-6" style="padding: 100px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <div class="about-image-wrapper">
                    <div class="about-image-main">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=600&fit=crop" 
                             alt="GrowUp Shopping Experience">
                    </div>
                    <div class="about-image-secondary">
                        <img src="https://images.unsplash.com/photo-1556742111-a301076d9d18?w=400&h=400&fit=crop" 
                             alt="Happy Customer">
                    </div>
                    <div class="experience-badge">
                        <h2>5+</h2>
                        <p>Years of Excellence</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">
                    <i class="fa-solid fa-star me-1"></i> Welcome to GrowUp
                </span>
                <h2 class="mb-4" style="font-size: 42px; font-weight: 800; color: #1a1a2e;">
                    Who <span style="color: #0496ff;">We Are</span>
                </h2>
                <p class="lead mb-4" style="color: #555;">
                    GrowUp E-Commerce is your trusted online shopping destination, offering a wide range of quality products at competitive prices.
                </p>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    Founded in 2019, we've grown from a small startup to a leading e-commerce platform in Bangladesh. Our mission is to provide customers with a seamless shopping experience, exceptional customer service, and products that meet the highest standards of quality.
                </p>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    We believe in building lasting relationships with our customers by delivering value, convenience, and trust in every transaction.
                </p>
                
                <div class="row mt-4">
                    <div class="col-sm-6">
                        <div class="feature-check-item">
                            <div class="icon">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h6>Quality Products</h6>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-check-item">
                            <div class="icon">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h6>Fast Delivery</h6>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-check-item">
                            <div class="icon">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h6>24/7 Support</h6>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-check-item">
                            <div class="icon">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h6>Easy Returns</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section py-5">
    <div class="container position-relative">
        <div class="row">
            <div class="col-6 col-lg-3" data-aos="fade-up">
                <div class="stat-card">
                    <div class="number">10K+</div>
                    <div class="label">Happy Customers</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="number">5K+</div>
                    <div class="label">Products</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="number">50+</div>
                    <div class="label">Categories</div>
                </div>
            </div>
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <div class="number">99%</div>
                    <div class="label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-5" style="background: #f8f9fa;">
    <div class="container" style="padding: 60px 0;">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-up">
                <div class="mv-card">
                    <div class="icon-box">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>To provide customers with the best online shopping experience through quality products, competitive prices, and exceptional customer service. We aim to make online shopping convenient, secure, and enjoyable for everyone.</p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="mv-card">
                    <div class="icon-box">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>To become the most trusted and customer-centric e-commerce platform in Bangladesh, known for our commitment to quality, innovation, and sustainability. We envision a future where shopping is effortless and accessible to all.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-5">
    <div class="container" style="padding: 60px 0;">
        <div class="text-center mb-5">
            <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill mb-3">
                <i class="fa-solid fa-heart me-1"></i> What We Believe
            </span>
            <h2 style="font-size: 42px; font-weight: 800; color: #1a1a2e;">
                Our Core <span style="color: #0496ff;">Values</span>
            </h2>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="value-card">
                    <div class="icon-circle">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h4>Trust & Transparency</h4>
                    <p>We believe in honest business practices and transparent communication with our customers and partners.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card">
                    <div class="icon-circle">
                        <i class="fa-solid fa-gem"></i>
                    </div>
                    <h4>Quality First</h4>
                    <p>We never compromise on quality. Every product we sell meets our high standards of excellence.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card">
                    <div class="icon-circle">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h4>Customer Centric</h4>
                    <p>Our customers are at the heart of everything we do. Your satisfaction is our priority.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card">
                    <div class="icon-circle">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <h4>Innovation</h4>
                    <p>We continuously improve and innovate to provide the best shopping experience.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="value-card">
                    <div class="icon-circle">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h4>Sustainability</h4>
                    <p>We are committed to sustainable practices and reducing our environmental impact.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="value-card">
                    <div class="icon-circle">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h4>Community</h4>
                    <p>We support local businesses and give back to the communities we serve.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5" style="background: #f8f9fa;">
    <div class="container" style="padding: 60px 0;">
        <div class="text-center mb-5">
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill mb-3">
                <i class="fa-solid fa-users me-1"></i> Meet Our Team
            </span>
            <h2 style="font-size: 42px; font-weight: 800; color: #1a1a2e;">
                The People <span style="color: #0496ff;">Behind GrowUp</span>
            </h2>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="team-card">
                    <div class="team-card__image">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&h=400&fit=crop" alt="CEO">
                        <div class="team-card__social">
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-solid fa-envelope"></i></a>
                        </div>
                    </div>
                    <div class="team-card__info">
                        <h5>John Anderson</h5>
                        <span>Founder & CEO</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="team-card">
                    <div class="team-card__image">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=400&fit=crop" alt="COO">
                        <div class="team-card__social">
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-solid fa-envelope"></i></a>
                        </div>
                    </div>
                    <div class="team-card__info">
                        <h5>Sarah Johnson</h5>
                        <span>Chief Operations Officer</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="team-card">
                    <div class="team-card__image">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&h=400&fit=crop" alt="CTO">
                        <div class="team-card__social">
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-solid fa-envelope"></i></a>
                        </div>
                    </div>
                    <div class="team-card__info">
                        <h5>Michael Chen</h5>
                        <span>Chief Technology Officer</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="team-card">
                    <div class="team-card__image">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=400&fit=crop" alt="CMO">
                        <div class="team-card__social">
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-solid fa-envelope"></i></a>
                        </div>
                    </div>
                    <div class="team-card__info">
                        <h5>Emily Davis</h5>
                        <span>Marketing Director</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5">
    <div class="container position-relative" style="padding: 60px 0;">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2 class="text-white mb-3" style="font-size: 38px; font-weight: 700;">Ready to Start Shopping?</h2>
                <p class="text-white-50 mb-0 lead">Discover amazing products at unbeatable prices. Join thousands of satisfied customers today!</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('shop.index') }}" class="btn btn-warning btn-lg rounded-pill px-5 py-3 fw-bold">
                    Shop Now <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

