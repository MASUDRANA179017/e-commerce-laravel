@extends('layouts.master')

@section('title', 'Edit Blog Post')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Edit Blog Post</h2>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- IMPORTANT: row → col-12 → row -->
        <div class="row">
            <div class="col-12">
                <div class="row">

                    <!-- LEFT COLUMN -->
                    <div class="col-12 col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Post Content</h5>
                            </div>
                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label">Title *</label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           name="title"
                                           value="{{ old('title', $blog->title) }}"
                                           required>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Excerpt</label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                              name="excerpt"
                                              rows="3">{{ old('excerpt', $blog->excerpt) }}</textarea>
                                    @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <small class="text-muted">Brief summary shown in blog listings</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Content *</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                              name="content"
                                              rows="15"
                                              required>{{ old('content', $blog->content) }}</textarea>
                                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="col-12 col-lg-4">

                        <!-- Publish -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Publish</h5>
                            </div>
                            <div class="card-body">

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="is_published"
                                           value="1"
                                           {{ old('is_published', $blog->is_published) ? 'checked' : '' }}>
                                    <label class="form-check-label">Published</label>
                                </div>

                                @if($blog->published_at)
                                    <small class="text-muted">
                                        Published: {{ $blog->published_at->format('M d, Y H:i') }}
                                    </small>
                                @endif

                                <hr>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bx bx-save"></i> Update Post
                                </button>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Featured Image</h5>
                            </div>
                            <div class="card-body">

                                <input type="file"
                                       class="form-control @error('featured_image') is-invalid @enderror"
                                       name="featured_image"
                                       accept="image/*">

                                @error('featured_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <small class="text-muted d-block mt-1">Max 2MB (JPEG, PNG, WebP)</small>

                                @if($blog->featured_image)
                                    <img src="{{ asset('storage/'.$blog->featured_image) }}"
                                         class="img-fluid rounded mt-3"
                                         style="max-height:200px">
                                @endif
                            </div>
                        </div>

                        <!-- Category & Tags -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Categories & Tags</h5>
                            </div>
                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <input type="text"
                                           class="form-control"
                                           name="category"
                                           value="{{ old('category', $blog->category) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tags</label>
                                    <input type="text"
                                           class="form-control"
                                           name="tags"
                                           value="{{ old('tags', is_array($blog->tags) ? implode(', ', $blog->tags) : '') }}">
                                    <small class="text-muted">Comma separated</small>
                                </div>

                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Statistics</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Views:</strong> {{ number_format($blog->views) }}</p>
                                <p><strong>Created:</strong> {{ $blog->created_at->format('M d, Y') }}</p>
                                <p class="mb-0"><strong>Updated:</strong> {{ $blog->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
@endsection
