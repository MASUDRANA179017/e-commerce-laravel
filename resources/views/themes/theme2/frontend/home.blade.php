@extends('layouts.frontend')

@section('title', 'Home')

@section('content')
<div class="text-center">
    <h2 class="display-4">Welcome to Theme 2</h2>
    <p class="lead">This is a separate theme implementation.</p>
    
    <div class="mt-5">
        <h3>Featured Products (Demo)</h3>
        <div class="row mt-4">
            @forelse($featuredProducts ?? [] as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        @if($product->images && $product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                No Image
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>No featured products found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection