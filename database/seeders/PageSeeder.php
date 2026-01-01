<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<div class="about-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://via.placeholder.com/600x400" alt="About Us" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-4">Welcome to Our Store</h2>
                <p class="lead mb-4">We are a leading e-commerce platform providing high quality products to customers worldwide.</p>
                <p class="mb-4">Our story begins with a simple vision: to make shopping easy, affordable, and enjoyable for everyone. We believe in quality, transparency, and exceptional customer service.</p>
                <div class="row g-4 mt-2">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-check-circle text-primary fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-0">Quality Products</h6>
                                <small class="text-muted">100% Genuine</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-truck-fast text-primary fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-0">Fast Delivery</h6>
                                <small class="text-muted">Global Shipping</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>',
                'status' => true,
                'meta_title' => 'About Us - Our Story',
                'meta_description' => 'Learn about our company history and vision.'
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-and-conditions',
                'content' => '<div class="terms-section py-4">
    <h4>1. Introduction</h4>
    <p>Welcome to our website. By accessing this website, you agree to be bound by these terms and conditions.</p>
    
    <h4>2. Use of Website</h4>
    <p>You may not use this website for any unlawful purpose or in any way that interrupts, damages, or impairs the service.</p>
    
    <h4>3. Product Information</h4>
    <p>We make every effort to display as accurately as possible the colors, features, specifications, and details of the products available on the Site.</p>
    
    <h4>4. Pricing and Payment</h4>
    <p>All prices are subject to change without notice. We reserve the right to modify or discontinue the Service (or any part or content thereof) at any time.</p>
</div>',
                'status' => true,
                'meta_title' => 'Terms & Conditions',
                'meta_description' => 'Read our terms and conditions.'
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<div class="privacy-section py-4">
    <h4>1. Information We Collect</h4>
    <p>We collect information you provide directly to us, such as when you create an account, update your profile, or make a purchase.</p>
    
    <h4>2. How We Use Your Information</h4>
    <p>We use the information we collect to provide, maintain, and improve our services, process transactions, and send you related information.</p>
    
    <h4>3. Information Sharing</h4>
    <p>We do not share your personal information with third parties except as described in this policy.</p>
    
    <h4>4. Security</h4>
    <p>We take reasonable measures to help protect information about you from loss, theft, misuse and unauthorized access.</p>
</div>',
                'status' => true,
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'Read our privacy policy.'
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
