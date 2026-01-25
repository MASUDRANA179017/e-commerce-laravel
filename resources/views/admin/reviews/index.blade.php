@extends('layouts.master')

@section('title', 'Product Reviews')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0"><i class="bx bx-star me-2"></i>Product Reviews</h4>
    </div>

    <!-- Status Tabs -->
    <div class="card mb-4">
        <div class="card-body p-2">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.reviews.index') }}" 
                   class="btn btn-sm {{ $status === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    All ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
                   class="btn btn-sm {{ $status === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="bx bx-time-five"></i> Pending ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
                   class="btn btn-sm {{ $status === 'approved' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="bx bx-check"></i> Approved ({{ $counts['approved'] }})
                </a>
                <a href="{{ route('admin.reviews.index', ['status' => 'featured']) }}" 
                   class="btn btn-sm {{ $status === 'featured' ? 'btn-info' : 'btn-outline-info' }}">
                    <i class="bx bx-home"></i> Featured on Home ({{ $counts['featured'] }})
                </a>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">Image</th>
                            <th>Reviewer</th>
                            <th>Product</th>
                            <th style="width: 120px;">Rating</th>
                            <th>Review</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 80px;">Featured</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td>
                                <div class="position-relative" style="width: 50px; height: 50px;">
                                    @if($review->reviewer_image)
                                        <img src="{{ asset('storage/' . $review->reviewer_image) }}" 
                                             alt="{{ $review->reviewer_name }}"
                                             class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                             style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            {{ strtoupper(substr($review->reviewer_name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <button type="button" class="btn btn-xs btn-light position-absolute" 
                                            style="bottom: -5px; right: -5px; padding: 2px 5px; font-size: 10px;"
                                            onclick="uploadReviewImage({{ $review->id }})" title="Change Image">
                                        <i class="bx bx-camera"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $review->reviewer_name }}</strong>
                                @if($review->verified_purchase)
                                    <span class="badge bg-success ms-1" title="Verified Purchase"><i class="bx bx-check"></i></span>
                                @endif
                                <br>
                                <small class="text-muted">{{ $review->reviewer_email }}</small>
                                <br>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                @if($review->product)
                                    <a href="{{ route('product.show', $review->product->slug ?? $review->product->id) }}" target="_blank">
                                        {{ Str::limit($review->product->title, 30) }}
                                    </a>
                                @else
                                    <span class="text-muted">Product deleted</span>
                                @endif
                            </td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bx bxs-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </td>
                            <td>
                                @if($review->title)
                                    <strong>"{{ $review->title }}"</strong><br>
                                @endif
                                <small>{{ Str::limit($review->comment, 100) }}</small>
                            </td>
                            <td>
                                @if($review->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($review->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block">
                                    <input type="checkbox" class="form-check-input" 
                                           {{ $review->featured ? 'checked' : '' }}
                                           {{ $review->status !== 'approved' ? 'disabled' : '' }}
                                           onchange="toggleFeatured({{ $review->id }})"
                                           title="{{ $review->status !== 'approved' ? 'Approve first to feature' : 'Toggle featured' }}">
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($review->status === 'pending')
                                        <button class="btn btn-success" onclick="approveReview({{ $review->id }})" title="Approve">
                                            <i class="bx bx-check"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="rejectReview({{ $review->id }})" title="Reject">
                                            <i class="bx bx-x"></i>
                                        </button>
                                    @elseif($review->status === 'rejected')
                                        <button class="btn btn-success" onclick="approveReview({{ $review->id }})" title="Approve">
                                            <i class="bx bx-check"></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-outline-danger" onclick="deleteReview({{ $review->id }})" title="Delete">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bx bx-message-square-x fs-1"></i>
                                <p class="mt-2">No reviews found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($reviews->hasPages())
        <div class="card-footer">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Hidden file input for image upload -->
<input type="file" id="reviewImageInput" style="display: none;" accept="image/*">

@endsection

@push('scripts')
<script>
    let currentReviewId = null;

    function approveReview(id) {
        $.post('/admin/reviews/' + id + '/approve', { _token: '{{ csrf_token() }}' })
            .done(function(res) {
                if (res.success) {
                    Swal.fire('Success', res.message, 'success').then(() => location.reload());
                }
            });
    }

    function rejectReview(id) {
        Swal.fire({
            title: 'Reject Review?',
            text: 'This review will be hidden from the website.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/admin/reviews/' + id + '/reject', { _token: '{{ csrf_token() }}' })
                    .done(function(res) {
                        if (res.success) {
                            Swal.fire('Rejected', res.message, 'success').then(() => location.reload());
                        }
                    });
            }
        });
    }

    function toggleFeatured(id) {
        $.post('/admin/reviews/' + id + '/toggle-featured', { _token: '{{ csrf_token() }}' })
            .done(function(res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: res.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
    }

    function deleteReview(id) {
        Swal.fire({
            title: 'Delete Review?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/reviews/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Deleted', res.message, 'success').then(() => location.reload());
                        }
                    }
                });
            }
        });
    }

    function uploadReviewImage(id) {
        currentReviewId = id;
        $('#reviewImageInput').click();
    }

    $('#reviewImageInput').on('change', function() {
        if (this.files && this.files[0] && currentReviewId) {
            var formData = new FormData();
            formData.append('reviewer_image', this.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '/admin/reviews/' + currentReviewId + '/update-image',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Success', res.message, 'success').then(() => location.reload());
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Failed to upload image', 'error');
                }
            });
        }
    });
</script>
@endpush

