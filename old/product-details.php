<?php include 'include/header.php';?>
<style>
   /* Styling for the new buttons */
   .product-actions {
   display: flex;
   gap: 10px;
   flex-wrap: wrap;
   }
   .quick-overview-btn, .add-to-wishlist-btn, .compare-btn {
   padding: 10px 20px;
   border: 1px solid #ccc;
   background-color: #f8f9fa;
   color: #333;
   cursor: pointer;
   font-size: 14px;
   transition: all 0.3s;
   }
   .quick-overview-btn:hover, .add-to-wishlist-btn:hover, .compare-btn:hover {
   background-color: #e2e6ea;
   }
   .product-actions .btn--primary {
   background-color: transparent;
   border: 1px solid #c4c4c4;
   color: #333;
   padding: 10px 15px;
   display: flex;
   align-items: center;
   gap: 5px;
   font-size: 14px;
   }
   .product-actions .btn--primary i {
   font-size: 18px;
   }
   /* Modal Styling */
   .modal {
   display: none;
   position: fixed;
   z-index: 1000;
   left: 0;
   top: 0;
   width: 100%;
   height: 100%;
   overflow: auto;
   background-color: rgba(0,0,0,0.4);
   padding-top: 60px;
   }
   .modal-content {
   background-color: #fefefe;
   margin: 5% auto;
   padding: 30px;
   border: 1px solid #888;
   width: 80%;
   max-width: 500px;
   position: relative;
   border-radius: 8px;
   }
   .close-btn {
   color: #aaa;
   float: right;
   font-size: 28px;
   font-weight: bold;
   }
   .close-btn:hover, .close-btn:focus {
   color: #000;
   text-decoration: none;
   cursor: pointer;
   }
   /* Displaying product count */
   .product-colors span,
   .product-sizes span {
   position: relative;
   }
   .product-colors span::after,
   .product-sizes span::after {
   content: attr(data-count);
   position: absolute;
   bottom: -15px;
   left: 50%;
   transform: translateX(-50%);
   font-size: 10px;
   color: #888;
   white-space: nowrap;
   }
</style>
<section class="product-details">
   <div class="container">
      <div class="row">
         <div class="col-12 col-md-5 col-lg-5">
            <div class="product-details__slider">
               <div class="product-details__slider-thumb">
                  <div class="product-details-slider swiper">
                     <div class="swiper-wrapper">
                        <div class="swiper-slide">
                           <div class="product-details-slider-single">
                              <img src="assets/images/shop/KHLD-KFTN01-1.jpg" alt="Image">
                           </div>
                        </div>
                        <div class="swiper-slide">
                           <div class="product-details-slider-single">
                              <img src="assets/images/shop/KHLD-KFTN02-1.jpg" alt="Image">
                           </div>
                        </div>
                        <div class="swiper-slide">
                           <div class="product-details-slider-single">
                              <img src="assets/images/shop/KHLD-KFTN03-1.jpg" alt="Image">
                           </div>
                        </div>
                        <div class="swiper-slide">
                           <div class="product-details-slider-single">
                              <img src="assets/images/shop/KHLD-KFTN04-1.jpg" alt="Image">
                           </div>
                        </div>
                        <div class="swiper-slide">
                           <div class="product-details-slider-single">
                              <img src="assets/images/shop/KHLD-KFTN05-1.jpg" alt="Image">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="product-details-slider-gallery swiper">
                  <div class="swiper-wrapper">
                     <div class="swiper-slide">
                        <div class="sm-gallery">
                           <img src="assets/images/shop/KHLD-KFTN01-1.jpg" alt="Image">
                        </div>
                     </div>
                     <div class="swiper-slide">
                        <div class="sm-gallery">
                           <img src="assets/images/shop/KHLD-KFTN02-1.jpg" alt="Image">
                        </div>
                     </div>
                     <div class="swiper-slide">
                        <div class="sm-gallery">
                           <img src="assets/images/shop/KHLD-KFTN03-1.jpg" alt="Image">
                        </div>
                     </div>
                     <div class="swiper-slide">
                        <div class="sm-gallery">
                           <img src="assets/images/shop/KHLD-KFTN04-1.jpg" alt="Image">
                        </div>
                     </div>
                     <div class="swiper-slide">
                        <div class="sm-gallery">
                           <img src="assets/images/shop/KHLD-KFTN05-1.jpg" alt="Image">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 col-md-7 col-lg-7">
            <div class="product-details__content" data-aos="fade-up" data-aos-duration="1000"
               data-aos-delay="100">
               <div class="product-meta mt-0">
                  <h3 class="title-animation mb-1">Smart Wireless Headphone</h3>
               </div>
               <div class="product-price mt-0">
                  <h6>$600</h6>
                  <h6><del>$900.00</del></h6>
               </div>
               
               <div class="card client-details-inner border rounded-3 mb-4">
                   <div class="card-header">
                       <h6 class="sub-title-main fs-16 mb-0 fw-600 lh-sm"><i class="bx bxs-analyse"></i>Quick Overview</h6>
                   </div>
                  <div class="card-body">
                      <div class="d-flex align-items-center justify-content-between">
                     <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                     <i class="bx bx-calendar-check me-1"></i>
                     Membert ID
                     </span>
                     <p class="w-60 text-dark p-0 m-0">QCL-0025</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-between pt-2">
                     <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                     <i class="bx bx-calendar-check me-1"></i>
                     Member Type
                     </span>
                     <p class="w-60 text-dark p-0 m-0">Potential Client</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-between pt-2 ">
                     <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                     <i class="bx bx-calendar-check me-1"></i>
                     Membert ID
                     </span>
                     <p class="w-60 text-dark p-0 m-0">QCL-0025</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-between pt-2">
                     <span class="title-lg fs-16 fw-600 lh-sm d-inline-flex align-items-center">
                     <i class="bx bx-calendar-check me-1"></i>
                     Member Type
                     </span>
                     <p class="w-60 text-dark p-0 m-0">Potential Client</p>
                  </div>
                  </div>
               </div>
               <div class="product-color">
                  <p class="w-10">Color:</p>
                  <div class="product-colors">
                     <span data-count="5"></span>
                     <span data-count="12"></span>
                     <span data-count="8"></span>
                     <span data-count="3"></span>
                     <span data-count="20"></span>
                  </div>
               </div>
               <div class="product-size d-flex align-items-center justify-content-start">
                  <p class="mb-0 w-10">Size:</p>
                  <div class="w-65 product-sizes-container d-flex align-items-center gap-2">
                     <div class="product-sizes">
                        <span data-count="10" class="action-btn-info fs-14 h-30px p-2 w-50px lh-1 fw-600">S</span>
                        <span data-count="15" class="action-btn-info fs-14 h-30px p-2 w-50px lh-1 fw-600">M</span>
                        <span data-count="7" class="action-btn-info fs-14 h-30px p-2 w-50px lh-1 fw-600">L</span>
                        <span data-count="4" class="action-btn-info fs-14 h-30px p-2 w-50px lh-1 fw-600">XL</span>
                        <span data-count="9" class="action-btn-info fs-14 h-30px p-2 w-50px lh-1 fw-600">XXL</span>
                     </div>
                  </div>
                  <button class="w-25 action-btn-success p-3 h-30px w-auto lh-1 fw-500 ms-5" id="openSizeModal">Size Guide</button>
               </div>
               <div class="mt-5 pt-0 mb-4 btn-area1 text-center d-flex align-items-center justify-content-start">
                  <div class="product-quantity cart-item-single mb-0">
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
                  <a href="#" title="Add to Cart" data-id="1" class="action-btn-success p-3 ms-2 h-40px w-40 rounded-3">
                  <i class="bx bxs-cart fs-15 me-1"></i> Add to Cart</a>
                  <a href="#" title="Add to Cart" data-id="1" class="btn--primary p-2 px-5 ms-2 h-40px w-40 rounded-3">
                  <i class="bx bxs-cart fs-15 me-1"></i> Buy Now</a>
               </div>
               <div class="sku">
                  <p><strong>SKU:</strong> N/A</p>
                  <p><strong>Category:</strong> Electronics</p>
                  <p><strong>Tags:</strong> mobile, gadget</p>
               </div>
               <div class="product-actions mt-3">
                  <button class="action-btn-info p-3 h-30px w-auto rounded-3" id="quickOverviewBtn">
                  <i class='bx bx-search-alt-2'></i> Quick Overview
                  </button>
                  <button class="action-btn-warning p-3 ms-2 h-30px w-auto rounded-3">
                  <i class='bx bx-heart'></i> Add to Wishlist
                  </button>
                  <button class="action-btn-primary p-3 ms-2 h-30px w-auto rounded-3" id="compareBtn">
                  <i class='bx bx-git-compare'></i> Compare
                  </button>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div id="sizeChartModal" class="modal">
   <div class="modal-content">
      <span class="close-btn">&times;</span>
      <div class="size-chart-content">
         <h4 class="mb-3">Size Chart</h4>
         <img src="assets/images/size-chart.png" alt="Size Chart Image" class="img-fluid">
      </div>
   </div>
</div>
<div id="quickOverviewModal" class="modal">
   <div class="modal-content">
      <span class="close-btn">&times;</span>
      <div class="quick-overview-content">
         <h4 class="mb-3">Quick Overview: Smart Wireless Headphone</h4>
         <div class="product-details">
            <p><strong>Product Name:</strong> Smart Wireless Headphone</p>
            <p><strong>Price:</strong> $600</p>
            <p><strong>Description:</strong> A premium quality wireless headphone with noise cancellation and long-lasting battery life. Perfect for music lovers and professionals.</p>
            <p><strong>Available Colors:</strong> Black, White, Blue, Red, Green</p>
            <p><strong>Available Sizes:</strong> S, M, L</p>
         </div>
         <a href="#" class="btn--primary mt-3">View Full Details</a>
      </div>
   </div>
</div>
<div class="product-tab">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product-tab__inner">
                    <div class="product-tab__btns">
                        <button class="product-tab__btn active" data-target="#productDetails"
                            aria-label="product details" title="product details">Product Details</button>
                        <button class="product-tab__btn" data-target="#pInformation" aria-label="product information"
                            title="product information">Additional Information</button>
                        <button class="product-tab__btn" data-target="#pReview" aria-label="product review"
                            title="product review">Reviews (10)</button>
                        <button class="product-tab__btn" data-target="#pfaq" aria-label="product faq"
                            title="product faq">FAQ</button>
                    </div>
                    <div class="product-tab__content">
                        <div class="product-tab-content-single active" id="productDetails">
                            <div class="content">
                                <h4>Men's Slim Fit Casual Shirt</h4>
                                <p>
                                    Discover effortless style and comfort with our new casual shirt. Made from a soft, breathable cotton blend, this shirt is designed for a modern slim fit that looks great for any casual occasion. The classic design and durable stitching make it a versatile addition to your wardrobe.
                                </p>
                            </div>
                            <div class="content-list cta">
                                <h5>Key Features</h5>
                                <ul>
                                    <li><i class="fa-solid fa-check"></i> Premium cotton-blend fabric</li>
                                    <li><i class="fa-solid fa-check"></i> Modern slim-fit design</li>
                                    <li><i class="fa-solid fa-check"></i> Lightweight and breathable</li>
                                    <li><i class="fa-solid fa-check"></i> Button-down collar and single chest pocket</li>
                                    <li><i class="fa-solid fa-check"></i> Ideal for all seasons</li>
                                    <li><i class="fa-solid fa-check"></i> Machine washable for easy care</li>
                                </ul>
                            </div>
                        </div>

                        <div class="product-tab-content-single" id="pInformation">
                            <div class="content">
                                <h4>Additional Product Information</h4>
                                <p>
                                    This shirt offers a perfect blend of style, comfort, and durability. It's a go-to choice for a day at the office, a casual outing with friends, or a relaxed weekend. The color is long-lasting and won't fade with regular washing.
                                </p>
                            </div>
                            <div class="content-list cta">
                                <h5>Specific Details</h5>
                                <ul>
                                    <li><i class="fa-solid fa-check"></i> **Material:** 60% Cotton, 40% Polyester</li>
                                    <li><i class="fa-solid fa-check"></i> **Style:** Full Sleeve, Slim Fit</li>
                                    <li><i class="fa-solid fa-check"></i> **Care Instructions:** Machine wash cold with like colors. Tumble dry low.</li>
                                    <li><i class="fa-solid fa-check"></i> **Size:** S, M, L, XL, XXL (Refer to our size guide for best fit)</li>
                                    <li><i class="fa-solid fa-check"></i> **Made in:** Bangladesh</li>
                                    <li><i class="fa-solid fa-check"></i> **Item Code:** SHIRT-SLIM-C-01</li>
                                </ul>
                            </div>
                        </div>

                        <div class="product-tab-content-single" id="pReview">
                            <div class="content">
                                <h4>Customer Reviews</h4>
                                <div class="review-item mb-4 pb-3 border-bottom">
                                    <h5>Great Fit and Feel!</h5>
                                    <p class="text-muted mb-1">Reviewed by Rahman K. on May 20, 2024</p>
                                    <p>I love this shirt! It fits perfectly and the fabric is incredibly soft. It's quickly become my favorite casual shirt.</p>
                                </div>
                                <div class="review-item mb-4 pb-3 border-bottom">
                                    <h5>Excellent Quality for the Price</h5>
                                    <p class="text-muted mb-1">Reviewed by Omar M. on May 15, 2024</p>
                                    <p>The quality of this shirt exceeded my expectations. The stitching is solid and the material feels premium. Definitely recommend it.</p>
                                </div>
                            </div>
                        </div>

                        <div class="product-tab-content-single" id="pfaq">
                            <div class="content">
                                <h4>Frequently Asked Questions</h4>
                                <div class="accordion" id="faqAccordion">
                                    <div class="accordion-item">
                                        <h5 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                How do I find the right size?
                                            </button>
                                        </h5>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                We recommend referring to our **Size Guide** which provides detailed measurements for each size (S, M, L, XL, XXL) to help you find the perfect fit.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Can I return the shirt if it doesn't fit?
                                            </button>
                                        </h5>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Yes, we have a hassle-free return policy. You can return the shirt within 30 days of purchase if it's unused and in its original packaging. Please see our full return policy for details.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Is this shirt available in other colors?
                                            </button>
                                        </h5>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Currently, this style is only available in the color shown. We are always adding new products, so be sure to check back for updates!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'include/footer.php';?>
<script>
   // Function to show and hide the Quick Overview modal
   document.addEventListener('DOMContentLoaded', function() {
   const quickOverviewModal = document.getElementById('quickOverviewModal');
   const quickOverviewBtn = document.getElementById('quickOverviewBtn');
   const closeButtons = document.getElementsByClassName('close-btn');
   const sizeChartModal = document.getElementById('sizeChartModal');
   const openSizeModalBtn = document.getElementById('openSizeModal');
   const compareBtn = document.getElementById('compareBtn');
   
   // Function to handle opening and closing modals
   function setupModal(openBtn, modal) {
       if (openBtn) {
           openBtn.addEventListener('click', function() {
               modal.style.display = 'block';
           });
       }
       // When the user clicks on <span> (x), close the modal
       for (let i = 0; i < closeButtons.length; i++) {
           closeButtons[i].addEventListener('click', function() {
               modal.style.display = 'none';
           });
       }
   }
   
   setupModal(quickOverviewBtn, quickOverviewModal);
   setupModal(openSizeModalBtn, sizeChartModal);
   
   // Close modal when clicking outside
   window.addEventListener('click', function(event) {
       if (event.target === quickOverviewModal) {
           quickOverviewModal.style.display = 'none';
       }
       if (event.target === sizeChartModal) {
           sizeChartModal.style.display = 'none';
       }
   });
   
   // Compare button functionality
   if (compareBtn) {
       compareBtn.addEventListener('click', function() {
           // This is where you would handle the compare functionality
           // For example, adding the product to a comparison list.
           const productId = "KHLD-KFTN01"; // Replace with dynamic product ID
           console.log(`Product with ID ${productId} has been added to the comparison list.`);
           
           // You can implement your own logic here, e.g., using localStorage
           // let comparisonList = JSON.parse(localStorage.getItem('compareItems')) || [];
           // if (!comparisonList.includes(productId)) {
           //     comparisonList.push(productId);
           //     localStorage.setItem('compareItems', JSON.stringify(comparisonList));
           //     alert('Product added to compare list!');
           // } else {
           //     alert('Product is already in the compare list.');
           // }
       });
   }
   });
</script>
