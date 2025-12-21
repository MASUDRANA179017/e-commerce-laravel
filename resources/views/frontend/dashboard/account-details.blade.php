@extends('layouts.user-master')

@section('title', 'Account Details')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <h3 class="mb-0">Account Details</h3>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb align-items-center mb-0 lh-1">
            <li class="breadcrumb-item">
                <a href="{{ route('user.dashboard') }}" class="d-flex align-items-center text-decoration-none">
                    <i class="ri-home-4-line fs-18 text-primary me-1"></i>
                    <span class="text-secondary fw-medium hover">Dashboard</span>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <span class="fw-medium">Account Details</span>
            </li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card bg-white border-0 rounded-10 mb-4">
            <div class="card-body p-4">
                <h4 class="fw-semibold fs-18 border-bottom pb-20 mb-20">Edit Account Information</h4>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('user.account-details.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="first-name" class="label">Name <span class="text-danger">*</span></label>
                                <input type="text" id="first-name" name="name" value="{{ old('name', $user->name) }}" class="form-control h-55" placeholder="Enter your name" />
                                @error('name')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="email" class="label">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control h-55 bg-light" readonly disabled />
                                <small class="text-muted">Email address cannot be changed.</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="phone" class="label">Phone</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control h-55" placeholder="Enter phone number" />
                                @error('phone')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="address" class="label">Address</label>
                                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" class="form-control h-55" placeholder="Enter address" />
                                @error('address')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h4 class="fw-semibold fs-18 border-bottom pb-20 mb-20 mt-2">Password Change</h4>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label for="current-pwd" class="label">Current Password (leave blank to leave unchanged)</label>
                                <input type="password" id="current-pwd" name="current_password" class="form-control h-55" placeholder="Current Password" />
                                @error('current_password')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="new-pwd" class="label">New Password (leave blank to leave unchanged)</label>
                                <input type="password" id="new-pwd" name="new_password" class="form-control h-55" placeholder="New Password" />
                                @error('new_password')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="confirm-pwd" class="label">Confirm New Password</label>
                                <input type="password" id="confirm-pwd" name="new_password_confirmation" class="form-control h-55" placeholder="Confirm New Password" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary text-white py-2 px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
