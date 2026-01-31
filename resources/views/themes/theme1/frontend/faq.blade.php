@extends('layouts.frontend')
@section('content')
<section class="faq-eight-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="faq-eight-wrapper" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <h2 class="title-animation text-center mb-4">Frequently Asked Questions</h2>
                    <div class="accordion" id="general_faqaccordion">
                        @forelse($faqs as $faq)
                            <div class="accordion-item faq-eight-accordion-item">
                                <h2 class="accordion-header" id="faq_{{ $faq->id }}">
                                    <button class="accordion-button faq-eight-accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq_collapse_{{ $faq->id }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="faq_collapse_{{ $faq->id }}">
                                        {{ $loop->iteration }}. {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="faq_collapse_{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                    aria-labelledby="faq_{{ $faq->id }}" data-bs-parent="#general_faqaccordion">
                                    <div class="accordion-body faq-eight-accordion-body">
                                        <p>{{ $faq->answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">No FAQs available at the moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
