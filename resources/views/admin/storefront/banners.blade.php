@extends('layouts.master')

@section('title', 'Banners & Sliders')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Banners & Sliders</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBannerModal">
                <span class="material-symbols-outlined fs-14">add</span> Add Banner
            </button>
        </div>
    </div>

    <!-- Hero Sliders -->
    <div class="col-12 mb-4">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Hero Sliders</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="border rounded p-3 text-center" style="border-style: dashed !important;">
                            <span class="material-symbols-outlined fs-1 text-muted d-block mb-2">add_photo_alternate</span>
                            <p class="mb-2 text-muted">Add Slider Image</p>
                            <small class="text-muted">Recommended: 1920x600px</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotional Banners -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Promotional Banners</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Preview</th>
                                <th>Title</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Clicks</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">image</span>
                                        <p class="mb-0">No banners found</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

