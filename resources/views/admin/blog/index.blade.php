@extends('layouts.master')

@section('title', 'Blog Posts')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Blog Posts</h2>
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Create New Post
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                                <tr>
                                    <td>
                                        @if($blog->featured_image)
                                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div
                                                style="width: 60px; height: 60px; background: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bx bx-image" style="font-size: 24px; color: #6c757d;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ Str::limit($blog->title, 50) }}</strong>
                                        @if($blog->excerpt)
                                            <br><small class="text-muted">{{ Str::limit($blog->excerpt, 60) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->category)
                                            <span class="badge bg-info">{{ $blog->category }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $blog->author->name ?? 'Unknown' }}</td>
                                    <td>
                                        @if($blog->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($blog->views) }}</td>
                                    <td>{{ $blog->formatted_date }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.blogs.edit', $blog) }}"
                                                class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bx bx-file" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="mt-2 text-muted">No blog posts yet. Create your first post!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($blogs->hasPages())
                    <div class="mt-4">
                        {{ $blogs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection