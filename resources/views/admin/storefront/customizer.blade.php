@extends('layouts.master')

@section('title', 'Theme Customizer')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Theme Customizer</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Theme Customizer</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Colors</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Primary Color</label>
                    <input type="color" class="form-control form-control-color w-100" value="#0496ff">
                </div>
                <div class="mb-3">
                    <label class="form-label">Secondary Color</label>
                    <input type="color" class="form-control form-control-color w-100" value="#1a1a2e">
                </div>
                <div class="mb-3">
                    <label class="form-label">Accent Color</label>
                    <input type="color" class="form-control form-control-color w-100" value="#f9c123">
                </div>
            </div>
        </div>

        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Typography</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Primary Font</label>
                    <select class="form-select">
                        <option>Outfit</option>
                        <option>Roboto</option>
                        <option>Open Sans</option>
                        <option>Poppins</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Base Font Size</label>
                    <select class="form-select">
                        <option>14px</option>
                        <option selected>16px</option>
                        <option>18px</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Layout</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Header Style</label>
                    <select class="form-select">
                        <option>Default</option>
                        <option>Sticky</option>
                        <option>Transparent</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Footer Style</label>
                    <select class="form-select">
                        <option>Default</option>
                        <option>Minimal</option>
                        <option>Extended</option>
                    </select>
                </div>
            </div>
        </div>

        <button class="btn btn-primary w-100">Save Changes</button>
    </div>

    <div class="col-lg-8">
        <div class="card border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Preview</h5>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary active">Desktop</button>
                    <button class="btn btn-outline-secondary">Tablet</button>
                    <button class="btn btn-outline-secondary">Mobile</button>
                </div>
            </div>
            <div class="card-body p-0">
                <iframe src="{{ route('home') }}" style="width: 100%; height: 600px; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

