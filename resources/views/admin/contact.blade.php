@extends('layouts.master')

@section('title', 'Contact Us')

@section('content')
    <title>Contact Us</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* ==== GENERAL ==== */
body {
    background-color: #faf7ff; /* very light purple tint */
    font-family: 'Arial', sans-serif;
    color: #3e2c61;
    margin: 0;
    padding: 0;
}

/* ==== SECTION CONTAINER ==== */
.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px 20px;
}

/* ==== CONTACT HEADER CARD ==== */
.contact-header {
    text-align: center;
    background: #f3ebff;
    padding: 30px 25px; /* ↓ reduced vertical padding */
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(111, 66, 193, 0.1);
    margin-bottom: 40px; /* ↓ slightly reduced margin */
    transition: all 0.3s ease;
}


.contact-header:hover {
    box-shadow: 0 6px 20px rgba(111, 66, 193, 0.15);
    transform: translateY(-3px);
}

.contact-header h1 {
    font-size: 2.5rem;
    color: #6f42c1;
    margin-bottom: 15px;
    font-weight: 700;
}

.contact-header p {
    font-size: 1.05rem;
    color: #5b4b75;
    margin: 0;
}

/* ==== CONTACT INFO CARD ==== */
.contact-info-wrapper {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(111, 66, 193, 0.08);
    padding: 40px 30px 50px;
    transition: box-shadow 0.3s ease;
}

.contact-info-wrapper:hover {
    box-shadow: 0 6px 20px rgba(111, 66, 193, 0.15);
}

/* ==== CONTACT INFO GRID ==== */
.contact-info {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 25px;
}

/* ==== INDIVIDUAL CONTACT CARD ==== */
.contact-card {
    background-color: #f7f2ff;
    padding: 25px;
    border-radius: 14px;
    width: 230px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(111, 66, 193, 0.08);
}

.contact-card:hover {
    background-color: #ede2ff;
    transform: translateY(-6px);
    box-shadow: 0 6px 14px rgba(111, 66, 193, 0.2);
}

.contact-card i {
    font-size: 30px;
    color: #6f42c1;
    margin-bottom: 12px;
}

.contact-card p {
    margin: 5px 0;
    color: #4a3d66;
}

.contact-card p strong {
    color: #6f42c1;
}

/* ==== CONTACT FORM (if added later) ==== */
.contact-form {
    max-width: 1050px;
    margin: 20px auto 0;
    background: #ffffff;
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(111, 66, 193, 0.08);
}

.contact-form h2 {
    margin-bottom: 25px;
    color: #6f42c1;
    font-size: 1.8rem;
}

.form-control {
    border: 1px solid #d8c9f8;
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 1rem;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
    border-color: #6f42c1;
    box-shadow: 0 0 0 0.15rem rgba(111, 66, 193, 0.25);
    outline: none;
}

.btn-primary {
    background-color: #6f42c1;
    border: none;
    color: #fff;
    font-weight: 600;
    padding: 12px 22px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-primary:hover {
    background-color: #56309e;
    transform: translateY(-2px);
}

/* ==== FOOTER ==== */
.footer {
    background-color: #f3ebff;
    color: #4a148c;
    text-align: center;
    padding: 18px 0;
    font-size: 0.9rem;
    margin-top: 60px;
}

/* ==== RESPONSIVE ==== */
@media (max-width: 768px) {
    .contact-info {
        flex-direction: column;
        align-items: center;
    }

    .contact-card {
        width: 100%;
        max-width: 320px;
    }

    .contact-header h1 {
        font-size: 2rem;
    }
}
</style>

    <!-- Optional: Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <div class="contact-section">
    <!-- Contact Header Card -->
    <div class="container">
    <!-- Contact Header Card -->
    <div class="contact-header">
        <h1>Contact Us</h1>
        <p>We’d love to hear from you! Reach out using any method below or send a message directly.</p>
    </div>

    <!-- Contact Info Card -->
    <div class="contact-info-wrapper">
        <div class="contact-info">
            <div class="contact-card">
                <i class="fas fa-phone-alt"></i>
                <p><strong>Call Us Anytime</strong></p>
                <p>+880 1886-335682</p>
            </div>
            <div class="contact-card">
                <i class="fab fa-whatsapp"></i>
                <p><strong>Chat on WhatsApp</strong></p>
                <p>01886335682</p>
            </div>
            <div class="contact-card">
                <i class="fas fa-envelope"></i>
                <p><strong>Send An Email</strong></p>
                <p>qbit-bms@gmail.com</p>
            </div>
            <div class="contact-card">
                <i class="fas fa-map-marker-alt"></i>
                <p><strong>Our Location</strong></p>
                <p>Dhaka, Bangladesh</p>
            </div>
        </div>
    </div>
</div>



    <div class="contact-form">
        <h2>Send Us A Message</h2>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Laravel Form --}}
        <form action="{{ route('admin.contact.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="col">
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" name="subject" class="form-control" placeholder="Subject" required>
            </div>
            <div class="mb-3">
                <textarea name="message" class="form-control" rows="5" placeholder="How can we help you with your project?"
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Message</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
