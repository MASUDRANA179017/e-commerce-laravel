<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business_setup->login_title ?? ($business_setup->system_name ?? 'QBit BMS') }} - Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ $business_setup->favicon ? asset('storage/' . $business_setup->favicon) : asset('frontend/assets/images/logo.png') }}">

    <style>
        :root {
            --primary-color: #007bff;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --dark-blue: #1a237e;
            --light-blue: #536dfe;
            --text-color: #dee2e6;
            --input-bg: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: url("{{ $business_setup->login_background ? asset('storage/' . $business_setup->login_background) : asset('frontend/assets/images/page-bg.jpg') }}") no-repeat center center;

            background-size: cover;
            background-attachment: fixed;
        }
        
        .main-container {
            position: relative;
            z-index: 10;
            width: 90%;
            max-width: 1100px;
            min-height: 650px;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            overflow: hidden;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
        }

        .branding-section, .register-section {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .branding-section {
            color: white;
            text-align: center;
        }
        .branding-section img {
            max-width: 80%;
            animation: float 6s ease-in-out infinite;
        }
        .branding-section h4 {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .register-section {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 25px;
            margin: 50px;
            border-radius: 15px;
            overflow-y: auto;
            max-height: 90vh;
        }
        
        .qb-card-header-title-md {
            font-weight: 700;
            color: #fff;
        }
        .register-section p {
            color: var(--text-color);
        }

        .small-label-text {
            font-weight: 500;
            color: var(--text-color);
            font-size: 13px;
            margin-bottom: 3px;
        }

        .custom-input {
            font-size: 13.5px !important;
            padding: 7px 13px !important;
            height: inherit !important;
            color: #ffffff !important;
            border-radius: 5px !important;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }
        .custom-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .custom-input:focus {
            background: rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25) !important;
            border-color: rgba(0, 123, 255, 0.5) !important;
        }
        .input-group-text.custom-input {
            border-left: 0 !important;
        }
        
        .btn {
            border-radius: 8px;
            font-weight: 400;
            padding: 6px 24px;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(45deg, var(--light-blue), var(--primary-color));
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(0, 123, 255, 0.4);
        }

        .hover-a {
            color: #8CC052;
            text-decoration: none;
            font-weight: 400;
        }

        .invalid-feedback {
            color: #ff6b6b;
            font-size: 12px;
        }

        .is-invalid {
            border-color: #ff6b6b !important;
        }

        @media (max-width: 991.98px) {
            .main-container { flex-direction: column; width: 95%; max-width: 500px; min-height: auto; }
            .branding-section { display: none; }
            .register-section { border-left: none; margin: 20px; }
        }
    </style>
</head>
<body>
    <div class="main-container">
        
        <div class="branding-section">
            <div class="mx-auto text-center">
                <img src="{{ $business_setup->logo ? asset('storage/' . $business_setup->logo) : asset('frontend/assets/images/logo.png') }}" class="img-fluid" width="200px" alt="{{ $business_setup->company_name ?? 'Logo' }}">
            </div>
            <h4 class="text-white text-center">{{ $business_setup->login_title ?? ($business_setup->system_name ?? 'QBit BMS - Ecosystem') }}</h4>
            <div class="authen-overlay-img mx-auto text-center mb-3">
                <img src="{{ $business_setup->login_image ? asset('storage/' . $business_setup->login_image) : 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400&h=300&fit=crop' }}" style="width: 80%; border-radius: 15px;" alt="{{ $business_setup->company_name ?? 'Illustration' }}">
            </div>
            <div class="text-center mx-auto mt-4">
                <p class="text-white fs-15 mb-1">{{ $business_setup->login_tagline ?? 'An Integrated Ecosystem of 10 Powerful Applications' }}</p>
                <p class="mb-0 text-white fs-13">{{ $business_setup->login_copyright ?? ('Copyright © ' . date('Y') . ' - ' . ($business_setup->company_name ?? 'QBit Tech')) }}</p>
            </div>
        </div>
        
        <div class="register-section">
            <div class="mx-auto text-center mb-3">
                <img src="{{ $business_setup->logo ? asset('storage/' . $business_setup->logo) : asset('frontend/assets/images/logo.png') }}" class="img-fluid" width="120px" alt="{{ $business_setup->company_name ?? 'Logo' }}">
            </div>
            <div class="text-center">
                <h2 class="fs-28 mb-2 qb-card-header-title-md">Create Account</h2>
                <p class="mb-3">{{ $business_setup->login_subtitle ?? 'Join us to streamline your business operations.' }}</p>
            </div>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label class="small-label-text" for="name">Full Name</label>
                    <div class="input-group">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control custom-input @error('name') is-invalid @enderror" placeholder="Enter your full name" required autofocus>
                        <span class="input-group-text custom-input"><i class='bx bx-user'></i></span>
                    </div>
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="small-label-text" for="email">Email Address</label>
                    <div class="input-group">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control custom-input @error('email') is-invalid @enderror" placeholder="Enter your email address" required>
                        <span class="input-group-text custom-input"><i class='bx bx-envelope'></i></span>
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="small-label-text" for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control custom-input @error('password') is-invalid @enderror" placeholder="Enter your password" required>
                        <span class="input-group-text custom-input" id="togglePassword" style="cursor: pointer;"><i class='bx bx-low-vision'></i></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="small-label-text" for="password_confirmation">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control custom-input" placeholder="Confirm your password" required>
                        <span class="input-group-text custom-input" id="togglePasswordConfirm" style="cursor: pointer;"><i class='bx bx-low-vision'></i></span>
                    </div>
                </div>

                <div class="mb-3 mt-4">
                    <button type="submit" class="btn btn-primary w-100">Create Account</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <p class="fw-normal mb-0">Already have an account? <a href="{{ route('login') }}" class="hover-a">Sign In</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#togglePassword").on("click", function () {
                let passwordField = $("#password");
                let type = passwordField.attr("type");

                if (type === "password") {
                    passwordField.attr("type", "text");
                    $(this).find("i").removeClass("bx-low-vision").addClass("bx-show");
                } else {
                    passwordField.attr("type", "password");
                    $(this).find("i").removeClass("bx-show").addClass("bx-low-vision");
                }
            });

            $("#togglePasswordConfirm").on("click", function () {
                let passwordField = $("#password_confirmation");
                let type = passwordField.attr("type");

                if (type === "password") {
                    passwordField.attr("type", "text");
                    $(this).find("i").removeClass("bx-low-vision").addClass("bx-show");
                } else {
                    passwordField.attr("type", "password");
                    $(this).find("i").removeClass("bx-show").addClass("bx-low-vision");
                }
            });
        });
    </script>
</body>
</html>
