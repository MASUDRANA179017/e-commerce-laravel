@extends('layouts.master')

@section('title', 'Invoice')

@section('content')

{{-- Screen only header --}}
<div class="row d-print-none">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Invoice #{{ $order->order_number ?? 'N/A' }}</h3>
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
</div>

{{-- Printable invoice area --}}
<div class="invoice-print-area">
    <div class="row">
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
                            <p class="mb-0"><strong>Invoice #:</strong> {{ $order->order_number ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>Date:</strong> {{ $order->created_at?->format('M d, Y') }}</p>
                            <p class="mb-0"><strong>Due Date:</strong> {{ $order->created_at?->addDays(7)->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Bill To -->
                    <div class="row mb-5">
                        <div class="col-6">
                            <h6 class="fw-bold text-muted">BILL TO:</h6>
                            <p class="mb-0"><strong>{{ $order->full_name ?? 'Guest' }}</strong></p>
                            <p class="mb-0">{{ $order->email ?? 'N/A' }}</p>
                            <p class="mb-0">{{ $order->phone ?? 'N/A' }}</p>
                            <p class="mb-0">{{ $order->full_address ?? 'N/A' }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="fw-bold text-muted">SHIP TO:</h6>
                            <p class="mb-0"><strong>{{ $order->full_name ?? 'Guest' }}</strong></p>
                            <p class="mb-0">{{ $order->full_address ?? 'Delivery Address' }}</p>
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
                                @forelse($order->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->product_name ?? 'Product' }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">৳{{ number_format($item->price, 2) }}</td>
                                        <td class="text-end">৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No items found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">৳{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Shipping:</strong></td>
                                    <td class="text-end">৳{{ number_format($order->shipping, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Tax:</strong></td>
                                    <td class="text-end">৳{{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <td colspan="4" class="text-end fs-5"><strong>Total:</strong></td>
                                    <td class="text-end fs-5"><strong>৳{{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Notes -->
                    <div class="row">
                        <div class="col-8">
                            <h6 class="fw-bold">Notes:</h6>
                            <p class="text-muted">
                                {{ $order->notes ?? 'Thank you for your purchase. Please make payment within 7 days.' }}
                            </p>
                        </div>
                        <div class="col-4 text-end">
                            <p class="mb-0"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                            <p class="mb-0"><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Print CSS --}}
<style>
@media print {

    /* Hide everything */
    body * {
        visibility: hidden;
    }

    /* Show invoice only */
    .invoice-print-area,
    .invoice-print-area * {
        visibility: visible;
    }

    /* Position invoice on top-left */
    .invoice-print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: #fff;
    }

    /* Hide admin UI */
    header, footer, nav, .sidebar-area {
        display: none !important;
    }

    /* Remove card shadows and borders */
    .card {
        border: none !important;
        box-shadow: none !important;
    }

    @page {
        size: A4;
        margin: 12mm;
    }
}
</style>

@endsection
