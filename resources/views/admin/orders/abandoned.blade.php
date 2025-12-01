@extends('layouts.master')

@section('title', 'Abandoned Carts')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Abandoned Carts</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                    <li class="breadcrumb-item active">Abandoned Carts</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Abandoned Cart List</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Customer</th>
                                <th>Email</th>
                                <th>Products</th>
                                <th>Cart Value</th>
                                <th>Abandoned Date</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <span class="material-symbols-outlined fs-1 d-block mb-2">remove_shopping_cart</span>
                                        <p class="mb-0">No abandoned carts found</p>
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

