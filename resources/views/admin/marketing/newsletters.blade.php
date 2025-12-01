@extends('layouts.master')

@section('title', 'Newsletters')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Newsletter Management</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#composeNewsletterModal">
                <span class="material-symbols-outlined fs-14">mail</span> Compose Newsletter
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-primary">group</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Total Subscribers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-success">send</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Emails Sent</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-info">mark_email_read</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0%</h4>
                        <span class="text-muted">Open Rate</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscribers -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Recent Subscribers</h5>
                <button class="btn btn-sm btn-outline-primary">Export</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Email</th>
                                <th>Subscribed</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No subscribers yet</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sent Newsletters -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Sent Newsletters</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Subject</th>
                                <th>Sent To</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No newsletters sent</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

