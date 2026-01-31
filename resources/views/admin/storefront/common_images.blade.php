@extends('layouts.master')

@section('title', 'Common Images')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Website Common Images</h3>
        </div>
        <p class="text-muted">Manage global images for your storefront.</p>
    </div>

    <div class="col-lg-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Image Settings</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.storefront.common-images.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Footer Background -->
                        <div class="col-md-6 col-lg-6">
                            <div class="card h-100 border bg-light">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold mb-3">Footer Background</h6>
                                    <div class="mb-3">
                                        @if(isset($images['footer_background']) && $images['footer_background'])
                                            <img src="{{ asset('storage/' . $images['footer_background']) }}" alt="Footer Background" class="img-fluid rounded" style="max-height: 200px; max-width: 100%;">
                                        @else
                                            <div class="text-muted p-4 border rounded bg-white">
                                                <span class="material-symbols-outlined fs-1">image</span>
                                                <p class="small mb-0">No image uploaded</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="footer_background" class="form-label small text-uppercase fw-bold text-muted">Upload New Image</label>
                                        <input type="file" class="form-control" id="footer_background" name="footer_background" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Flash Sale Image -->
                        <div class="col-md-6 col-lg-6">
                            <div class="card h-100 border bg-light">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold mb-3">Flash Sale Image</h6>
                                    <div class="mb-3">
                                        @if(isset($images['flash_sale_image']) && $images['flash_sale_image'])
                                            <img src="{{ asset('storage/' . $images['flash_sale_image']) }}" alt="Flash Sale Image" class="img-fluid rounded" style="max-height: 200px; max-width: 100%;">
                                        @else
                                            <div class="text-muted p-4 border rounded bg-white">
                                                <span class="material-symbols-outlined fs-1">image</span>
                                                <p class="small mb-0">No image uploaded</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="flash_sale_image" class="form-label small text-uppercase fw-bold text-muted">Upload New Image</label>
                                        <input type="file" class="form-control" id="flash_sale_image" name="flash_sale_image" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shop Page Title Banner -->
                        <div class="col-md-6 col-lg-6">
                            <div class="card h-100 border bg-light">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold mb-3">Shop Page Title Banner</h6>
                                    <div class="mb-3">
                                        @if(isset($images['shop_title_banner']) && $images['shop_title_banner'])
                                            <img src="{{ asset('storage/' . $images['shop_title_banner']) }}" alt="Shop Title Banner" class="img-fluid rounded" style="max-height: 200px; max-width: 100%;">
                                        @else
                                            <div class="text-muted p-4 border rounded bg-white">
                                                <span class="material-symbols-outlined fs-1">image</span>
                                                <p class="small mb-0">No image uploaded</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="shop_title_banner" class="form-label small text-uppercase fw-bold text-muted">Upload New Image</label>
                                        <input type="file" class="form-control" id="shop_title_banner" name="shop_title_banner" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="create-btn-base">
                            <span class="material-symbols-outlined fs-14">save</span> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
