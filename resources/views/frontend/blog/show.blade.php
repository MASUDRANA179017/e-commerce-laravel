@extends('layouts.frontend')

@section('title', $blog->title . ' - ' . config('app.name'))

@section('content')
    <section class="py-5 pt-12 pb-12" style="background: linear-gradient(135deg, #0ea5e9 0%, #0c4a6e 100%);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center text-white pt-5">
                    <h1 class="fw-bold mb-2">{{ $blog->title }}</h1>
                    <div class="d-flex justify-content-center flex-wrap gap-3 text-white-50">
                        <span><i class="bx bx-user"></i> {{ $blog->author->name ?? 'Admin' }}</span>
                        <span><i class="bx bx-calendar"></i> {{ $blog->formatted_date }}</span>
                        <span><i class="bx bx-time-five"></i> {{ $blog->reading_time }} min read</span>
                        <span><i class="bx bx-show"></i> {{ number_format($blog->views) }} views</span>
                        @if($blog->category)
                            <span><i class="bx bx-category"></i> {{ $blog->category }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if($blog->featured_image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                                 class="img-fluid rounded w-100 shadow-sm" style="max-height: 460px; object-fit: cover;">
                        </div>
                    @endif

                    <div class="blog-content mb-4">
                        {!! nl2br(e($blog->content)) !!}
                    </div>

                    @if($blog->tags && count($blog->tags) > 0)
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 py-3 border-top">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <strong class="me-2">Tags:</strong>
                                @foreach($blog->tags as $tag)
                                    <a href="{{ route('blog.index', ['search' => $tag]) }}" class="badge bg-light text-dark border">
                                        {{ $tag }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <strong class="me-2">Share:</strong>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}"
                                   target="_blank" class="btn btn-light border rounded-1 p-2">
                                    <i class="bx bxl-facebook"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}"
                                   target="_blank" class="btn btn-light border rounded-1 p-2">
                                    <i class="bx bxl-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $blog->slug)) }}&title={{ urlencode($blog->title) }}"
                                   target="_blank" class="btn btn-light border rounded-1 p-2">
                                    <i class="bx bxl-linkedin"></i>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($relatedBlogs->count() > 0)
                        <div class="mt-4">
                            <h3 class="mb-3">Related News</h3>
                            <div class="row">
                                @foreach($relatedBlogs as $related)
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('blog.show', $related->slug) }}" class="text-decoration-none text-dark">
                                            <div class="card h-100 border-0 shadow-sm">
                                                @if($related->featured_image)
                                                    <img src="{{ asset('storage/' . $related->featured_image) }}" class="card-img-top"
                                                         alt="{{ $related->title }}" style="height: 130px; object-fit: cover;">
                                                @endif
                                                <div class="card-body">
                                                    <h6 class="card-title mb-1">{{ Str::limit($related->title, 60) }}</h6>
                                                    <small class="text-muted">{{ $related->formatted_date }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Categories</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                                @forelse(($categories ?? collect()) as $cat)
                                    <li class="d-flex align-items-center justify-content-between">
                                        <a href="{{ route('blog.index', ['category' => $cat]) }}" class="text-decoration-none">{{ $cat }}</a>
                                        <i class="fa-solid fa-angle-right text-muted"></i>
                                    </li>
                                @empty
                                    <li class="text-muted">No categories found</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Recent News</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                                @forelse(($recentBlogs ?? collect()) as $item)
                                    <li class="d-flex align-items-center gap-3">
                                        @if($item->featured_image)
                                            <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}"
                                                 class="rounded" style="width: 64px; height: 64px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                 style="width: 64px; height: 64px;">
                                                <i class="bx bx-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <a href="{{ route('blog.show', $item->slug) }}" class="text-decoration-none fw-medium d-block">
                                                {{ Str::limit($item->title, 70) }}
                                            </a>
                                            <small class="text-muted">{{ $item->formatted_date }}</small>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-muted">No recent news</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Popular Tags</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                @forelse(($popularTags ?? collect()) as $tag)
                                    <a href="{{ route('blog.index', ['search' => $tag]) }}" class="badge bg-light text-dark border">{{ $tag }}</a>
                                @empty
                                    <span class="text-muted">No tags found</span>
                                @endforelse
                            </div>
                        </div>
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
