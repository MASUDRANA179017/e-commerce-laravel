@extends('layouts.master')

@section('title', 'Support Ticket')

@section('content')
<!-- ====== Bootstrap & FontAwesome ====== -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
/* ==== GLOBAL STYLES ==== */
body {
    background-color: #f9f6ff;
    font-family: "Inter", "Segoe UI", Arial, sans-serif;
    color: #2f1b63;
}

/* ==== CONTAINER ==== */
.container {
    max-width: 95%;
    margin: 0 auto;
    padding: 30px 15px 60px;
}

/* ==== CARD STYLES ==== */
.card {
    border: none;
    border-radius: 16px;
    background: linear-gradient(145deg, #ffffff, #f6f1ff);
    box-shadow: 0 6px 15px rgba(86, 48, 158, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(86, 48, 158, 0.15);
}

/* ==== SIDEBAR ==== */
.col-lg-3 {
    flex: 0 0 28%;
    max-width: 28%;
}

.col-lg-9 {
    flex: 0 0 70%;
    max-width: 70%;
}

.row.g-4 {
    gap: 20px;
}

.card-title {
    color: #56309e;
    font-weight: 700;
}

.text-primary {
    color: #56309e !important;
}

a.text-decoration-none {
    color: #56309e;
    transition: color 0.3s;
}

a.text-decoration-none:hover {
    color: #42217b;
}

/* Sidebar specific gradient tint */
.col-lg-3 .card {
    background: linear-gradient(145deg, #f7f2ff, #f4edff);
}

/* ==== MAIN CARD HEADER ==== */
.card-header {
    background-color: #f6f1ff !important;
    border-bottom: 2px solid rgba(86, 48, 158, 0.1) !important;
}

.card-header h4 {
    color: #56309e;
    font-weight: 700;
}

/* ==== FORM ==== */
.support-form label {
    color: #42217b;
    font-weight: 600;
}

.support-form .form-control {
    border: 1px solid #d9c9f8;
    border-radius: 12px;
    padding: 12px 14px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.support-form .form-control:focus {
    border-color: #56309e;
    box-shadow: 0 0 0 0.2rem rgba(86, 48, 158, 0.25);
    outline: none;
}

/* ==== BUTTON ==== */
.btn-primary {
    background-color: #56309e;
    border: none;
    font-weight: 600;
    letter-spacing: 0.3px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #432480;
    transform: translateY(-2px);
}

/* ==== ALERT ==== */
.alert-success {
    background-color: #e9dcff;
    color: #42217b;
    border: none;
}

/* ==== RESPONSIVE ==== */
@media (max-width: 992px) {
    .col-lg-3 {
        margin-bottom: 25px;
        flex: 0 0 100%;
        max-width: 100%;
    }

    .col-lg-9 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>

<!-- ====== PAGE CONTENT ====== -->
<div class="container py-5">
    <div class="row g-4">

        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="card shadow-sm p-3">
                <div class="card-body">
                    <h4 class="card-title mb-3 text-primary"><i class="fas fa-headset me-2"></i>Support Info</h4>
                    <p class="card-text text-muted">Submit your support request using the form below. Include screenshots or videos if relevant.</p>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i><strong>Email:</strong> 
                            <a href="mailto:support@example.com" class="text-decoration-none">support@example.com</a>
                        </li>
                        <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i><strong>Phone:</strong> 
                            <a href="tel:+880123456789" class="text-decoration-none">+880123456789</a>
                        </li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Address:</strong> 
                            123, Street Name, City, Country
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">

            <!-- Submit Ticket Card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h4 class="mb-0 text-primary"><i class="fas fa-ticket-alt me-2"></i>Submit a Support Ticket</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success shadow-sm rounded-3">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.support.store') }}" method="POST" enctype="multipart/form-data" class="support-form">
                        @csrf
                        <div class="mb-3">
                            <label for="special_id" class="form-label fw-semibold">Special ID</label>
                            <input type="text" id="special_id" name="special_id" placeholder="Enter Special ID" class="form-control rounded-3 shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control rounded-3 shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="attachment" class="form-label fw-semibold">Attachment</label>
                            <input type="file" id="attachment" name="attachment" class="form-control rounded-3 shadow-sm" accept="image/*,video/*">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Issue Description</label>
                            <textarea id="description" name="description" placeholder="Describe your issue" class="form-control rounded-3 shadow-sm" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="create-btn-base">
                            <i class="fas fa-paper-plane me-2"></i>Submit Ticket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
