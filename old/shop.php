<?php include 'include/header.php';?>
<!-- About: Hero -->
<section class="banner-two">
   <div class="banner-two__slider swiper">
      <div class="swiper-wrapper">
         <div class="swiper-slide">
            <div class="banner-two__slider-single">
               <div class="banner-two__slider-bg" data-background="assets/images/Rosa-Slider-1.jpg"></div>
               <div class="container">
                  <div class="row">
                     <div class="col-12 col-lg-10 m-auto">
                        <div class="banner-two__slider-content text-center">
                           <span class="sub-title-main text-white">
                           <i class="bx bxs-city"></i> ROSA Properties Ltd. — a sister concern of ROSA NGO
                           </span>
                           <h2 class="title-animation">Explore Our <span>Product Categories</span></h2>
                           <p class="text-white mt-2 mb-5">
                              We are a Bangladesh-based real estate developer delivering sustainable apartments,
                              co-ownership housing, hotel shares and commercial spaces across prime locations in Dhaka
                              and Cox’s Bazar. Our promise is simple: quality construction, transparent process and on-time handover.
                           </p>
                           <a href="all-property.php" class="apece-primary-button mt-5 text-center">Explore Properties
                           <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- /slide -->
      </div>
   </div>
</section>
<!-- ==== shop section start ==== -->
<section class="shop">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12 col-md-4 col-lg-3">
            <div class="shop__sidebar">
               <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  <div class="intro">
                     <h5>search here</h5>
                  </div>
                  <form action="#" method="post">
                     <input type="text" name="search-product" id="searchProduct" placeholder="Search Here..."
                        required>
                     <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                  </form>
               </div>
               <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  <div class="intro">
                     <h5>Categories</h5>
                  </div>
                  <div class="sidebar-list">
                     <ul>
                        <li><a href="shop.html"><i class="fa-solid fa-angle-right"></i>Brochures</a></li>
                        <li><a href="shop.html"><i class="fa-solid fa-angle-right"></i>Business Cards</a></li>
                        <li><a href="shop.html"><i class="fa-solid fa-angle-right"></i>Calendars printing</a></li>
                        <li><a href="shop.html"><i class="fa-solid fa-angle-right"></i>Design Online</a></li>
                        <li><a href="shop.html"><i class="fa-solid fa-angle-right"></i>Flyers Design</a></li>
                        <li><a href="shop.html"><i class="fa-solid fa-angle-right"></i>Folded Leaflets</a></li>
                        <li><a href="shop.html"><i class="fa-solid fa-angle-right"></i>t-shirt printing</a></li>
                        <li><a href="shop.html"><i class="fa-solid fa-angle-right"></i>Gift item printing</a></li>
                     </ul>
                  </div>
               </div>
               <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  <div class="intro">
                     <h5>Filter By Price</h5>
                  </div>
                  <div class="filter-wrapper">
                     <div class="price-slide">
                        <input class="range__slider" type="range" name="price__range" id="priceRange" max="200"
                           min="1" value="100">
                     </div>
                     <div class="filter-cta">
                        <p>$0 - $200</p>
                        <button class="btn--primary" aria-label="filter" title="filter">Filter</button>
                     </div>
                  </div>
               </div>
               <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  <div class="intro">
                     <h5>Select By Size</h5>
                  </div>
                  <div class="size-wrapper">
                     <div class="radio-single">
                        <input type="radio" id="sizeOne" name="donation-payment" checked>
                        <label for="sizeOne">36"x80" (8)</label>
                     </div>
                     <div class="radio-single">
                        <input type="radio" id="sizeTwo" name="donation-payment">
                        <label for="sizeTwo">36"x96" (60)</label>
                     </div>
                     <div class="radio-single">
                        <input type="radio" id="sizeThree" name="donation-payment">
                        <label for="sizeThree">72"x80" (7)</label>
                     </div>
                     <div class="radio-single">
                        <input type="radio" id="sizeFour" name="donation-payment">
                        <label for="sizeFour">72"x96" (21)</label>
                     </div>
                  </div>
               </div>
               <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  <div class="intro">
                     <h5>Filter By Ratings</h5>
                  </div>
                  <div class="review-wrapper size-wrapper">
                     <div class="radio-single">
                        <input type="radio" id="reviewOne" name="donation-payment" checked>
                        <label for="reviewOne">
                        <span class="review">
                        <i class="icon-star checked"></i>
                        <i class="icon-star checked"></i>
                        <i class="icon-star checked"></i>
                        <i class="icon-star checked"></i>
                        <i class="icon-star checked"></i>
                        </span>
                        (5 Star)
                        </label>
                     </div>
                     <div class="radio-single">
                        <input type="radio" id="reviewTwo" name="donation-payment">
                        <label for="reviewTwo"><span class="review">
                        <i class="icon-star checked"></i>
                        <i class="icon-star checked"></i>
                        <i class="icon-star checked"></i>
                        <i class="icon-star checked"></i>
                        <i class="icon-star"></i>
                        </span>
                        (4 Star)</label>
                     </div>
                     <div class="radio-single">
                        <input type="radio" id="reviewThree" name="donation-payment">
                        <label for="reviewThree"><span class="review">
                        <i class="icon-star checked"></i>
                        <i class="icon-star checked"></i>
                        <i class="icon-star checked"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        </span>
                        (3 Star)</label>
                     </div>
                     <div class="radio-single">
                        <input type="radio" id="reviewFour" name="donation-payment">
                        <label for="reviewFour"><span class="review">
                        <i class="icon-star checked"></i>
                        <i class="icon-star checked"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        </span>
                        (2 Star)</label>
                     </div>
                     <div class="radio-single">
                        <input type="radio" id="reviewFive" name="donation-payment">
                        <label for="reviewFive"><span class="review">
                        <i class="icon-star checked"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        <i class="icon-star"></i>
                        </span>
                        (1 Star)</label>
                     </div>
                  </div>
               </div>
               <div class="shop-sidebar-widget" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  <div class="intro">
                     <h5>Popular Tags</h5>
                  </div>
                  <div class="tag-wrapper">
                     <a href="shop.html">t-shirt</a>
                     <a href="shop.html">Banner Design</a>
                     <a href="shop.html">Brochures</a>
                     <a href="shop.html">Landing</a>
                     <a href="shop.html">Print</a>
                     <a href="shop.html">Business Card</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 col-md-8 col-lg-9">
            <div class="shop__content">
               <div class="shop__content-intro">
                  <div class="shop-intro__left">
                     <p>Showing <strong>12</strong> of 21 Results</p>
                  </div>
                  <div class="shop-intro__right">
                     <div class="shop-right-single">
                        <p>Sort By:</p>
                     </div>
                     <div class="shop-right-single">
                        <button aria-label="sort by time" title="sort by time">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        </button>
                        <select name="price" class="price-select select">
                           <option value="high">High</option>
                           <option value="low">Low</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                     <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
                        <div class="property-list-img-area position-relative owl-carousel">
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 3.png" alt="Men's Casual Shirt"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 2.png" alt="Shirt Model"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 1.png" alt="Shirt Details"></div>
                           </a>
                           <div class="position-absolute top-0 start-0 p-2">
                              <span class="badge bg-primary me-1">New</span><span class="badge bg-warning">Bestseller</span>
                           </div>
                        </div>
                        <div class="property-single-content">
                           <h4 class="title-animation"><a href="product-details.php">Men's Casual Shirt - Blue</a></h4>
                           <p class="m-0"><i class='bx bxs-tag me-1'></i>Category: Men's Fashion</p>
                        </div>
                        <div class="property-details">
                           <ul class="d-flex align-items-center">
                              <li class="w-50"><i class='bx bx-coin-stack me-1'></i>$25.00</li>
                              <li class="w-50"><i class='bx bx-package me-1'></i>In Stock</li>
                           </ul>
                        </div>
                        <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
                           <a href="product-details.php" class="action-btn-success p-3 h-30px w-auto rounded-3"><i class="bx bx-show fs-15 me-1"></i>View</a>
                           <a href="#" title="Add to Wishlist" data-id="1" class="action-btn-danger p-3 ms-2 h-30px w-30px rounded-5">
                           <i class="bx bxs-heart fs-20"></i></a>
                           <a href="#" title="Add to Cart" data-id="1" class="action-btn-success p-3 ms-2 h-30px w-auto rounded-3">
                           <i class="bx bxs-cart fs-15 me-1"></i>Cart</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                     <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
                        <div class="property-list-img-area position-relative owl-carousel">
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 3.png" alt="Men's Casual Shirt"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 2.png" alt="Shirt Model"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 1.png" alt="Shirt Details"></div>
                           </a>
                           <div class="position-absolute top-0 start-0 p-2">
                              <span class="badge bg-primary me-1">New</span><span class="badge bg-warning">Bestseller</span>
                           </div>
                        </div>
                        <div class="property-single-content">
                           <h4 class="title-animation"><a href="product-details.php">Men's Casual Shirt - Blue</a></h4>
                           <p class="m-0"><i class='bx bxs-tag me-1'></i>Category: Men's Fashion</p>
                        </div>
                        <div class="property-details">
                           <ul class="d-flex align-items-center">
                              <li class="w-50"><i class='bx bx-coin-stack me-1'></i>$25.00</li>
                              <li class="w-50"><i class='bx bx-package me-1'></i>In Stock</li>
                           </ul>
                        </div>
                        <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
                           <a href="product-details.php" class="action-btn-success p-3 h-30px w-auto rounded-3"><i class="bx bx-show fs-15 me-1"></i>View</a>
                           <a href="#" title="Add to Wishlist" data-id="1" class="action-btn-danger p-3 ms-2 h-30px w-30px rounded-5">
                           <i class="bx bxs-heart fs-20"></i></a>
                           <a href="#" title="Add to Cart" data-id="1" class="action-btn-success p-3 ms-2 h-30px w-auto rounded-3">
                           <i class="bx bxs-cart fs-15 me-1"></i>Cart</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                     <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
                        <div class="property-list-img-area position-relative owl-carousel">
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 3.png" alt="Men's Casual Shirt"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 2.png" alt="Shirt Model"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 1.png" alt="Shirt Details"></div>
                           </a>
                           <div class="position-absolute top-0 start-0 p-2">
                              <span class="badge bg-primary me-1">New</span><span class="badge bg-warning">Bestseller</span>
                           </div>
                        </div>
                        <div class="property-single-content">
                           <h4 class="title-animation"><a href="product-details.php">Men's Casual Shirt - Blue</a></h4>
                           <p class="m-0"><i class='bx bxs-tag me-1'></i>Category: Men's Fashion</p>
                        </div>
                        <div class="property-details">
                           <ul class="d-flex align-items-center">
                              <li class="w-50"><i class='bx bx-coin-stack me-1'></i>$25.00</li>
                              <li class="w-50"><i class='bx bx-package me-1'></i>In Stock</li>
                           </ul>
                        </div>
                        <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
                           <a href="product-details.php" class="action-btn-success p-3 h-30px w-auto rounded-3"><i class="bx bx-show fs-15 me-1"></i>View</a>
                           <a href="#" title="Add to Wishlist" data-id="1" class="action-btn-danger p-3 ms-2 h-30px w-30px rounded-5">
                           <i class="bx bxs-heart fs-20"></i></a>
                           <a href="#" title="Add to Cart" data-id="1" class="action-btn-success p-3 ms-2 h-30px w-auto rounded-3">
                           <i class="bx bxs-cart fs-15 me-1"></i>Cart</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                     <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
                        <div class="property-list-img-area position-relative owl-carousel">
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 3.png" alt="Men's Casual Shirt"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 2.png" alt="Shirt Model"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 1.png" alt="Shirt Details"></div>
                           </a>
                           <div class="position-absolute top-0 start-0 p-2">
                              <span class="badge bg-primary me-1">New</span><span class="badge bg-warning">Bestseller</span>
                           </div>
                        </div>
                        <div class="property-single-content">
                           <h4 class="title-animation"><a href="product-details.php">Men's Casual Shirt - Blue</a></h4>
                           <p class="m-0"><i class='bx bxs-tag me-1'></i>Category: Men's Fashion</p>
                        </div>
                        <div class="property-details">
                           <ul class="d-flex align-items-center">
                              <li class="w-50"><i class='bx bx-coin-stack me-1'></i>$25.00</li>
                              <li class="w-50"><i class='bx bx-package me-1'></i>In Stock</li>
                           </ul>
                        </div>
                        <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
                           <a href="product-details.php" class="action-btn-success p-3 h-30px w-auto rounded-3"><i class="bx bx-show fs-15 me-1"></i>View</a>
                           <a href="#" title="Add to Wishlist" data-id="1" class="action-btn-danger p-3 ms-2 h-30px w-30px rounded-5">
                           <i class="bx bxs-heart fs-20"></i></a>
                           <a href="#" title="Add to Cart" data-id="1" class="action-btn-success p-3 ms-2 h-30px w-auto rounded-3">
                           <i class="bx bxs-cart fs-15 me-1"></i>Cart</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                     <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
                        <div class="property-list-img-area position-relative owl-carousel">
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 3.png" alt="Men's Casual Shirt"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 2.png" alt="Shirt Model"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 1.png" alt="Shirt Details"></div>
                           </a>
                           <div class="position-absolute top-0 start-0 p-2">
                              <span class="badge bg-primary me-1">New</span><span class="badge bg-warning">Bestseller</span>
                           </div>
                        </div>
                        <div class="property-single-content">
                           <h4 class="title-animation"><a href="product-details.php">Men's Casual Shirt - Blue</a></h4>
                           <p class="m-0"><i class='bx bxs-tag me-1'></i>Category: Men's Fashion</p>
                        </div>
                        <div class="property-details">
                           <ul class="d-flex align-items-center">
                              <li class="w-50"><i class='bx bx-coin-stack me-1'></i>$25.00</li>
                              <li class="w-50"><i class='bx bx-package me-1'></i>In Stock</li>
                           </ul>
                        </div>
                        <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
                           <a href="product-details.php" class="action-btn-success p-3 h-30px w-auto rounded-3"><i class="bx bx-show fs-15 me-1"></i>View</a>
                           <a href="#" title="Add to Wishlist" data-id="1" class="action-btn-danger p-3 ms-2 h-30px w-30px rounded-5">
                           <i class="bx bxs-heart fs-20"></i></a>
                           <a href="#" title="Add to Cart" data-id="1" class="action-btn-success p-3 ms-2 h-30px w-auto rounded-3">
                           <i class="bx bxs-cart fs-15 me-1"></i>Cart</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                     <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
                        <div class="property-list-img-area position-relative owl-carousel">
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 3.png" alt="Men's Casual Shirt"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 2.png" alt="Shirt Model"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 1.png" alt="Shirt Details"></div>
                           </a>
                           <div class="position-absolute top-0 start-0 p-2">
                              <span class="badge bg-primary me-1">New</span><span class="badge bg-warning">Bestseller</span>
                           </div>
                        </div>
                        <div class="property-single-content">
                           <h4 class="title-animation"><a href="product-details.php">Men's Casual Shirt - Blue</a></h4>
                           <p class="m-0"><i class='bx bxs-tag me-1'></i>Category: Men's Fashion</p>
                        </div>
                        <div class="property-details">
                           <ul class="d-flex align-items-center">
                              <li class="w-50"><i class='bx bx-coin-stack me-1'></i>$25.00</li>
                              <li class="w-50"><i class='bx bx-package me-1'></i>In Stock</li>
                           </ul>
                        </div>
                        <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
                           <a href="product-details.php" class="action-btn-success p-3 h-30px w-auto rounded-3"><i class="bx bx-show fs-15 me-1"></i>View</a>
                           <a href="#" title="Add to Wishlist" data-id="1" class="action-btn-danger p-3 ms-2 h-30px w-30px rounded-5">
                           <i class="bx bxs-heart fs-20"></i></a>
                           <a href="#" title="Add to Cart" data-id="1" class="action-btn-success p-3 ms-2 h-30px w-auto rounded-3">
                           <i class="bx bxs-cart fs-15 me-1"></i>Cart</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                     <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
                        <div class="property-list-img-area position-relative owl-carousel">
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 3.png" alt="Men's Casual Shirt"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 2.png" alt="Shirt Model"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 1.png" alt="Shirt Details"></div>
                           </a>
                           <div class="position-absolute top-0 start-0 p-2">
                              <span class="badge bg-primary me-1">New</span><span class="badge bg-warning">Bestseller</span>
                           </div>
                        </div>
                        <div class="property-single-content">
                           <h4 class="title-animation"><a href="product-details.php">Men's Casual Shirt - Blue</a></h4>
                           <p class="m-0"><i class='bx bxs-tag me-1'></i>Category: Men's Fashion</p>
                        </div>
                        <div class="property-details">
                           <ul class="d-flex align-items-center">
                              <li class="w-50"><i class='bx bx-coin-stack me-1'></i>$25.00</li>
                              <li class="w-50"><i class='bx bx-package me-1'></i>In Stock</li>
                           </ul>
                        </div>
                        <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
                           <a href="product-details.php" class="action-btn-success p-3 h-30px w-auto rounded-3"><i class="bx bx-show fs-15 me-1"></i>View</a>
                           <a href="#" title="Add to Wishlist" data-id="1" class="action-btn-danger p-3 ms-2 h-30px w-30px rounded-5">
                           <i class="bx bxs-heart fs-20"></i></a>
                           <a href="#" title="Add to Cart" data-id="1" class="action-btn-success p-3 ms-2 h-30px w-auto rounded-3">
                           <i class="bx bxs-cart fs-15 me-1"></i>Cart</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                     <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
                        <div class="property-list-img-area position-relative owl-carousel">
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 3.png" alt="Men's Casual Shirt"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 2.png" alt="Shirt Model"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 1.png" alt="Shirt Details"></div>
                           </a>
                           <div class="position-absolute top-0 start-0 p-2">
                              <span class="badge bg-primary me-1">New</span><span class="badge bg-warning">Bestseller</span>
                           </div>
                        </div>
                        <div class="property-single-content">
                           <h4 class="title-animation"><a href="product-details.php">Men's Casual Shirt - Blue</a></h4>
                           <p class="m-0"><i class='bx bxs-tag me-1'></i>Category: Men's Fashion</p>
                        </div>
                        <div class="property-details">
                           <ul class="d-flex align-items-center">
                              <li class="w-50"><i class='bx bx-coin-stack me-1'></i>$25.00</li>
                              <li class="w-50"><i class='bx bx-package me-1'></i>In Stock</li>
                           </ul>
                        </div>
                        <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
                           <a href="product-details.php" class="action-btn-success p-3 h-30px w-auto rounded-3"><i class="bx bx-show fs-15 me-1"></i>View</a>
                           <a href="#" title="Add to Wishlist" data-id="1" class="action-btn-danger p-3 ms-2 h-30px w-30px rounded-5">
                           <i class="bx bxs-heart fs-20"></i></a>
                           <a href="#" title="Add to Cart" data-id="1" class="action-btn-success p-3 ms-2 h-30px w-auto rounded-3">
                           <i class="bx bxs-cart fs-15 me-1"></i>Cart</a>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                     <div class="property-single-boxarea p-0" data-aos="fade-up" data-aos-duration="1000">
                        <div class="property-list-img-area position-relative owl-carousel">
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 3.png" alt="Men's Casual Shirt"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 2.png" alt="Shirt Model"></div>
                           </a>
                           <a href="product-details.php">
                              <div class="img1 image-anime"><img src="assets/images/shop/KHPP-SA22 - 1.png" alt="Shirt Details"></div>
                           </a>
                           <div class="position-absolute top-0 start-0 p-2">
                              <span class="badge bg-primary me-1">New</span><span class="badge bg-warning">Bestseller</span>
                           </div>
                        </div>
                        <div class="property-single-content">
                           <h4 class="title-animation"><a href="product-details.php">Men's Casual Shirt - Blue</a></h4>
                           <p class="m-0"><i class='bx bxs-tag me-1'></i>Category: Men's Fashion</p>
                        </div>
                        <div class="property-details">
                           <ul class="d-flex align-items-center">
                              <li class="w-50"><i class='bx bx-coin-stack me-1'></i>$25.00</li>
                              <li class="w-50"><i class='bx bx-package me-1'></i>In Stock</li>
                           </ul>
                        </div>
                        <div class="mt-0 pt-0 btn-area1 text-center d-flex align-items-center justify-content-center">
                           <a href="product-details.php" class="action-btn-success p-3 h-30px w-auto rounded-3"><i class="bx bx-show fs-15 me-1"></i>View</a>
                           <a href="#" title="Add to Wishlist" data-id="1" class="action-btn-danger p-3 ms-2 h-30px w-30px rounded-5">
                           <i class="bx bxs-heart fs-20"></i></a>
                           <a href="#" title="Add to Cart" data-id="1" class="action-btn-success p-3 ms-2 h-30px w-auto rounded-3">
                           <i class="bx bxs-cart fs-15 me-1"></i>Cart</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="pagination-wrapper" data-aos="fade-up" data-aos-duration="1000">
                        <ul class="pagination main-pagination">
                           <li>
                              <button>
                              <i class="fa-solid fa-angles-left"></i>
                              </button>
                           </li>
                           <li>
                              <a href="blog-list.html">1</a>
                           </li>
                           <li>
                              <a href="blog-list.html" class="active">2</a>
                           </li>
                           <li>
                              <a href="blog-list.html">3</a>
                           </li>
                           <li>
                              <button>
                              <i class="fa-solid fa-angles-right"></i>
                              </button>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- ==== / shop section end ==== -->
<?php include 'include/footer.php';?>
