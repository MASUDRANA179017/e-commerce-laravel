@extends('layouts.master')

@section('title', 'Coupons & Discounts')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Coupons & Discounts</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCouponModal">
                <span class="material-symbols-outlined fs-14">add</span> Create Coupon
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-primary">confirmation_number</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Total Coupons</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-success">check_circle</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-info">receipt</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">0</h4>
                        <span class="text-muted">Times Used</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="wh-50 rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined text-warning">savings</span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">৳0</h4>
                        <span class="text-muted">Total Savings</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Coupons Table -->
    <div class="col-12">
        <div class="card border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Usage</th>
                                <th>Expiry</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">confirmation_number</span>
                                        <p class="mb-0">No coupons found</p>
                                        <small>Create your first coupon to attract customers</small>
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

<!-- Add Coupon Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Create Coupon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Coupon Code</label>
                        <input type="text" class="form-control" placeholder="e.g., SAVE20">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-select">
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Value</label>
                            <input type="number" class="form-control" placeholder="10">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Min. Purchase</label>
                            <input type="number" class="form-control" placeholder="0">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Usage Limit</label>
                            <input type="number" class="form-control" placeholder="Unlimited">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expiry Date</label>
                        <input type="date" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

