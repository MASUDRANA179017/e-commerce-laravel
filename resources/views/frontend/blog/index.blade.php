@extends('layouts.frontend')

@section('title', 'Blog - ' . config('app.name'))

    @section('content')
        <!-- Blog Banner -->
        <section class="banner-two">
            <div class="banner-two__slider swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="banner-two__slider-single">
                            <div class="banner-two__slider-bg"
                                data-background="{{ asset('frontend/assets/images/web-banner-4.png') }}"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-lg-10 m-auto">
                                        <div class="banner-two__slider-content text-center">
                                            <span class="sub-title-main text-white">
                                                <i class="bx bxs-news"></i> Our Blog
                                            </span>
                                            <h1 class="title-animation text-white">Latest News & Articles</h1>
                                            <p class="text-white mt-2 mb-4 text-center">
                                                Stay updated with the latest trends, tips, and insights
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Listing -->
        <section class="shop">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="shop__content">
                            <!-- Search & Filter -->
                            <div class="shop__content-intro mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <p>Showing <strong>{{ $blogs->firstItem() ?? 0 }}-{{ $blogs->lastItem() ?? 0 }}</strong>
                                            of {{ $blogs->total() }} Articles</p>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="{{ route('blog.index') }}" method="GET" class="d-flex gap-2">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search articles..." value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Blog Grid -->
                            <div class="row">
                                @forelse($blogs as $blog)
                                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                                        <article class="blog-card" data-aos="fade-up" data-aos-duration="1000">
                                            <div class="blog-card__image">
                                                <a href="{{ route('blog.show', $blog->slug) }}">
                                                    @if($blog->featured_image)
                                                        <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                                            alt="{{ $blog->title }}" class="w-100"
                                                            style="height: 250px; object-fit: cover;">
                                                    @else
                                                        <div class="w-100 bg-light d-flex align-items-center justify-content-center"
                                                            style="height: 250px;">
                                                            <i class="bx bx-image" style="font-size: 48px; color: #ccc;"></i>
                                                        </div>
                                                    @endif
                                                </a>
                                                @if($blog->category)
                                                    <span class="blog-card__category">{{ $blog->category }}</span>
                                                @endif
                                            </div>
                                            <div class="blog-card__content p-4">
                                                <div class="blog-card__meta mb-2">
                                                    <span><i class="bx bx-calendar"></i> {{ $blog->formatted_date }}</span>
                                                    <span><i class="bx bx-time-five"></i> {{ $blog->reading_time }} min read</span>
                                                </div>
                                                <h3 class="blog-card__title">
                                                    <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                                                </h3>
                                                @if($blog->excerpt)
                                                    <p class="blog-card__excerpt">{{ Str::limit($blog->excerpt, 120) }}</p>
                                                @endif
                                                <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-link p-0">
                                                    Read More <i class="bx bx-right-arrow-alt"></i>
                                                </a>
                                            </div>
                                        </article>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="text-center py-5">
                                            <i class="bx bx-file" style="font-size: 80px; color: #ddd;"></i>
                                            <h4 class="mt-3">No Articles Found</h4>
                                            <p class="text-muted">Check back later for new content!</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Pagination -->
                            @if($blogs->hasPages())
                                <div class="row">
                                    <div class="col-12">
                                        <div class="pagination-wrapper" data-aos="fade-up" data-aos-duration="1000">
                                            {{ $blogs->links() }}
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
            .blog-card {
                background: #fff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .blog-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            }

            .blog-card__image {
                position: relative;
                overflow: hidden;
            }

            .blog-card__category {
                position: absolute;
                top: 15px;
                left: 15px;
                background: var(--primary-color, #0496ff);
                color: #fff;
                padding: 5px 15px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            }

            .blog-card__content {
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            .blog-card__meta {
                display: flex;
                gap: 15px;
                font-size: 14px;
                color: #666;
            }

            .blog-card__meta i {
                margin-right: 5px;
            }

            .blog-card__title {
                font-size: 20px;
                margin-bottom: 10px;
            }

            .blog-card__title a {
                color: #333;
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .blog-card__title a:hover {
                color: var(--primary-color, #0496ff);
            }

            .blog-card__excerpt {
                color: #666;
                margin-bottom: 15px;
                flex: 1;
            }
        </style>
    @endpush
@endsection