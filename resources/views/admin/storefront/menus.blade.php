@extends('layouts.master')

@section('title', 'Navigation Menus')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Navigation Menus</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMenuModal">
                <span class="material-symbols-outlined fs-14">add</span> Create Menu
            </button>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Available Menus</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action active">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="material-symbols-outlined fs-14 me-2">menu</i> Main Menu</span>
                        <span class="badge bg-primary">5 items</span>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="material-symbols-outlined fs-14 me-2">menu</i> Footer Menu</span>
                        <span class="badge bg-secondary">8 items</span>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="material-symbols-outlined fs-14 me-2">menu</i> Mobile Menu</span>
                        <span class="badge bg-secondary">6 items</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Main Menu Items</h5>
                <button class="btn btn-sm btn-primary">
                    <span class="material-symbols-outlined fs-14">add</span> Add Item
                </button>
            </div>
            <div class="card-body">
                <div class="menu-items">
                    <div class="menu-item p-3 bg-light rounded mb-2 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <span class="material-symbols-outlined text-muted cursor-move">drag_indicator</span>
                            <span class="fw-medium">Home</span>
                            <small class="text-muted">/</small>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary">Edit</button>
                            <button class="btn btn-outline-danger">Delete</button>
                        </div>
                    </div>
                    <div class="menu-item p-3 bg-light rounded mb-2 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <span class="material-symbols-outlined text-muted cursor-move">drag_indicator</span>
                            <span class="fw-medium">Shop</span>
                            <small class="text-muted">/shop</small>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary">Edit</button>
                            <button class="btn btn-outline-danger">Delete</button>
                        </div>
                    </div>
                    <div class="menu-item p-3 bg-light rounded mb-2 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <span class="material-symbols-outlined text-muted cursor-move">drag_indicator</span>
                            <span class="fw-medium">About</span>
                            <small class="text-muted">/about</small>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary">Edit</button>
                            <button class="btn btn-outline-danger">Delete</button>
                        </div>
                    </div>
                    <div class="menu-item p-3 bg-light rounded mb-2 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <span class="material-symbols-outlined text-muted cursor-move">drag_indicator</span>
                            <span class="fw-medium">Contact</span>
                            <small class="text-muted">/contact</small>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary">Edit</button>
                            <button class="btn btn-outline-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white">
                <button class="btn btn-primary">Save Menu</button>
            </div>
        </div>
    </div>
</div>
@endsection

