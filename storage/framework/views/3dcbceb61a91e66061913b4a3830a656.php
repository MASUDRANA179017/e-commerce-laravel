
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $__env->yieldContent('code'); ?> - <?php echo $__env->yieldContent('title'); ?> </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/qbit-bms-style.css')); ?>">

    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            background: linear-gradient(135deg, var(--qbit-primary-10) 0%, var(--qbit-base-10) 100%);
            overflow: hidden;
        }
        .error-container {
            position: relative;
            z-index: 2;
        }
        .bg-shape {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            opacity: 0.5;
        }
        .error-icon {
            font-size: 6rem;
            line-height: 1;
            color: var(--qbit-warning);
        }
    </style>
</head>
<body class="antialiased">
    <div class="container vh-100 d-flex justify-content-center align-items-center position-relative">

        <!-- Background SVG Shape -->
        <svg class="bg-shape" width="800" height="800" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="400" cy="400" r="400" fill="url(#paint0_linear_1_2)"/>
            <defs>
            <linearGradient id="paint0_linear_1_2" x1="0" y1="0" x2="800" y2="800" gradientUnits="userSpaceOnUse">
            <stop stop-color="#D6EBFE"/>
            <stop offset="1" stop-color="#E4E1FD"/>
            </linearGradient>
            </defs>
        </svg>

        <div class="row justify-content-center error-container">
            <div class="col-md-12">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5 text-center">
                        <div class="error-icon mb-4">
                           <?php echo $__env->yieldContent('icon'); ?>
                        </div>
                        <div class="display-4 fw-bolder" style="color: var(--qbit-primary);"><?php echo $__env->yieldContent('code'); ?></div>
                        <h1 class="fw-bold text-dark mt-3 mb-2"><?php echo $__env->yieldContent('title'); ?></h1>
                        <p class="text-secondary mb-4">
                            <?php echo $__env->yieldContent('message'); ?>
                        </p>
                        <a href="<?php echo e(url('/')); ?>" class="btn btn-primary btn-lg" style="background-color: var(--qbit-primary); border-color: var(--qbit-primary);">
                            <i class="bx bx-home-alt me-2"></i> Go To Homepage
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\QBit Dev-2\Downloads\projects\e-commerce-laravel\resources\views/errors/layout.blade.php ENDPATH**/ ?>