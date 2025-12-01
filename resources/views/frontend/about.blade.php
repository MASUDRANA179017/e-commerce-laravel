@extends('layouts.frontend')

@section('title', 'About Us - GrowUp E-Commerce')

@section('content')
<!-- Banner Section -->
<section class="common-banner">
    <div class="container">
        <div class="row">
            <div class="common-banner__content text-center">
                <span class="sub-title"><i class="fa-solid fa-building"></i> Know More</span>
                <h2 class="title-animation">About Us</h2>
                <nav aria-label="breadcrumb" class="mt-3">
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
<section class="about-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <div class="about-image position-relative">
                    <img src="https://via.placeholder.com/600x500?text=About+Us" alt="About GrowUp" class="img-fluid rounded-4 shadow">
                    <div class="experience-badge position-absolute bg-primary text-white p-4 rounded-4 shadow" style="bottom: -30px; right: -30px;">
                        <h2 class="mb-0" style="font-size: 48px; font-weight: 700;">5+</h2>
                        <p class="mb-0">Years of Excellence</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="sub-title-main"><i class="fa-solid fa-star"></i> Welcome to GrowUp</span>
                <h2 class="title-animation mb-4">Who <span>We Are</span></h2>
                <p class="lead mb-4">GrowUp E-Commerce is your trusted online shopping destination, offering a wide range of quality products at competitive prices.</p>
                <p class="text-muted mb-4">Founded in 2019, we've grown from a small startup to a leading e-commerce platform in Bangladesh. Our mission is to provide customers with a seamless shopping experience, exceptional customer service, and products that meet the highest standards of quality.</p>
                <p class="text-muted mb-4">We believe in building lasting relationships with our customers by delivering value, convenience, and trust in every transaction.</p>
                
                <div class="row mt-4">
                    <div class="col-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-check-circle text-primary fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0">Quality Products</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-check-circle text-primary fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0">Fast Delivery</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-check-circle text-primary fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0">24/7 Support</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-check-circle text-primary fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0">Easy Returns</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section py-5" style="background: linear-gradient(135deg, #0496ff 0%, #0380d9 100%);">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up">
                <div class="stat-item">
                    <h2 class="text-white mb-2" style="font-size: 48px; font-weight: 700;">10K+</h2>
                    <p class="text-white-50 mb-0">Happy Customers</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <h2 class="text-white mb-2" style="font-size: 48px; font-weight: 700;">5K+</h2>
                    <p class="text-white-50 mb-0">Products</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <h2 class="text-white mb-2" style="font-size: 48px; font-weight: 700;">50+</h2>
                    <p class="text-white-50 mb-0">Categories</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <h2 class="text-white mb-2" style="font-size: 48px; font-weight: 700;">99%</h2>
                    <p class="text-white-50 mb-0">Satisfaction Rate</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="mission-vision-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-up">
                <div class="mission-card bg-white p-5 rounded-4 shadow-sm h-100">
                    <div class="icon-box mb-4" style="width: 80px; height: 80px; background: rgba(4, 150, 255, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-bullseye fa-2x" style="color: #0496ff;"></i>
                    </div>
                    <h3 class="mb-3">Our Mission</h3>
                    <p class="text-muted mb-0">To provide customers with the best online shopping experience through quality products, competitive prices, and exceptional customer service. We aim to make online shopping convenient, secure, and enjoyable for everyone.</p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="vision-card bg-white p-5 rounded-4 shadow-sm h-100">
                    <div class="icon-box mb-4" style="width: 80px; height: 80px; background: rgba(4, 150, 255, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-eye fa-2x" style="color: #0496ff;"></i>
                    </div>
                    <h3 class="mb-3">Our Vision</h3>
                    <p class="text-muted mb-0">To become the most trusted and customer-centric e-commerce platform in Bangladesh, known for our commitment to quality, innovation, and sustainability. We envision a future where shopping is effortless and accessible to all.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sub-title-main"><i class="fa-solid fa-heart"></i> What We Believe</span>
            <h2 class="title-animation">Our Core <span>Values</span></h2>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
                <div class="value-card text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: rgba(4, 150, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-shield-halved fa-2x" style="color: #0496ff;"></i>
                    </div>
                    <h4 class="mb-3">Trust & Transparency</h4>
                    <p class="text-muted mb-0">We believe in honest business practices and transparent communication with our customers and partners.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: rgba(4, 150, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-gem fa-2x" style="color: #0496ff;"></i>
                    </div>
                    <h4 class="mb-3">Quality First</h4>
                    <p class="text-muted mb-0">We never compromise on quality. Every product we sell meets our high standards of excellence.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: rgba(4, 150, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-users fa-2x" style="color: #0496ff;"></i>
                    </div>
                    <h4 class="mb-3">Customer Centric</h4>
                    <p class="text-muted mb-0">Our customers are at the heart of everything we do. Your satisfaction is our priority.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: rgba(4, 150, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-lightbulb fa-2x" style="color: #0496ff;"></i>
                    </div>
                    <h4 class="mb-3">Innovation</h4>
                    <p class="text-muted mb-0">We continuously improve and innovate to provide the best shopping experience.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="value-card text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: rgba(4, 150, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-leaf fa-2x" style="color: #0496ff;"></i>
                    </div>
                    <h4 class="mb-3">Sustainability</h4>
                    <p class="text-muted mb-0">We are committed to sustainable practices and reducing our environmental impact.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="500">
                <div class="value-card text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: rgba(4, 150, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-handshake fa-2x" style="color: #0496ff;"></i>
                    </div>
                    <h4 class="mb-3">Community</h4>
                    <p class="text-muted mb-0">We support local businesses and give back to the communities we serve.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2 class="text-white mb-3" style="font-size: 36px; font-weight: 700;">Ready to Start Shopping?</h2>
                <p class="text-white-50 mb-0">Discover amazing products at unbeatable prices. Join thousands of satisfied customers today!</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('shop.index') }}" class="apece-primary-button">
                    Shop Now <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

