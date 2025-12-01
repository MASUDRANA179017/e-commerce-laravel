@extends('layouts.frontend')

@section('title', 'Contact Us - GrowUp E-Commerce')

@section('content')
<!-- Map Section -->
<section class="contact-map">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.2895382521456!2d90.38926847499591!3d23.737591188740876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8ed00000001%3A0x77a2a3e5a5c56e39!2sDhaka%2C%20Bangladesh!5e0!3m2!1sen!2sbd!4v1701000000000!5m2!1sen!2sbd"
        width="100%" 
        height="400" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</section>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            <!-- Contact Info -->
            <div class="col-lg-5 mb-5 mb-lg-0">
                <div class="contact-info" data-aos="fade-up">
                    <span class="sub-title-main"><i class="fa-solid fa-headset"></i> Get In Touch</span>
                    <h2 class="title-animation mb-4">Contact <span>Information</span></h2>
                    <p class="text-muted mb-5">We're here to help! Reach out through any of the channels below and we'll get back to you as soon as possible.</p>
                    
                    <div class="contact-cards">
                        <div class="contact-card d-flex align-items-start mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon-box me-4" style="width: 60px; height: 60px; background: rgba(4, 150, 255, 0.1); border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-phone fa-lg" style="color: #0496ff;"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Call Us</h5>
                                <p class="mb-1"><a href="tel:+8801713269591" class="text-muted text-decoration-none">+880 1713-269591</a></p>
                                <p class="mb-0"><a href="tel:+8801713269592" class="text-muted text-decoration-none">+880 1713-269592</a></p>
                            </div>
                        </div>
                        
                        <div class="contact-card d-flex align-items-start mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon-box me-4" style="width: 60px; height: 60px; background: rgba(4, 150, 255, 0.1); border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-envelope fa-lg" style="color: #0496ff;"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Email Us</h5>
                                <p class="mb-1"><a href="mailto:info@growup.com" class="text-muted text-decoration-none">info@growup.com</a></p>
                                <p class="mb-0"><a href="mailto:support@growup.com" class="text-muted text-decoration-none">support@growup.com</a></p>
                            </div>
                        </div>
                        
                        <div class="contact-card d-flex align-items-start mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box me-4" style="width: 60px; height: 60px; background: rgba(4, 150, 255, 0.1); border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-location-dot fa-lg" style="color: #0496ff;"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Visit Us</h5>
                                <p class="mb-0 text-muted">Ambon Complex 99<br>Mohakhali C/A<br>Dhaka, Bangladesh</p>
                            </div>
                        </div>
                        
                        <div class="contact-card d-flex align-items-start" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon-box me-4" style="width: 60px; height: 60px; background: rgba(4, 150, 255, 0.1); border-radius: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa-solid fa-clock fa-lg" style="color: #0496ff;"></i>
                            </div>
                            <div>
                                <h5 class="mb-2">Working Hours</h5>
                                <p class="mb-1 text-muted">Monday - Friday: 9AM - 6PM</p>
                                <p class="mb-0 text-muted">Saturday: 10AM - 4PM</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Links -->
                    <div class="social-links mt-5" data-aos="fade-up" data-aos-delay="500">
                        <h6 class="mb-3">Follow Us</h6>
                        <div class="d-flex gap-2">
                            <a href="#" class="social-link" style="width: 45px; height: 45px; background: #0496ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" style="width: 45px; height: 45px; background: #1da1f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" style="width: 45px; height: 45px; background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" style="width: 45px; height: 45px; background: #0077b5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link" style="width: 45px; height: 45px; background: #25d366; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s;">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="contact-form bg-white rounded-4 shadow-sm p-5" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="mb-4">Send us a Message</h4>
                    <p class="text-muted mb-4">Fill out the form below and we'll get back to you within 24 hours.</p>
                    
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="John Doe" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="john@example.com" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control form-control-lg" placeholder="+880 1234-567890" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Subject <span class="text-danger">*</span></label>
                                <select name="subject" class="form-select form-select-lg @error('subject') is-invalid @enderror" required>
                                    <option value="">Select a subject</option>
                                    <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                    <option value="Product Question" {{ old('subject') == 'Product Question' ? 'selected' : '' }}>Product Question</option>
                                    <option value="Order Support" {{ old('subject') == 'Order Support' ? 'selected' : '' }}>Order Support</option>
                                    <option value="Returns & Refunds" {{ old('subject') == 'Returns & Refunds' ? 'selected' : '' }}>Returns & Refunds</option>
                                    <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                                    <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Your Message <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fa-solid fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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

