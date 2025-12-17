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
                    <table class="table table-hover" id="blogsTable">
                        <thead>
                            <tr>
                                <th>SL</th>
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
                            <!-- DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#blogsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.blogs.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'title', name: 'title' },
                { data: 'category', name: 'category' },
                { data: 'author', name: 'author.name' },
                { data: 'status', name: 'is_published' },
                { data: 'views', name: 'views' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "",
                searchPlaceholder: "Search blogs...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    previous: '<i class="bx bx-chevron-left"></i>',
                    next: '<i class="bx bx-chevron-right"></i>'
                }
            },
            dom: '<"top"l>rt<"bottom d-flex justify-content-between align-items-center"ip><"clear">',
            order: [[7, 'desc']] // Order by Published/Created Date
        });
    });
</script>
@endpush
@endsection