<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Full Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" required value="{{ old('name', $customer->name ?? '') }}">
        @error('name')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" required value="{{ old('email', $customer->email ?? '') }}">
        @error('email')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        @php $isEdit = $isEdit ?? false; @endphp
        <label class="form-label">Password {!! !$isEdit ? '<span class="text-danger">*</span>' : '' !!}</label>
        <input type="password" name="password" class="form-control" {!! !$isEdit ? 'required minlength="6"' : '' !!} placeholder="{{ $isEdit ? 'Leave blank to keep current' : '' }}">
        @error('password')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Confirm Password {!! !$isEdit ? '<span class="text-danger">*</span>' : '' !!}</label>
        <input type="password" name="password_confirmation" class="form-control" {!! !$isEdit ? 'required minlength="6"' : '' !!} placeholder="{{ $isEdit ? 'Leave blank to keep current' : '' }}">
        @error('password_confirmation')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3"></div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone ?? '') }}">
        @error('phone')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Zip Code</label>
        <input type="text" name="zipcode" class="form-control" value="{{ old('zipcode', $customer->zipcode ?? '') }}">
        @error('zipcode')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control" rows="3">{{ old('address', $customer->address ?? '') }}</textarea>
    @error('address')
    <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label">Note</label>
    <textarea name="note" class="form-control" rows="2">{{ old('note', $customer->note ?? '') }}</textarea>
    @error('note')
    <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Total Spent</label>
        <input type="number" step="0.01" name="total_spent" class="form-control" value="{{ old('total_spent', $customer->total_spent ?? 0) }}">
        @error('total_spent')
        <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3 d-flex align-items-center">
        <div class="form-check form-switch ms-2">
            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveField" {{ old('is_active', isset($customer) ? $customer->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="isActiveField">Active</label>
        </div>
    </div>
</div>
