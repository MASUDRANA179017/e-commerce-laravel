@extends('layouts.master')

@section('title', 'Flash Sales')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Flash Sales</h3>
            <button class="create-btn-base" data-bs-toggle="modal" data-bs-target="#addFlashSaleModal">
                <span class="material-symbols-outlined fs-14">add</span> Create Flash Sale
            </button>
        </div>
    </div>

    <!-- Active Flash Sale -->
    <div class="col-12 mb-4">
        <div class="card border-0 bg-primary bg-opacity-10">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold text-primary mb-1">No Active Flash Sale</h5>
                        <p class="mb-0 text-muted">Create a flash sale to boost your sales with limited-time offers</p>
                    </div>
                    <button class="create-btn-base">
                        <span class="material-symbols-outlined fs-14">flash_on</span> Start Flash Sale
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Sales List -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Flash Sale History</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Title</th>
                                <th>Products</th>
                                <th>Discount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">flash_on</span>
                                        <p class="mb-0">No flash sales found</p>
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

