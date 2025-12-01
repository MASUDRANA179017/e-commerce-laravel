<?php include 'include/header.php';?>

      <!-- banner section start -->
      <section class="common-banner">
         <div class="container">
            <div class="row">
               <div class="common-banner__content text-center">
                  <span class="sub-title"><i class="icon-donation"></i>Start donating poor people</span>
                  <h2 class="title-animation">Checkout</h2>
               </div>
            </div>
         </div>
         <div class="banner-bg">
            <img src="assets/images/banner/banner-bg.png" alt="Image">
         </div>
         <div class="shape">
            <img src="assets/images/shape.png" alt="Image">
         </div>
         <div class="sprade" data-aos="zoom-in" data-aos-duration="1000">
            <img src="assets/images/sprade-base.png" alt="Image" class="base-img">
         </div>
      </section>
      <!-- banner section end -->
      <!--  checkout section start -->
      <section class="checkout">
         <div class="container">
            <div class="row gutter-60">
               <div class="col-12 col-lg-6">
                  <div class="checkout__form" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                     <div class="intro">
                        <h5>Delivery Information</h5>
                     </div>
                     <form action="#" method="post">
                        <div class="input-group">
                           <div class="input-single">
                              <input type="text" name="c-name" id="cName" placeholder="First Name" required>
                              <i class="fa-solid fa-user"></i>
                           </div>
                           <div class="input-single">
                              <input type="text" name="c-lastname" id="clastName" placeholder="Last Name" required>
                              <i class="fa-solid fa-user"></i>
                           </div>
                        </div>
                        <div class="input-group">
                           <div class="input-single">
                              <input type="text" name="c-address" id="cAddress" placeholder="Your Address" required>
                              <i class="fa-solid fa-location-dot"></i>
                           </div>
                           <div class="input-single">
                              <input type="text" name="c-country" id="ccountry" placeholder="Country" required>
                              <i class="fa-solid fa-location-dot"></i>
                           </div>
                        </div>
                        <div class="input-single">
                           <input type="text" name="c-address-two" id="cAddressTwo"
                              placeholder="House Number & street number" required>
                           <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="input-single">
                           <input type="text" name="c-address-three" id="cAddressThree"
                              placeholder="Apartment, suit, Unit etc" required>
                           <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="input-group">
                           <div class="input-single">
                              <input type="number" name="c-zip" id="cZip" placeholder="Zip Code" required>
                              <i class="fa-solid fa-location-dot"></i>
                           </div>
                           <div class="input-single">
                              <input type="text" name="contact-number" id="contactNumber" placeholder="Phone Number"
                                 required>
                              <i class="fa-solid fa-user"></i>
                           </div>
                        </div>
                        <div class="input-single alter-input">
                           <textarea name="contact-message" id="contactMessage"
                              placeholder="your message..."></textarea>
                           <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="form-cta">
                           <button type="submit" aria-label="submit message" title="submit message"
                              class="btn--primary">Save Informations <i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="col-12 col-lg-6">
                  <div class="checkout__content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                     <div class="intro">
                        <h5>Order Summary</h5>
                     </div>
                     <form action="#" method="post">
                        <div class="content">
                           <div class="content-single">
                              <p>Subtotal</p>
                              <p>$345.00</p>
                           </div>
                           <div class="content-single">
                              <p>Shipping Fee</p>
                              <p>$34.00</p>
                           </div>
                           <div class="content-single content-single-alt">
                              <input type="text" required name="promo-code" id="promoCode"
                                 placeholder="Enter Promo Code">
                              <button type="submit" aria-label="promo code" title="promo code"
                                 class="btn--primary">Apply Code
                              </button>
                           </div>
                           <div class="content-inner">
                              <div class="total">
                                 <h6>Total</h6>
                                 <h6>$379.00</h6>
                              </div>
                              <div class="radio-wrapper">
                                 <div class="radio-single">
                                    <input type="radio" id="testDonation" name="donation-payment" checked>
                                    <label for="testDonation">Bank Transfer</label>
                                 </div>
                                 <div class="radio-single">
                                    <input type="radio" id="cardDonation" name="donation-payment" checked>
                                    <label for="cardDonation">Credit Card</label>
                                 </div>
                                 <div class="radio-single">
                                    <input type="radio" id="offlineDonation" name="donation-payment" checked>
                                    <label for="offlineDonation">Cash On Delivery</label>
                                 </div>
                              </div>
                              <div class="form-cta">
                                 <button type="submit" aria-label="submit message" title="submit message"
                                    class="btn--primary">Proceed To Pay <i class="fa-solid fa-arrow-right"></i></button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- checkout section end -->
      <?php include 'include/footer.php';?>