@extends('layouts.frontend')

@section('title', $page->meta_title ?? $page->title . ' - ' . config('app.name', 'E-Commerce'))
@section('description', $page->meta_description ?? '')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-area" style="background: #f8f9fa; padding: 40px 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center breadcrumb-content">
                        <h2 class="mb-2 fw-bold" style="color: var(--secondary-color);">{{ $page->title }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="mb-0 breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary-color);">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <section class="py-5 page-content-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="border-0 shadow-sm card rounded-4">
                        <div class="p-4 card-body p-lg-5">
                            <div class="content-body">
                                @if(isset($page->slug) && $page->slug === 'terms-and-conditions' && (!$page->content || empty(trim(strip_tags($page->content)))) )
                                    @include('frontend.pages.terms-content')
                                @elseif($page->content && !empty(trim(strip_tags($page->content))))
                                    {!! $page->content !!}
                                @else
                                    <div class="alert alert-info" role="alert">
                                        <strong>Content Coming Soon</strong>
                                        <p class="mb-0">This page is currently being updated. Please check back later.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
