@extends('layouts.master')

@section('title', 'Page Builder')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Page Builder</h3>
            <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#createPageModal">
                <span class="material-symbols-outlined fs-14">add</span> Create Page
            </button>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Page Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Last Modified</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 fw-medium">Home</td>
                                <td><code>/</code></td>
                                <td><span class="qbit-badge-success"><i class="bx bx-check-circle"></i> Published</span></td>
                                <td>{{ now()->format('M d, Y') }}</td>
                                <td class="text-end pe-3">
                                    <button class="action-btn-success">Edit</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">About Us</td>
                                <td><code>/about</code></td>
                                <td><span class="qbit-badge-success"><i class="bx bx-check-circle"></i> Published</span></td>
                                <td>{{ now()->format('M d, Y') }}</td>
                                <td class="text-end pe-3">
                                    <button class="action-btn-success">Edit</button>
                                    <button class="action-btn-danger">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Contact</td>
                                <td><code>/contact</code></td>
                                <td><span class="qbit-badge-success"><i class="bx bx-check-circle"></i> Published</span></td>
                                <td>{{ now()->format('M d, Y') }}</td>
                                <td class="text-end pe-3">
                                    <button class="action-btn-success">Edit</button>
                                    <button class="action-btn-danger">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Terms & Conditions</td>
                                <td><code>/terms</code></td>
                                <td><span class="qbit-badge-success"><i class="bx bx-check-circle"></i> Published</span></td>
                                <td>{{ now()->format('M d, Y') }}</td>
                                <td class="text-end pe-3">
                                    <button class="action-btn-success">Edit</button>
                                    <button class="action-btn-danger">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Privacy Policy</td>
                                <td><code>/privacy</code></td>
                                <td><span class="qbit-badge-success"><i class="bx bx-check-circle"></i> Published</span></td>
                                <td>{{ now()->format('M d, Y') }}</td>
                                <td class="text-end pe-3">
                                    <button class="action-btn-success">Edit</button>
                                    <button class="action-btn-danger">Delete</button>
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

