@extends('layouts.master')

@section('title', 'Blog Management')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Blog Management</h3>
            <a href="{{ route('admin.storefront.blog.create') }}" class="create-btn-base">
                <span class="material-symbols-outlined fs-14">add</span> New Post
            </a>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">Blog Posts</h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>All Status</option>
                            <option>Published</option>
                            <option>Draft</option>
                        </select>
                        <input type="text" class="form-control form-control-sm" placeholder="Search posts..." style="width: 200px;">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($post->featured_image)
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <div style="width: 50px; height: 50px; background: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bx bx-image" style="font-size: 20px; color: #6c757d;"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $post->title }}</strong>
                                                @if($post->excerpt)
                                                    <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($post->excerpt, 80) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $post->author->name ?? '—' }}</td>
                                    <td>{{ $post->category ?? '—' }}</td>
                                    <td>
                                        @if($post->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('admin.storefront.blog.edit', $post->id) }}" class="btn btn-sm btn-light"><i class="bx bx-edit"></i></a>
                                        <form action="{{ route('admin.storefront.blog.update', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_published" value="{{ $post->is_published ? 0 : 1 }}">
                                            <button class="btn btn-sm btn-light"><i class="bx bx-toggle-left"></i></button>
                                        </form>
                                        <form action="{{ route('admin.storefront.blog.destroy', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-light text-danger" onclick="return confirm('Delete this post?')"><i class="bx bx-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <span class="material-symbols-outlined fs-1 d-block mb-2">article</span>
                                            <p class="mb-0">No blog posts found</p>
                                            <small>Create your first blog post to engage your customers</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

