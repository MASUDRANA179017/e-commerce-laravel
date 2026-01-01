@extends('layouts.master')

@section('title', 'Edit Page')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Edit Page</h3>
            <a href="{{ route('admin.storefront.pages') }}" class="select-btn-white">
                <i class="fas fa-arrow-left me-2"></i>Back to Pages
            </a>
        </div>
    </div>

    <form action="{{ route('admin.storefront.pages.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Page Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Page Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL Slug</label>
                            <div class="input-group">
                                <span class="input-group-text">/</span>
                                <input type="text" class="form-control" value="{{ $page->slug }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control" rows="15" id="pageContent">{{ old('content', $page->content) }}</textarea>
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
                                <option value="0" {{ !$page->status ? 'selected' : '' }}>Draft</option>
                                <option value="1" {{ $page->status ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
                        <button type="submit" class="create-btn-base w-100">
                            <i class="fas fa-save me-2"></i>Update Page
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
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

