@extends('layouts.master')

@section('title', 'Create FAQ')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Create FAQ</h1>
        <a href="{{ route('admin.storefront.faqs.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.storefront.faqs.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="website">Website FAQ</option>
                            <option value="product">Product FAQ</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 d-none" id="product_select">
                        <label class="form-label">Product <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-select">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Question <span class="text-danger">*</span></label>
                        <input type="text" name="question" class="form-control" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Answer <span class="text-danger">*</span></label>
                        <textarea name="answer" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0" min="0">
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                            <label class="form-check-label">Active Status</label>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#type').change(function() {
            if ($(this).val() === 'product') {
                $('#product_select').removeClass('d-none');
                $('select[name="product_id"]').prop('required', true);
            } else {
                $('#product_select').addClass('d-none');
                $('select[name="product_id"]').prop('required', false);
            }
        });
    });
</script>
@endpush
