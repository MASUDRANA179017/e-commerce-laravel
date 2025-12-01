<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QBit BMS - Ecosystem</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/QBit-Tech_Fevicon.png') }}">

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
            background: url("{{ asset('assets/images/main-bg.jpg') }}") no-repeat center center;

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

        .branding-section, .login-section {
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

        .login-section {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 25px;
            margin: 50px;
            border-radius: 15px;
        }
        
        .qb-card-header-title-md {
            font-weight: 700;
            color: #fff;
        }
        .login-section p {
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

        .btn-soft-secondary, .btn-soft-warning, .btn-soft-primary, .btn-soft-success {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-soft-secondary:hover, .btn-soft-warning:hover, .btn-soft-primary:hover, .btn-soft-success:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
        }
        
        .hover-a {
            color: #8CC052;
            text-decoration: none;
            font-weight: 400;
        }

        /* Modal Styling */
        .modal-content {
            background: rgba(30, 30, 50, 0.7);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        .modal-header { border-bottom-color: rgba(255, 255, 255, 0.1); }
        .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }

        .recovery-illustration .shield-icon,
        .recovery-illustration .email-icon,
        .recovery-illustration .phone-icon,
        .recovery-illustration .otp-icon,
        .recovery-illustration .password-icon {
            width: 80px; height: 80px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
            animation: iconPulse 2s ease-in-out infinite;
        }
        .shield-icon { background: linear-gradient(145deg, #e3f2fd, #bbdefb); color: #1976d2; box-shadow: 0 8px 25px rgba(25, 118, 210, 0.3); }
        .email-icon { background: linear-gradient(145deg, #e3f2fd, #bbdefb); color: #1976d2; box-shadow: 0 8px 25px rgba(25, 118, 210, 0.3); }
        .phone-icon { background: linear-gradient(145deg, #e8f5e8, #c8e6c9); color: #2e7d32; box-shadow: 0 8px 25px rgba(46, 125, 50, 0.3); }
        .otp-icon { background: linear-gradient(145deg, #fff3e0, #ffe0b2); color: #f57c00; box-shadow: 0 8px 25px rgba(245, 124, 0, 0.3); }
        .password-icon { background: linear-gradient(145deg, #f3e5f5, #e1bee7); color: #7b1fa2; box-shadow: 0 8px 25px rgba(123, 31, 162, 0.3); }

        @keyframes iconPulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }

        .otp-input {
            width: 50px; height: 50px; font-size: 1.5rem; text-align: center;
            background: rgba(255, 255, 255, 0.1); color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px;
        }
        .otp-input:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); }

        @media (max-width: 991.98px) {
            .main-container { flex-direction: column; width: 95%; max-width: 500px; min-height: auto; }
            .branding-section { display: none; }
            .login-section { border-left: none; }
        }
    </style>
</head>
<body>
    <div class="main-container">
        
        <div class="branding-section">
            <div class="mx-auto text-center">
                <img src="{{ asset('assets/images/QBit-BMS_Logo-2.png') }}" class="img-fluid" width="200px" alt="Logo">
            </div>
            <h4 class="text-white text-center">QBit BMS - Ecosystem</h4>
            <div class="authen-overlay-img mx-auto text-center mb-3">
                <img src="{{ asset('assets/images/HR-login.png') }}" style="width: 80%;" alt="Img">
            </div>
            <div class="text-center mx-auto mt-4">
                <p class="text-white fs-15 mb-1">An Integrated Ecosystem of 10 Powerful Applications</p>
                <p class="mb-0 text-white fs-13">Copyright © 2025 - QBit Tech</p>
            </div>
        </div>
        
        <div class="login-section">
            <div class="mx-auto text-center mb-4">
                <img src="{{ asset('assets/images/QBit-BMS_Logo-2.png') }}" class="img-fluid" width="150px" alt="Logo">
            </div>
            <div class="text-center">
                <h2 class="fs-30 mb-2 qb-card-header-title-md">Sign In</h2>
                <p class="mb-4">Unlock Ultimate Efficiency with the Complete Suite.</p>
            </div>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label class="small-label-text" for="username">Username</label>
                    <div class="input-group">
                        <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control custom-input @error('username') is-invalid @enderror" placeholder="Enter your username" required autofocus>
                        <span class="input-group-text custom-input"><i class='bx bx-user'></i></span>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="small-label-text" for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control custom-input @error('password') is-invalid @enderror" placeholder="Enter your password" required>
                        <span class="input-group-text custom-input" id="togglePassword" ><i class='bx bx-low-vision'></i></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }} style="background-color: rgba(255,255,255,0.2); border-color: rgba(255,255,255,0.3);">
                        <label class="form-check-label small-label-text" for="rememberMe">Remember Me</label>
                    </div>
                    <button type="button" class="btn btn-link text-decoration-none p-0 small-label-text" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                        Forgot Password?
                    </button>
                </div>
                <div class="mb-3"><button type="submit" class="btn btn-primary w-100">Sign In</button></div>
            </form>

            <div class="text-center mt-3">
                <p class="fw-normal mb-0">Don't have an account? <a href="#" class="hover-a" data-bs-toggle="modal" data-bs-target="#registerModal">Create Account</a></p>
            </div>
        </div>
    </div>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-recovery">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4" style="min-height: 480px;">
                    <div class="text-center mb-4">
                        <div class="recovery-illustration mb-3">
                            <div class="illustration-container">
                                <div class="shield-icon">
                                    <i class='bx bx-shield-check'></i>
                                </div>
                            </div>
                        </div>
                        <img src="{{ asset('assets/images/QBit-BMS_Logo-2.png') }}" class="img-fluid" width="100px" alt="Logo">
                    </div>
                    <div class="text-center mb-4">
                        <h2 class="fs-24 mb-2 qb-card-header-title-md">Account Recovery</h2>
                        <p class="mb-0 text-muted">Choose your preferred method to reset your password</p>
                    </div>
                    <div class="recovery-methods mb-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <button type="button" class="btn btn-soft-primary w-100 h-100 p-3" onclick="selectRecoveryMethod('email')">
                                    <div class="text-center">
                                        <i class='bx bx-envelope fs-24 mb-2'></i>
                                        <div class="fw-semibold">Send Reset Link</div>
                                        <small class="text-muted">Via Email</small>
                                    </div>
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-soft-success w-100 h-100 p-3" onclick="selectRecoveryMethod('phone')">
                                    <div class="text-center">
                                        <i class='bx bx-message-dots fs-24 mb-2'></i>
                                        <div class="fw-semibold">Send Verification Code</div>
                                        <small class="text-muted">Via SMS</small>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-buttons text-center">
                        <button type="button" class="btn btn-soft-secondary me-2" data-bs-dismiss="modal">
                            <i class='bx bx-arrow-back me-1'></i>Back to Sign In
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="emailRecoveryModal" tabindex="-1" aria-labelledby="emailRecoveryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-recovery">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4" style="min-height: 480px;">
                    <div class="text-center mb-4">
                        <div class="recovery-illustration mb-3">
                            <div class="illustration-container">
                                <div class="email-icon">
                                    <i class='bx bx-envelope'></i>
                                </div>
                            </div>
                        </div>
                        <h2 class="fs-24 mb-2 qb-card-header-title-md">Email Recovery</h2>
                        <p class="mb-0 text-muted">Enter your registered email address</p>
                    </div>
                    <form id="emailRecoveryForm">
                        <div class="form-group mb-3">
                            <label class="small-label-text">Email Address</label>
                            <div class="input-group">
                                <input type="email" class="form-control custom-input" placeholder="Enter your email address" required>
                                <span class="input-group-text custom-input border-start-0"><i class='bx bx-envelope'></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-soft-primary w-100">
                                <i class='bx bx-paper-plane me-2'></i>Send Reset Link
                            </button>
                        </div>
                        <div class="modal-footer-buttons text-center">
                            <button type="button" class="btn btn-soft-secondary me-2" onclick="goBackToMethodSelection()">
                                <i class='bx bx-arrow-back me-1'></i>Choose Different Method
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="phoneRecoveryModal" tabindex="-1" aria-labelledby="phoneRecoveryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-recovery">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4" style="min-height: 480px;">
                    <div class="text-center mb-4">
                        <div class="recovery-illustration mb-3">
                            <div class="illustration-container">
                                <div class="phone-icon">
                                    <i class='bx bx-phone'></i>
                                </div>
                            </div>
                        </div>
                        <h2 class="fs-24 mb-2 qb-card-header-title-md">Phone Recovery</h2>
                        <p class="mb-0 text-muted">Enter your registered phone number</p>
                    </div>
                    <form id="phoneRecoveryForm">
                        <div class="form-group mb-3">
                            <label class="small-label-text">Phone Number</label>
                            <div class="input-group">
                                <select class="form-select custom-input" style="max-width: 100px;">
                                    <option>+880</option>
                                    <option>+1</option>
                                    <option>+44</option>
                                </select>
                                <input type="tel" class="form-control custom-input" placeholder="Enter phone number" required>
                                <span class="input-group-text custom-input border-start-0"><i class='bx bx-phone'></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-soft-success w-100">
                                <i class='bx bx-message-dots me-2'></i>Send OTP
                            </button>
                        </div>
                        <div class="modal-footer-buttons text-center">
                            <button type="button" class="btn btn-soft-secondary me-2" onclick="goBackToMethodSelection()">
                                <i class='bx bx-arrow-back me-1'></i>Choose Different Method
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="otpVerificationModal" tabindex="-1" aria-labelledby="otpVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-recovery">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4" style="min-height: 480px;">
                    <div class="text-center mb-4">
                        <div class="recovery-illustration mb-3">
                            <div class="illustration-container">
                                <div class="otp-icon">
                                    <i class='bx bx-shield-check'></i>
                                </div>
                            </div>
                        </div>
                        <h2 class="fs-24 mb-2 qb-card-header-title-md">Verify OTP</h2>
                        <p class="mb-0 text-muted">Enter the 6-digit code sent to your phone</p>
                    </div>
                    <form id="otpVerificationForm">
                        <div class="otp-input-group mb-4">
                            <div class="d-flex justify-content-center gap-2">
                                <input type="text" class="form-control otp-input text-center" maxlength="1" required>
                                <input type="text" class="form-control otp-input text-center" maxlength="1" required>
                                <input type="text" class="form-control otp-input text-center" maxlength="1" required>
                                <input type="text" class="form-control otp-input text-center" maxlength="1" required>
                                <input type="text" class="form-control otp-input text-center" maxlength="1" required>
                                <input type="text" class="form-control otp-input text-center" maxlength="1" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-soft-warning w-100">
                                <i class='bx bx-check-circle me-2'></i>Verify OTP
                            </button>
                        </div>
                        <div class="text-center mb-3">
                            <p class="mb-0">
                                <small class="text-muted">Didn't receive the code? </small>
                                <button type="button" class="btn btn-soft-primary btn-sm" onclick="resendOTP()">Resend OTP</button>
                            </p>
                        </div>
                        <div class="modal-footer-buttons text-center">
                            <button type="button" class="btn btn-soft-secondary me-2" onclick="goBackToMethodSelection()">
                                <i class='bx bx-arrow-back me-1'></i>Choose Different Method
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createPasswordModal" tabindex="-1" aria-labelledby="createPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-recovery">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4" style="min-height: 480px;">
                    <div class="text-center mb-4">
                        <div class="recovery-illustration mb-3">
                            <div class="illustration-container">
                                <div class="password-icon">
                                    <i class='bx bx-lock-alt'></i>
                                </div>
                            </div>
                        </div>
                        <img src="{{ asset('assets/img/QBit-Tech_new_Logo-Design.png') }}" class="img-fluid" width="80px" alt="Logo">
                    </div>
                    <div class="text-center mb-4">
                        <h2 class="fs-24 mb-2 qb-card-header-title-md">Create New Password</h2>
                        <p class="mb-0 text-muted">Your new password must be different from the previous one.</p>
                    </div>
                    <form id="createPasswordForm">
                        <div class="form-group mb-3">
                            <label class="small-label-text">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control custom-input" required>
                                <span class="input-group-text custom-input border-start-0"><i class='bx bx-lock-alt'></i></span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small-label-text">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control custom-input" required>
                                <span class="input-group-text custom-input border-start-0"><i class='bx bx-lock-alt'></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-soft-primary w-100">Reset Password</button>
                        </div>
                        <div class="modal-footer-buttons text-center">
                            <button type="button" class="btn btn-soft-secondary" data-bs-dismiss="modal">
                                <i class='bx bx-home me-1'></i>Back to Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <div class="text-center mb-4">
                        <div class="recovery-illustration mb-3">
                            <div class="illustration-container">
                               <div class="shield-icon">
                                    <i class='bx bx-user-plus'></i>
                                </div>
                            </div>
                        </div>
                        <h2 class="fs-24 mb-2 qb-card-header-title-md">Create an Account</h2>
                        <p class="mb-0 text-muted">Join us to streamline your business operations</p>
                    </div>
                    <form class="px-4 pb-4">
                        <div class="form-group mb-3">
                            <label class="small-label-text">Full Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control custom-input" required>
                                <span class="input-group-text custom-input border-start-0"><i class='bx bx-user'></i></span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small-label-text">Email Address</label>
                            <div class="input-group">
                                <input type="email" class="form-control custom-input" required>
                                <span class="input-group-text custom-input border-start-0"><i class='bx bx-envelope'></i></span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small-label-text">Mobile Number</label>
                            <div class="input-group">
                                <select class="form-select custom-input" style="max-width: 100px;">
                                    <option>+880</option>
                                </select>
                                <input type="tel" class="form-control custom-input" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small-label-text">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control custom-input" required>
                                <span class="input-group-text custom-input border-start-0"><i class='bx bx-lock-alt'></i></span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small-label-text">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control custom-input" required>
                                <span class="input-group-text custom-input border-start-0"><i class='bx bx-lock-alt'></i></span>
                            </div>
                        </div>
                        <div class="mb-3 mt-4">
                            <button type="submit" class="btn btn-primary w-100">Create Account</button>
                        </div>
                        <div class="modal-footer-buttons text-center">
                            <button type="button" class="btn btn-soft-secondary" data-bs-dismiss="modal">
                                <i class='bx bx-arrow-back me-1'></i>Back to Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Recovery Method Selection
        function selectRecoveryMethod(method) {
            var forgotModal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));

            forgotModal.hide();
            
            setTimeout(() => {
                const targetModal = (method === 'email') ? 'emailRecoveryModal' : 'phoneRecoveryModal';
                new bootstrap.Modal(document.getElementById(targetModal)).show();
            }, 300);
        }

        // Go back to method selection
        function goBackToMethodSelection() {
            ['emailRecoveryModal', 'phoneRecoveryModal', 'otpVerificationModal', 'createPasswordModal'].forEach(id => {
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById(id));
                if (modalInstance) modalInstance.hide();
            });
            setTimeout(() => new bootstrap.Modal(document.getElementById('forgotPasswordModal')).show(), 300);
        }

        // Form Handlers to show next modal
        document.getElementById('emailRecoveryForm').addEventListener('submit', e => {
            e.preventDefault();
            bootstrap.Modal.getInstance(document.getElementById('emailRecoveryModal')).hide();
            setTimeout(() => new bootstrap.Modal(document.getElementById('createPasswordModal')).show(), 300);
        });

        document.getElementById('phoneRecoveryForm').addEventListener('submit', e => {
            e.preventDefault();
            bootstrap.Modal.getInstance(document.getElementById('phoneRecoveryModal')).hide();
            setTimeout(() => new bootstrap.Modal(document.getElementById('otpVerificationModal')).show(), 300);
        });

        document.getElementById('otpVerificationForm').addEventListener('submit', e => {
            e.preventDefault();
            bootstrap.Modal.getInstance(document.getElementById('otpVerificationModal')).hide();
            setTimeout(() => new bootstrap.Modal(document.getElementById('createPasswordModal')).show(), 300);
        });

        document.getElementById('createPasswordForm').addEventListener('submit', e => {
            e.preventDefault();
            bootstrap.Modal.getInstance(document.getElementById('createPasswordModal')).hide();
            setTimeout(() => alert('Password Reset Successful!'), 300);
        });

        // OTP Input Auto-focus and Navigation
        const otpInputs = document.querySelectorAll('.otp-input');
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', e => {
                if (e.key === 'Backspace' && input.value === '' && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        // Resend OTP Function
        function resendOTP() {
            alert('A new OTP has been sent to your phone.');
        }
    </script>

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
        });
    </script>
</body>
</html>
