@extends('layouts.master')

@section('title', 'Create Page')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Create New Page</h3>
            <a href="{{ route('admin.storefront.pages') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Pages
            </a>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Page Content</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Page Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">URL Slug</label>
                    <div class="input-group">
                        <span class="input-group-text">/</span>
                        <input type="text" class="form-control" placeholder="page-url">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea class="form-control" rows="15" id="pageContent"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Publish</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>
                <button class="btn btn-primary w-100">
                    <i class="fas fa-save me-2"></i>Save Page
                </button>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">SEO Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

