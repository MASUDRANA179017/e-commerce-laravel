@extends('themes.theme2.layouts.frontend')

@section('title', 'My Wishlist - GrowUp E-Commerce')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="mb-4 text-center">
            <h2 class="fw-bold">My Wishlist</h2>
            <p class="text-muted mb-0">Your saved products in one place</p>
        </div>

        @if($products->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fa-solid fa-heart text-danger me-2"></i>
                    You have {{ $products->count() }} items
                </h5>
                <form action="{{ route('wishlist.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Clear your entire wishlist?')">
                        <i class="fa-solid fa-trash me-1"></i>Clear Wishlist
                    </button>
                </form>
            </div>

            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-12 col-md-6 col-lg-4">
                        @include('themes.theme2.frontend.partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fa-regular fa-heart text-muted" style="font-size: 80px; opacity: 0.6;"></i>
                </div>
                <h3 class="mb-3">Your wishlist is empty</h3>
                <p class="text-muted mb-4">Start adding products to quickly find them later.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-danger">
                    <i class="fa-solid fa-shopping-bag me-2"></i>Browse Products
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
