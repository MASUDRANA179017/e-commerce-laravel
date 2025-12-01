@extends('layouts.master')

@section('title', 'Blog Management')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Blog Management</h3>
            <button class="btn btn-primary">
                <span class="material-symbols-outlined fs-14">add</span> New Post
            </button>
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
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">article</span>
                                        <p class="mb-0">No blog posts found</p>
                                        <small>Create your first blog post to engage your customers</small>
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

