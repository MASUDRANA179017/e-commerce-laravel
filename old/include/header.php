<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <!-- #title -->
      <title>Home | GrowUp Agrotech Limited</title>
      <!-- #description -->
      <meta name="description"
         content="Official website of APECE-EEE
         Alumni Association (DU), University of Dhaka, This is the Alumni Association of
         the department of - Applied Physics, Applied Physics & Electronics, Applied Physics,
         Electronics & Communication Engineering and ELECTRICAL AND ELECTRONIC ENGINEERING
         of University of Dhaka DU, Bangladesh, Curzon Hall, Reunion Re-Union of 2015, 50
         Year Celebration, APECE Alumni DU, APE DU, AP DU, EEE - DU">
      <!-- #keywords -->
      <meta name="keywords"
         content="Official website of DU APECE-EEE Alumni Association">
      <meta name="author" content="qbit-tech.com">
      <!-- #favicon -->
      <link rel="shortcut icon" href="assets/images/DU-APECE Alumni-Favicon.png" type="image/x-icon">
      <link rel="icon" href="assets/images/DU-APECE Alumni-Favicon.png" type="image/x-icon">
      <!-- google fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com/">
      <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
      <link
         href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&amp;family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&amp;family=Nunito:ital,wght@0,200..1000;1,200..1000&amp;family=Outfit:wght@100..900&amp;display=swap"
         rel="stylesheet">
      <!--Icon CSS-->
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      <!-- main css -->
      <link rel="stylesheet" href="assets/css/main.css">
      <!-- responsive css -->
      <link rel="stylesheet" href="assets/css/responsive.css">
      <!-- update responsive css -->
      <link rel="stylesheet" href="assets/css/update-responsive.css">
      <!-- color themes -->
      <link rel="stylesheet" href="assets/css/default-theme.css" id="switch-color">
      <!-- want sticky header -->
      <link rel="stylesheet" href="assets/css/sticky-header.css">
      <!-- box layout css -->
      <link rel="stylesheet" href="assets/css/box-layout.css">
      <!-- dark mode css -->
      <link rel="stylesheet" href="assets/css/dark-mode.css">
      <!-- rtl css -->
      <link rel="stylesheet" href="assets/css/rtl.css">
      <link rel="stylesheet" href="assets/css/custom.css">
      <link rel="stylesheet" href="assets/css/aos.css">
      <link rel="stylesheet" href="assets/css/odometer.css">
      <link rel="stylesheet" href="assets/css/nice-select.css">
      <style>
         :root {
         --apece-primary-rgb: 4, 150, 255;
         --qbit-success: 10, 185, 100;
         --qbit-warning: 249, 193, 35;
         }
         .tab-contents {
         display: none
         }
         .tab-contents.current-tab {
         display: block
         }
         .vertical-tabs h5 {
         font-size: calc(16px + 2 * (100vw - 300px) / 1620);
         color: rgba(var(--dark),.8);
         font-weight: 500
         }
         .vertical-tabs span {
         color: rgba(var(--dark),.8)
         }
         .vertical-tabs .tab .step {
         width: 55px;
         height: 55px;
         text-align: center;
         font-size: 24px;
         border-radius: 5px;
         background-color: rgba(var(--secondary),.1);
         border: 1px solid rgba(var(--secondary),.2);
         color: rgba(var(--secondary),1);
         padding: 10px
         }
         .vertical-tabs .tab.current-tab .step {
         background-color: rgba(var(--primary),1);
         color: rgba(var(--white),1)
         }
         .vertical-tabs .tab.current-tab h5 {
         color: rgba(var(--primary),1)
         }
         .completed-contents {
         line-height: 250px;
         text-align: center
         }
         .tabs-steps {
         padding: 8px 14px;
         text-align: center;
         font-size: 22px;
         border-radius: 5px;
         background-color: rgba(var(--dark),.1);
         border: 1px dashed rgba(var(--dark),.6)
         cursor: pointer;
         }
         .tabs-step {
         display: flex;
         align-items: center;
         background-color: rgba(var(--secondary), .05);
         padding: 15px 20px;
         border-radius: var(--bs-border-radius);
         }
         .tabs-contents {
         display: none;
         background-color: rgba(var(--light),.05);
         padding: .5rem
         }
         .tabs-step {
         padding: 15px 20px
         }
         .tabs-area .tab {
         width: 33%;
         }
         .tabs-step .tab .step {
         padding: 8px 14px;
         text-align: center;
         font-size: 22px;
         border-radius: 5px;
         background-color: rgba(var(--secondary), .1);
         }
         .tab-contents.current {
         display: block;
         }
         .tabs-step .tab.current .step {
         background-color: rgba(var(--primary), 1);
         color: #fff;
         }
         .tab-icon-box{
         height: 40px;
         width: 40px;
         text-align: center;
         font-size: 22px;
         border-radius: 5px;
         display: inline-flex;
         justify-content: center;
         align-items: center;
         background-color: rgba(var(--apece-primary-rgb));
         color: #fff;
         }
         .tab-area{
         display: flex;
         align-items: center;
         background-color: rgba(var(--qbit-success), .1);
         padding: 7px;
         border-radius: var(--bs-border-radius);
         }
         .tab-box{
         width: 33%;
         }
         .vertical-tabs {
         display: flex;
         flex-direction: column;
         height: 100%;
         background-color: rgba(var(--apece-primary-rgb), 0.05);
         padding: 0px;
         border-radius: var(--bs-border-radius);
         cursor: pointer
         }
         .vertical-tabs .tab{
         padding: 7px;
         border-radius: 7px;
         }
         .vertical-tabs .tab.current-tab h5 {
         background: rgba(var(--apece-primary-rgb), 0.1);
         }
         .tab-contents-list {
         /*background-color: rgba(var(--secondary),.05);*/
         padding: 0px;
         border-radius: var(--bs-border-radius);
         height: 100%
         }
         @keyframes fadeIn {
         from { opacity: 0; }
         to { opacity: 1; }
         }
         .qbit-btn {
         display: inline-block;
         font-weight: 400;
         line-height: 1;
         text-align: center;
         vertical-align: middle;
         cursor: pointer;
         user-select: none;
         border: 1px solid transparent;
         border-radius: 5px;
         transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
         }
         .btn-md {
         padding: 5px 22px;
         font-size: 12px;
         line-height: 14px;
         }
         .btn-lg {
         padding: 7px 25px;
         font-size: 13px;
         line-height: 15px;
         }
         .qbit-btn-light-danger {
         background-color: rgba(var(--qbit-danger), 0.5);
         color: #640D5F;
         }
         .qbit-btn-light-danger:hover {
         background-color: rgba(var(--qbit-danger), 0.8);
         border-color: rgba(var(--qbit-danger), 0.2);
         color: #fff;
         }
         .qbit-btn-light-success {
         background-color: rgba(var(--qbit-success), 0.5);
         color: #640D5F;
         }
         .qbit-btn-light-success:hover {
         background-color: rgba(var(--qbit-success), 0.8);
         border-color: rgba(var(--qbit-success), 0.2);
         color: #fff;
         }
         .qbit-btn-light-warning {
         background-color: rgba(var(--qbit-warning), 0.5);
         color: #640D5F;
         }
         .qbit-btn-light-warning:hover {
         background-color: rgba(var(--qbit-warning), 0.8);
         border-color: rgba(var(--qbit-warning), 0.2);
         color: #fff;
         }
      </style>
   </head>
   <body>
      <div class="page-wrapper">
      <!-- preloader start -->
      <!--<div class="preloader">-->
      <!--   <i class="icon-donation"></i>-->
      <!--   <p>CHARIFUND</p>-->
      <!--</div>-->
      <!-- preloader end -->
      <!-- topbar start -->
      <div class="topbar topbar-six-area d-none d-lg-block overflow-visible z-2">
         <div class="container-fluid">
            <div class="row">
               <div class="col-12">
                  <div class="topbar-six__wrapper d-flex justify-content-between align-items-center">
                     <!-- left -->
                     <div class="topbar__list-wrapper ">
                        <ul class="topbar__list topbar-six-list">
                           <li><a class="fw-normal" href="mailto:info@growupagro.tech"><i class="fa-regular fa-envelope"></i> info@growupagro.tech</a></li>
                           <li><a class="fw-normal" href="tel: +8801713269591 "><i class="fa-solid fa-phone"></i>  +8801713269591 </a></li>
                           <li><a class="fw-normal" href="# "><i class='bx bxs-map-pin'></i> Ambon Complex 99, Mohakhali C/A, Dhaka</a></li>
                        </ul>
                     </div>
                     <!-- right -->
                     <div class="topbar-six-right">
                        <ul class="d-flex footer__bottom-list gap-4 justify-content-center justify-content-lg-end">
                           <li><a href="privacy-policy.html me-3">Sign up</a></li>
                           <li><a href="privacy-policy.html">Login</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- topbar end -->
      <!-- header start -->
      <header class="header header-tertiary header-six-area">
         <div class="container-fluid">
            <div class="row">
               <div class="col-12">
                  <div class="main-header__menu-box">
                     <nav class="navbar p-0">
                        <div class="navbar-logo">
                           <a href="index.php">
                           <img src="assets/images/682da1de004e3.png" alt="Image" height="50">
                           </a>
                        </div>
                        <div class="navbar__options">
                           <div class="header-six-navbar-space d-flex justify-content-end">
                              <nav class="navbar__menu d-none d-xl-block">
                                 <ul class="navbar__list">
                                    <li class="navbar__item nav-fade">
                                       <a href="index.php" class="">Home</a>
                                    </li>
                                    <li class="navbar__item navbar__item--has-children nav-fade">
                                       <a href="#" aria-label="dropdown menu" class="">About Us</a>
                                       <ul class="navbar__sub-menu">
                                          <li>
                                             <a href="about-association.php">About Association</a>
                                          </li>
                                          <li>
                                             <a href="certificates.php">Certificates</a>
                                          </li>
                                          <li class="navbar__item navbar__item--has-children">
                                             <a href="#" aria-label="dropdown menu" >Committee</a>
                                             <ul class="navbar__sub-menu navbar__sub-menu__nested">
                                                <li>
                                                   <a href="current-committee.php">Current Committee</a>
                                                </li>
                                                <li>
                                                   <a href="past-committee.php">Past Committee</a>
                                                </li>
                                             </ul>
                                          </li>
                                          <li>
                                             <a href="contact-us.php">Contact</a>
                                          </li>
                                       </ul>
                                    </li>
                                    <li class="navbar__item navbar__item--has-children nav-fade">
                                       <a href="#" aria-label="dropdown menu" class="">Membership</a>
                                       <ul class="navbar__sub-menu">
                                          <li>
                                             <a href="membership-criterio.php">Membership Criterio</a>
                                          </li>
                                          <li>
                                             <a href="apply-for-membership.php">Apply for Membership</a>
                                          </li>
                                          <li class="navbar__item navbar__item--has-children">
                                             <a href="#" aria-label="dropdown menu" >Member's</a>
                                             <ul class="navbar__sub-menu navbar__sub-menu__nested">
                                                <li>
                                                   <a href="alumni-member.php">Alumni Member's</a>
                                                </li>
                                                <li>
                                                   <a href="life-member.php">Life Member's</a>
                                                </li>
                                             </ul>
                                          </li>
                                          <li>
                                             <a href="distinguish-alumni.php">Distinguish Alumni</a>
                                          </li>
                                          <li>
                                             <a href="apply-for-non-member-enrollment.php">Apply for non-member enrollment</a>
                                          </li>
                                       </ul>
                                    </li>
                                    <li class="navbar__item navbar__item--has-children nav-fade">
                                       <a href="#" aria-label="dropdown menu" class="">Initiatives</a>
                                       <ul class="navbar__sub-menu">
                                          <li>
                                             <a href="blood-bank.php">Blood Bank</a>
                                          </li>
                                          <li>
                                             <a href="projects.php">Projects</a>
                                          </li>
                                          <li>
                                             <a href="scholarship.php">Scholarship Program</a>
                                          </li>
                                          <li class="navbar__item navbar__item--has-children">
                                             <a href="scholarship.php">Published Items</a>
                                             <ul class="navbar__sub-menu navbar__sub-menu__nested">
                                                <li>
                                                   <a href="current-committee.php">Magazine</a>
                                                </li>
                                                <li>
                                                   <a href="past-committee.php">--</a>
                                                </li>
                                             </ul>
                                          </li>
                                       </ul>
                                    </li>
                                    <li class="navbar__item navbar__item--has-children nav-fade">
                                       <a href="#" aria-label="dropdown menu" class="">Reports</a>
                                       <ul class="navbar__sub-menu">
                                          <li>
                                             <a href="past-committee.php">Finantial Reports</a>
                                          </li>
                                          <li>
                                             <a href="past-committee.php">General Reports</a>
                                          </li>
                                       </ul>
                                    </li>
                                    <li class="navbar__item navbar__item--has-children nav-fade">
                                       <a href="#" aria-label="dropdown menu" class="">Events</a>
                                       <ul class="navbar__sub-menu">
                                          <li>
                                             <a href="events.php">All Events</a>
                                          </li>
                                          <li>
                                             <a href="upcoming-event.php">Upcoming Event</a>
                                          </li>
                                          <li>
                                             <a href="past-event.php">Past Event</a>
                                          </li>
                                       </ul>
                                    </li>
                                    <li class="navbar__item navbar__item--has-children nav-fade">
                                       <a href="gallery.php" aria-label="dropdown menu">Gallery</a>
                                       <ul class="navbar__sub-menu">
                                          <li>
                                             <a href="album-wise-gallery.php">Album wise</a>
                                          </li>
                                          <li>
                                             <a href="year-wise-gallery.php">Year wise</a>
                                          </li>
                                          <li>
                                             <a href="batch-wise-gallery.php">Batch wise</a>
                                          </li>
                                       </ul>
                                    </li>
                                    <li class="navbar__item navbar__item--has-children nav-fade">
                                       <a href="#" aria-label="dropdown menu" class="">Notice & Download</a>
                                       <ul class="navbar__sub-menu">
                                          <li>
                                             <a href="notice-board.php">Notice Board</a>
                                          </li>
                                          <li>
                                             <a href="news.php">Latest News</a>
                                          </li>
                                          <li class="navbar__item nav-fade">
                                             <a href="career.php">Career</a>
                                          </li>
                                          <li>
                                             <a href="download.php">Downloads</a>
                                          </li>
                                       </ul>
                                    </li>
                                    <li class="navbar__item navbar__item--has-children nav-fade">
                                       <a href="#" aria-label="dropdown menu" class="">Payment</a>
                                       <ul class="navbar__sub-menu">
                                          <li>
                                             <a href="#" data-bs-toggle="modal" data-bs-target="#paymentModal">Pay Zakat</a>
                                          </li>
                                          <li>
                                             <a href="member-fees.php">Member Fees</a>
                                          </li>
                                       </ul>
                                    </li>
                                    <li>
                                       <a href="#" class="open-search" aria-label="search products" title="open search box">
                                       <i class="fa-solid fa-magnifying-glass"></i></a>
                                    </li>
                                 </ul>
                              </nav>
                           </div>
                           <div class="contact-btn">
                              <a href="event-details.html" class="btn--primary p-2 px-5">Contact Us</a>
                           </div>
                           <button class="open-offcanvas-nav d-flex d-xl-none" aria-label="toggle mobile menu"
                              title="open offcanvas menu">
                           <span class="icon-bar top-bar"></span>
                           <span class="icon-bar middle-bar"></span>
                           <span class="icon-bar bottom-bar"></span>
                           </button>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- header end -->
      <!-- mobile menu start -->
      <div class="mobile-menu d-block d-xxl-none">
         <nav class="mobile-menu__wrapper">
            <div class="mobile-menu__header nav-fade">
               <div class="logo">
                  <a href="index.php" aria-label="home page" title="logo">
                  <img src="assets/images/logo.png" alt="Image">
                  </a>
               </div>
               <button aria-label="close mobile menu" class="close-mobile-menu">
               <i class="fa-solid fa-xmark"></i>
               </button>
            </div>
            <div class="mobile-menu__list"></div>
            <div class="mobile-menu__cta nav-fade d-block d-md-none">
               <a href="donate-us.html" class="btn--primary ">Donate Now <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="mobile-menu__social social nav-fade">
               <a href="https://www.facebook.com/" target="_blank" aria-label="share us on facebook" title="facebook">
               <i class="fa-brands fa-facebook-f"></i>
               </a>
               <a href="https://vimeo.com/" target="_blank" aria-label="share us on vimeo" title="vimeo">
               <i class="fa-brands fa-vimeo-v"></i>
               </a>
               <a href="https://x.com/" target="_blank" aria-label="share us on twitter" title="twitter">
               <i class="fa-brands fa-twitter"></i>
               </a>
               <a href="https://www.linkedin.com/" target="_blank" aria-label="share us on linkedin" title="linkedin">
               <i class="fa-brands fa-linkedin-in"></i>
               </a>
            </div>
         </nav>
      </div>
      <div class="mobile-menu__backdrop"></div>
      <!-- mobile menu end -->
      <!-- search popup start -->
      <div class="search-popup">
         <button class="close-search" aria-label="close search box" title="close search box">
         <i class="fa-solid fa-xmark"></i>
         </button>
         <form action="#" method="post">
            <div class="search-popup__group">
               <input type="text" name="search-field" id="searchField" placeholder="Search...." required>
               <button type="submit" aria-label="search products" title="search products">
               <i class="fa-solid fa-magnifying-glass"></i>
               </button>
            </div>
         </form>
      </div>
      <!-- search popup end -->
      <!-- off canvas start -->
      <div class="off-canvas d-none d-xl-block">
         <div class="off-canvas__inner">
            <div class="off-canvas__head">
               <a href="index.php">
               <img src="assets/images/logo.png" alt="Logo">
               </a>
               <button aria-label="close off canvas" class="off-canvas-close">
               <i class="fa-solid fa-xmark"></i>
               </button>
            </div>
            <div class="offcanvas__search">
               <form action="#">
                  <input type="text" placeholder="What are you searching for?" required>
                  <button type="submit">
                  <i class="icon-search"></i>
                  </button>
               </form>
            </div>
            <div class="off-canvas__contact">
               <h5>Contact Info</h5>
               <div class="single">
                  <span>
                  <i class="fa-solid fa-phone-volume"></i>
                  </span>
                  <a href="tel:253-556-7777">(+1) 253 556-7777</a>
               </div>
               <div class="single">
                  <span>
                  <i class="fa-solid fa-envelope"></i>
                  </span>
                  <a href="mailto:example@support.com">example@support.com</a>
               </div>
               <div class="single">
                  <span>
                  <i class="fa-solid fa-location-dot"></i>
                  </span>
                  <a target="_blank"
                     href="https://www.google.com/maps/place/Narbethong+QLD+4725,+Australia/@-23.8173641,145.3223283,11z/data=!3m1!4b1!4m15!1m8!3m7!1s0x2b2bfd076787c5df:0x538267a1955b1352!2sAustralia!3b1!8m2!3d-25.274398!4d133.775136!16zL20vMGNoZ2h5!3m5!1s0x6bcacfb51d7e5257:0x400eef17f209750!8m2!3d-23.8656897!4d145.5354411!16s%2Fg%2F1wd3w6zw">
                  Narbethong
                  Queensland 4725
                  Australia
                  </a>
               </div>
            </div>
            <div class="social">
               <a href="https://www.facebook.com/" target="_blank" aria-label="share us on facebook" title="facebook">
               <i class="fa-brands fa-facebook-f"></i>
               </a>
               <a href="https://vimeo.com/" target="_blank" aria-label="share us on vimeo" title="vimeo">
               <i class="fa-brands fa-vimeo-v"></i>
               </a>
               <a href="https://x.com/" target="_blank" aria-label="share us on twitter" title="twitter">
               <i class="fa-brands fa-twitter"></i>
               </a>
               <a href="https://www.linkedin.com/" target="_blank" aria-label="share us on linkedin" title="linkedin">
               <i class="fa-brands fa-linkedin-in"></i>
               </a>
            </div>
         </div>
      </div>
      <div class="off-canvas-backdrop"></div>
      <!-- off canvas end -->
      <!-- sidebar cart start -->
      <div class="sidebar-cart">
         <div class="der">
            <button class="close-cart">
            <span class="close-icon">X</span>
            </button>
            <h2>
               Shopping Bag
               <span class="count">2</span>
            </h2>
            <div class="cart-items">
               <div class="cart-item-single">
                  <div class="cart-item-thumb">
                     <a href="service-details.html">
                     <img src="assets/images/cart.jpg" alt="Image">
                     </a>
                  </div>
                  <div class="cart-item-content">
                     <h6 class="h6 title-anim">
                        <a href="service-details.html">Product One</a>
                     </h6>
                     <p class="price">
                        $
                        <span class="item-price">34.99</span>
                     </p>
                     <div class="measure">
                        <button aria-label="decrease item" class="quantity-decrease">
                        <i class="fa-solid fa-minus"></i>
                        </button>
                        <span class="item-quantity">0</span>
                        <button aria-label="add item" class="quantity-increase">
                        <i class="fa-solid fa-plus"></i>
                        </button>
                     </div>
                  </div>
                  <button aria-label="delete item" class="delete-item">
                  <i class="fa-solid fa-trash"></i>
                  </button>
               </div>
               <div class="cart-item-single">
                  <div class="cart-item-thumb">
                     <a href="service-details.html">
                     <img src="assets/images/cart.jpg" alt="Image">
                     </a>
                  </div>
                  <div class="cart-item-content">
                     <h6 class="h6 title-anim">
                        <a href="service-details.html">Product Two</a>
                     </h6>
                     <p class="price">
                        $
                        <span class="item-price">34.99</span>
                     </p>
                     <div class="measure">
                        <button aria-label="decrease item" class="quantity-decrease">
                        <i class="fa-solid fa-minus"></i>
                        </button>
                        <span class="item-quantity">0</span>
                        <button aria-label="add item" class="quantity-increase">
                        <i class="fa-solid fa-plus"></i>
                        </button>
                     </div>
                  </div>
                  <button aria-label="delete item" class="delete-item">
                  <i class="fa-solid fa-trash"></i>
                  </button>
               </div>
            </div>
            <div class="totals">
               <div class="subtotal">
                  <span class="label">Subtotal:</span>
                  <span class="amount ">
                  $
                  <span class="total-price">0.00</span>
                  </span>
               </div>
            </div>
            <div class="action-buttons">
               <a class="view-cart-button" href="cart.html" aria-label="go to cart">Cart</a>
               <a class="checkout-button" href="checkout.html" aria-label="go to checkout">
               Checkout
               <i class="fa-solid fa-arrow-right-long"></i>
               </a>
            </div>
         </div>
      </div>
      <div class="cart-backdrop"></div>
      <!-- sidebar cart end -->
      <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="title-lg fs-22 fw-600" id="paymentModalLabel">Online Payment</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <div class="card-body p-0">
                     <div class="tab-area">
                        <!--Company Setting TAB-->
                        <div class="tab-box current d-flex" data-tab="tab-1">
                           <div class="tab-icon-box"><i class='bx bx-transfer-alt'></i></div>
                           <div class="px-2">
                              <h6 class="title-lg fs-18 lh-1 mb-1">Membership Fee</h6>
                              <span class="sub-title-lg">Pay your membership fee</span>
                           </div>
                        </div>
                        <!--Main TAB (Policy Management)-->
                        <div class="tab-box d-flex" data-tab="tab-2">
                           <div class="tab-icon-box"><i class='bx bx-transfer-alt'></i></div>
                           <div class="px-2">
                              <h6 class="title-lg fs-18 lh-1 mb-1">Pay Zakat</h6>
                              <span class="sub-title-lg">Contribute your Zakat</span>
                           </div>
                        </div>
                        <!-- Main TAB-->
                        <div class="tab-box d-flex" data-tab="tab-3">
                           <div class="tab-icon-box"><i class='bx bx-transfer-alt'></i></div>
                           <div class="px-2">
                              <h6 class="title-lg fs-18 lh-1 mb-1">Donation</h6>
                              <span class="sub-title-lg">Support our causes</span>
                           </div>
                        </div>
                     </div>
                     <div class="tab-contents-list main-tab-list mt-4">
                        <div id="tab-1" class="tab-contents current">
                           <div class="card">
                              <div class="card-header border-0 bg-white p-3 pt-0 pb-0">
                                 <h2 class="m-0 title-animation fs-20 w-600 text-center border-bottom">Membership Fee Form</h2>
                              </div>
                              <div class="card-body pt-0 pb-2">
                                 <form class="app-form" action="payment.php" method="POST">
                                    <input type="hidden" name="payment_type" value="Membership Fee">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Membership Type*</label>
                                             <select class="form-select custom-input" name="membership_plan" required>
                                                <option value="">Select Type</option>
                                                <option value="General Member|1000">General Member (Tk 1,000)</option>
                                                <option value="Life Member|10000">Life Member (Tk 10,000)</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Full Name*</label>
                                             <input type="text" class="form-control custom-input" name="full_name" placeholder="Enter Your Full Name" required>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Session (Batch)*</label>
                                             <input type="text" class="form-control custom-input" name="session" placeholder="e.g., 2005-06 or 15" required>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Email Address*</label>
                                             <input type="email" class="form-control custom-input" name="email" placeholder="Enter Your Email" required>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                          </div>
                                          <label>Mobile No*</label>
                                          <input type="tel" class="form-control custom-input" name="phone" placeholder="Enter Your Mobile Number" required>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Amount (Tk)*</label>
                                             <input type="number" class="form-control custom-input" name="amount" placeholder="Amount" readonly required>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="common-fields mt-3"></div>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <div id="tab-2" class="tab-contents">
                           <div class="card">
                              <div class="card-header border-0 bg-white p-3 pt-0 pb-0">
                                 <h2 class="m-0 title-animation fs-20 w-600 text-center border-bottom">Zakat Payment Form</h2>
                              </div>
                              <div class="card-body pt-0 pb-2">
                                 <form class="app-form" action="payment.php" method="POST">
                                    <input type="hidden" name="payment_type" value="Zakat">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Full Name*</label>
                                             <input type="text" class="form-control custom-input" name="full_name" placeholder="Enter Your Full Name" required>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Email Address</label>
                                             <input type="email" class="form-control custom-input" name="email" placeholder="Enter Your Email">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Mobile No</label>
                                             <input type="tel" class="form-control custom-input" name="phone" placeholder="Optional">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Amount (Tk)*</label>
                                             <input type="number" class="form-control custom-input" name="amount" placeholder="Enter Zakat Amount" required>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="common-fields mt-3"></div>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <div id="tab-3" class="tab-contents">
                           <div class="card">
                              <div class="card-header border-0 bg-white p-3 pt-0 pb-0">
                                 <h2 class="m-0 title-animation fs-20 w-600 text-center border-bottom">Donation Form</h2>
                              </div>
                              <div class="card-body pt-0 pb-2">
                                 <form class="app-form" action="payment.php" method="POST">
                                    <input type="hidden" name="payment_type" value="Donation">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Full Name*</label>
                                             <input type="text" class="form-control custom-input" name="full_name" placeholder="Enter Your Full Name" required>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Email Address</label>
                                             <input type="email" class="form-control custom-input" name="email" placeholder="Enter Your Email">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Mobile No</label>
                                             <input type="tel" class="form-control custom-input" name="phone" placeholder="Optional">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Amount (Tk)*</label>
                                             <input type="number" class="form-control custom-input" name="amount" placeholder="Enter Donation Amount" required>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="common-fields mt-3"></div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
