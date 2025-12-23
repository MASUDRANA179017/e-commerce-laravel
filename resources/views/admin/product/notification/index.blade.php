@extends('layouts.master')
@section('title', 'Product Notification')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0 fw-bold">Send Product Notification</h4>
        <a href="{{ route('admin.product.all') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Products
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Notification for: {{ $product->title }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.product.notification.send', $product->id) }}" method="POST">
                @csrf
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label">Notification Title</label>
                        <input type="text" name="title" class="form-control" value="Special Offer: {{ $product->title }}" required>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="4" required>Check out {{ $product->title }} now available for just {{ $product->price }}!</textarea>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Target Audience</label>
                        <select name="audience" class="form-select">
                            <option value="all">All Users</option>
                            <option value="customers">Customers (Ordered before)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Send Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
