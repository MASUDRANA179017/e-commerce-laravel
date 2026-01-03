@extends('layouts.master')

@section('title', 'Edit Blog Post')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Edit Blog Post</h3>
            <a href="{{ route('admin.storefront.blog') }}" class="select-btn-white">
                <i class="fas fa-arrow-left me-2"></i>Back to Blog
            </a>
        </div>
    </div>

    <form action="{{ route('admin.storefront.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="contents">
        @csrf
        @method('PUT')
    <div class="col-lg-8">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Post Content</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Post Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="15" id="postContent" required>{{ old('content', $post->content) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
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
                    <select name="is_published" class="form-select">
                        <option value="0" {{ old('is_published', $post->is_published ? 1 : 0) == 0 ? 'selected' : '' }}>Draft</option>
                        <option value="1" {{ old('is_published', $post->is_published ? 1 : 0) == 1 ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <button class="create-btn-base w-100">
                    <i class="fas fa-save me-2"></i>Update Post
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
                    <p class="mb-0 text-muted">Click to change image</p>
                    <input type="file" name="featured_image" class="d-none">
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
                    <select name="category" class="form-select">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category', $post->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tags</label>
                    <input type="text" name="tags" class="form-control" value="{{ old('tags', is_array($post->tags) ? implode(',', $post->tags) : ($post->tags ?? '')) }}">
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection

