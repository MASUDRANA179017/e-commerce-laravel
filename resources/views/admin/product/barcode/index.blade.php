@extends('layouts.master')
@section('title', 'Print Barcode')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0 fw-bold">Print Barcode</h4>
        <a href="{{ route('admin.product.all') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Products
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Barcode Configuration for: {{ $product->title }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.product.barcode.print') }}" method="POST" target="_blank">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Product SKU</label>
                        <input type="text" class="form-control bg-light" value="{{ $product->sku }}" readonly>
                        <div class="form-text">The barcode will be generated from this SKU.</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Barcode Type</label>
                        <select name="type" class="form-select">
                            <option value="UPC-A" {{ (is_numeric($product->sku) && (strlen($product->sku)==11 || strlen($product->sku)==12)) ? 'selected' : '' }}>UPC-A (Retail)</option>
                            <option value="C128" {{ !(is_numeric($product->sku) && (strlen($product->sku)==11 || strlen($product->sku)==12)) ? 'selected' : '' }}>Code 128 (Universal)</option>
                        </select>
                        <div class="form-text">UPC-A requires 11 or 12 digits numeric SKU.</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Quantity (Labels)</label>
                        <input type="number" name="quantity" class="form-control" value="24" min="1" max="100">
                        <div class="form-text">Number of labels to print.</div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-print me-1"></i> Generate & Print
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
