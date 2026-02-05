@extends('layouts.frontend')

@section('title', 'Privacy Policy - ' . config('app.name', 'E-Commerce'))
@section('description', 'Privacy Policy of our e-commerce store')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-area" style="background: #f8f9fa; padding: 40px 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="mb-2 fw-bold" style="color: var(--secondary-color);">Privacy Policy</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary-color);">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <section class="page-content-area py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-lg-5">
                            <div class="content-body">
                                @include('frontend.pages.privacy-content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
