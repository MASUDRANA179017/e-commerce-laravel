@extends('layouts.frontend')

@section('title', 'Return & Refund - GrowUp E-Commerce')

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
<section class="faq-section py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="title-animation">Track <span>Orders</span></h2>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="accordion" id="faqAccordion">

          <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm" data-aos="fade-up" data-aos-delay="0">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                How can I track my order?
              </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Once your order is shipped, you will receive an email with a tracking number. You can use this number to track your order on our website or the carrier's website.
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>




@endsection
