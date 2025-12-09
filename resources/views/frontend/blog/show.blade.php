@extends('layouts.frontend')

@section('title', $blog->title . ' - ' . config('app.name'))

@section('content')
    <!-- Blog Header -->
    <section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center text-white">
                    @if($blog->category)
                        <span class="badge bg-white text-primary mb-3">{{ $blog->category }}</span>
                    @endif
                    <h1 class="display-4 fw-bold mb-3">{{ $blog->title }}</h1>
                    <div class="d-flex justify-content-center gap-4 text-white-50">
                        <span><i class="bx bx-user"></i> {{ $blog->author->name ?? 'Admin' }}</span>
                        <span><i class="bx bx-calendar"></i> {{ $blog->formatted_date }}</span>
                        <span><i class="bx bx-time-five"></i> {{ $blog->reading_time }} min read</span>
                        <span><i class="bx bx-show"></i> {{ number_format($blog->views) }} views</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <!-- Featured Image -->
                    @if($blog->featured_image)
                        <div class="mb-5">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                                class="img-fluid rounded shadow-sm w-100" style="max-height: 500px; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Blog Content -->
                    <div class="blog-content mb-5">
                        {!! nl2br(e($blog->content)) !!}
                    </div>

                    <!-- Tags -->
                    @if($blog->tags && count($blog->tags) > 0)
                        <div class="mb-5">
                            <h5 class="mb-3">Tags:</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($blog->tags as $tag)
                                    <span class="badge bg-light text-dark border">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="border-top border-bottom py-4 mb-5">
                        <h5 class="mb-3">Share this article:</h5>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}"
                                target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bx bxl-facebook"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}"
                                target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="bx bxl-twitter"></i> Twitter
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $blog->slug)) }}&title={{ urlencode($blog->title) }}"
                                target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bx bxl-linkedin"></i> LinkedIn
                            </a>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if($relatedBlogs->count() > 0)
                        <div class="mb-5">
                            <h3 class="mb-4">Related Articles</h3>
                            <div class="row">
                                @foreach($relatedBlogs as $related)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border-0 shadow-sm">
                                            @if($related->featured_image)
                                                <img src="{{ asset('storage/' . $related->featured_image) }}" class="card-img-top"
                                                    alt="{{ $related->title }}" style="height: 150px; object-fit: cover;">
                                            @endif
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <a href="{{ route('blog.show', $related->slug) }}"
                                                        class="text-decoration-none text-dark">
                                                        {{ Str::limit($related->title, 50) }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">{{ $related->formatted_date }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Back to Blog -->
                    <div class="text-center">
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">
                            <i class="bx bx-arrow-back"></i> Back to Blog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .blog-content {
            font-size: 18px;
            line-height: 1.8;
            color: #333;
        }

        .blog-content p {
            margin-bottom: 1.5rem;
        }
    </style>
@endpush