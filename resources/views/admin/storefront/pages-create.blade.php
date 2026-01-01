@extends('layouts.master')

@section('title', 'Create Page')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Create New Page</h3>
            <a href="{{ route('admin.storefront.pages') }}" class="select-btn-white">
                <i class="fas fa-arrow-left me-2"></i>Back to Pages
            </a>
        </div>
    </div>

    <form action="{{ route('admin.storefront.pages.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Page Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Page Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control" rows="15" id="pageContent">{{ old('content') }}</textarea>
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
                            <select name="status" class="form-select">
                                <option value="0">Draft</option>
                                <option value="1" selected>Published</option>
                            </select>
                        </div>
                        <button type="submit" class="create-btn-base w-100">
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
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

