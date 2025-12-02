@extends('layouts.master')

@section('title', 'Edit Order #' . ($order->order_number ?? ''))

@section('content')
<form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h3 class="fw-bold mb-0">Edit Order #{{ $order->order_number ?? 'N/A' }}</h3>
                <a href="{{ route('admin.orders.index') }}" class="select-btn-white">
                    <i class="fas fa-arrow-left me-2"></i>Back to Orders
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ $order->first_name ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ $order->last_name ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $order->email ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $order->phone ?? '' }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $order->address ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $order->city ?? '' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" class="form-control" value="{{ $order->zip_code ?? '' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="{{ $order->country ?? '' }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2">{{ $order->notes ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->items ?? [] as $item)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            @if(isset($item->options['image']))
                                                <img src="{{ asset('storage/' . $item->options['image']) }}" class="rounded" width="40" height="40" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="bx bx-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="fw-medium">{{ $item->product_name }}</span>
                                                @if($item->variant_name)
                                                    <small class="d-block text-muted">{{ $item->variant_name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>৳{{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>৳{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No items</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Order Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ ($order->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ ($order->status ?? '') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ ($order->status ?? '') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ ($order->status ?? '') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ ($order->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="pending" {{ ($order->payment_status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ ($order->payment_status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="refunded" {{ ($order->payment_status ?? '') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <input type="text" class="form-control" value="{{ strtoupper($order->payment_method ?? 'N/A') }}" readonly>
                    </div>
                </div>
            </div>

            <div class="card border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>৳{{ number_format($order->subtotal ?? 0, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount:</span>
                        <span class="text-danger">-৳{{ number_format($order->discount ?? 0, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span>৳{{ number_format($order->shipping ?? 0, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span>৳{{ number_format($order->tax ?? 0, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total:</span>
                        <span class="text-primary">৳{{ number_format($order->total ?? 0, 2) }}</span>
                    </div>
                    <button type="submit" class="create-btn-base w-100 mt-3">
                        <i class="fas fa-save me-2"></i>Update Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

