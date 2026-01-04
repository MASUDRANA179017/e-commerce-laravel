@extends('layouts.frontend')

@section('title', 'FAQ section - GrowUp E-Commerce')

@section('content')
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
<!-- FAQ Section -->
<section class="faq-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sub-title-main"><i class="fa-solid fa-question-circle"></i> FAQ</span>
            <h2 class="title-animation">Frequently Asked <span>Questions</span></h2>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm" data-aos="fade-up">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How can I track my order?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Once your order is shipped, you will receive an email with a tracking number. You can use this number to track your order on our website or the carrier's website.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                What is your return policy?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer a 30-day return policy for most items. Products must be in their original condition with tags attached. Please contact our support team to initiate a return.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                How long does shipping take?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Standard shipping typically takes 3-7 business days within Bangladesh. Express shipping options are available for faster delivery at checkout.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 rounded-3 shadow-sm" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept Cash on Delivery, Credit/Debit Cards (Visa, Mastercard), Bank Transfer, and Mobile Banking (bKash, Nagad, Rocket).
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
