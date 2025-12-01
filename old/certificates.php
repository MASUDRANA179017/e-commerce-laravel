<?php include 'include/header.php';?>

<div class="page-title page-about-us position-relative overflow-hidden">
    <!-- Full background image -->
    <div class="rellax position-absolute top-0 start-0 w-100 h-100" data-rellax-speed="5" style="z-index:0;">
        <img src="/storage/uploads/cover_images/689b1c6802dfa.png" alt="" class="w-100 h-100 object-fit-cover">
    </div>

    <!-- Text content -->
    <div class="content-wrap position-relative d-flex align-items-center h-100 py-5 px-3" style="z-index:1;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="content" style="max-width:600px;">
                        <p class="sub-title text-white fs-6 mb-2">Official Recognitions &amp; Certificates</p>
                        <h1 class="title text-white display-4 mb-3">Our Credentials</h1>
                        <div class="icon-img mb-3">
                            <img src="/assets/images/item/line-throw-title.png" alt="">
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-0">
                                <li class="breadcrumb-item"><a href="index.html" class="text-white text-decoration-none">Home</a></li>
                                <li class="breadcrumb-item text-white">Certificates</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.object-fit-cover {
    object-fit: cover;
}
.page-about-us {
    height: 500px; /* Adjust height as needed */
}
</style>

<!-- certificates image and link -->

<div class="main-content pt-0">
    <section class="s-our-certificates py-5">
        <div class="container">
            <div class="row g-4">

                <!-- Certificate Card 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="certificate-card border rounded shadow-sm h-100">
                        <div class="card-thumbnail" 
                             style="background-image: url('/storage/certificates/CetBt5shT9dgf2GKCMm8vbTMG9dl2XmgMaaXGshJ.jpg');">
                        </div>
                        <div class="card-content p-3">
                            <h4 class="card-title h5 mb-2">DCCI Membership Certificate</h4>
                            <button class="btn btn-primary btn-sm">View Certificate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<!-- CSS -->
<style>
.card-thumbnail {
    width: 100%;
    height: 250px;              /* ensures the image is visible */
    background-size: cover;
    background-position: center;
    border-radius: 8px 8px 0 0; /* rounded top edges */
}
</style>

<?php include 'include/footer.php';?>
