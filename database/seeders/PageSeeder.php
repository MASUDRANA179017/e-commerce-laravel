<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h2>About Us</h2><p>Welcome to our online store! We are dedicated to providing you with the best shopping experience possible.</p><p>Our mission is to offer high-quality products at affordable prices, backed by exceptional customer service.</p><h3>Our Story</h3><p>Founded in 2024, we started as a small local business and have grown into a trusted e-commerce platform serving customers worldwide.</p><h3>Why Choose Us?</h3><ul><li>Quality Products</li><li>Fast Shipping</li><li>24/7 Customer Support</li><li>Secure Payments</li></ul>',
                'status' => true,
                'meta_title' => 'About Us - Your Store',
                'meta_description' => 'Learn more about our company and our mission.',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-and-conditions',
                'content' => '<h2>Terms and Conditions</h2><p>Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use.</p><h3>1. Introduction</h3><p>These terms and conditions govern your use of this website; by using this website, you accept these terms and conditions in full.</p><h3>2. License to use website</h3><p>Unless otherwise stated, we or our licensors own the intellectual property rights in the website and material on the website.</p><h3>3. Acceptable use</h3><p>You must not use this website in any way that causes, or may cause, damage to the website or impairment of the availability or accessibility of the website.</p>',
                'status' => true,
                'meta_title' => 'Terms & Conditions',
                'meta_description' => 'Read our terms and conditions.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h2>Privacy Policy</h2><p>Your privacy is important to us. It is our policy to respect your privacy regarding any information we may collect from you across our website.</p><h3>1. Information We Collect</h3><p>We only ask for personal information when we truly need it to provide a service to you. We collect it by fair and lawful means, with your knowledge and consent.</p><h3>2. How We Use Information</h3><p>We use the information we collect to operate and maintain our website, send you newsletters, and respond to your comments and questions.</p><h3>3. Security</h3><p>We take reasonable steps to protect the personal information that you provide to us.</p>',
                'status' => true,
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'Read our privacy policy.',
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
