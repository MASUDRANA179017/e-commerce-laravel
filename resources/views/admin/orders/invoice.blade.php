@extends('layouts.master')

@section('title', 'Invoice')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Invoice #{{ $order ?? 'N/A' }}</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="select-btn-white">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
                <button class="create-btn-base" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print Invoice
                </button>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-body p-5">
                <!-- Invoice Header -->
                <div class="row mb-5">
                    <div class="col-6">
                        <h2 class="fw-bold text-primary">GrowUp</h2>
                        <p class="mb-0">E-Commerce Store</p>
                        <p class="mb-0">Dhaka, Bangladesh</p>
                        <p class="mb-0">info@growup.com</p>
                    </div>
                    <div class="col-6 text-end">
                        <h4 class="fw-bold">INVOICE</h4>
                        <p class="mb-0"><strong>Invoice #:</strong> INV-{{ str_pad($order ?? 1, 6, '0', STR_PAD_LEFT) }}</p>
                        <p class="mb-0"><strong>Date:</strong> {{ now()->format('M d, Y') }}</p>
                        <p class="mb-0"><strong>Due Date:</strong> {{ now()->addDays(7)->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Bill To -->
                <div class="row mb-5">
                    <div class="col-6">
                        <h6 class="fw-bold text-muted">BILL TO:</h6>
                        <p class="mb-0"><strong>Customer Name</strong></p>
                        <p class="mb-0">customer@email.com</p>
                        <p class="mb-0">+880 1XXX-XXXXXX</p>
                        <p class="mb-0">Dhaka, Bangladesh</p>
                    </div>
                    <div class="col-6">
                        <h6 class="fw-bold text-muted">SHIP TO:</h6>
                        <p class="mb-0"><strong>Customer Name</strong></p>
                        <p class="mb-0">Delivery Address</p>
                        <p class="mb-0">Dhaka, Bangladesh</p>
                    </div>
                </div>

                <!-- Invoice Items -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Sample Product</td>
                                <td class="text-center">1</td>
                                <td class="text-end">৳0.00</td>
                                <td class="text-end">৳0.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                <td class="text-end">৳0.00</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Shipping:</strong></td>
                                <td class="text-end">৳0.00</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                <td class="text-end">৳0.00</td>
                            </tr>
                            <tr class="bg-light">
                                <td colspan="4" class="text-end"><strong class="fs-5">Total:</strong></td>
                                <td class="text-end"><strong class="fs-5">৳0.00</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Notes -->
                <div class="row">
                    <div class="col-8">
                        <h6 class="fw-bold">Notes:</h6>
                        <p class="text-muted">Thank you for your purchase. Please make payment within 7 days.</p>
                    </div>
                    <div class="col-4 text-end">
                        <p class="mb-0"><strong>Payment Method:</strong> Cash on Delivery</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar-area, header, .btn, nav { display: none !important; }
    .main-content { margin: 0 !important; padding: 0 !important; }
    .card { box-shadow: none !important; }
}
</style>
@endsection

