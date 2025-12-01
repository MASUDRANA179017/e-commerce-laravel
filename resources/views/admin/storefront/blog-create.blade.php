@extends('layouts.master')

@section('title', 'Create Blog Post')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Create Blog Post</h3>
            <a href="{{ route('admin.storefront.blog') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Blog
            </a>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Post Content</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Post Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea class="form-control" rows="15" id="postContent"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Excerpt</label>
                    <textarea class="form-control" rows="3" placeholder="Brief summary of the post"></textarea>
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
                <div class="mb-3">
                    <label class="form-label">Publish Date</label>
                    <input type="datetime-local" class="form-control">
                </div>
                <button class="btn btn-primary w-100">
                    <i class="fas fa-save me-2"></i>Save Post
                </button>
            </div>
        </div>

        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Featured Image</h5>
            </div>
            <div class="card-body">
                <div class="border rounded p-4 text-center" style="border-style: dashed !important;">
                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                    <p class="mb-0 text-muted">Click to upload image</p>
                    <input type="file" class="d-none">
                </div>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Categories & Tags</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select class="form-select">
                        <option>Select category</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tags</label>
                    <input type="text" class="form-control" placeholder="Enter tags separated by comma">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

