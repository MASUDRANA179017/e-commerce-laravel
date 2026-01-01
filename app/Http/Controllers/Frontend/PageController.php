<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('status', true)->firstOrFail();
        return view('frontend.page', compact('page'));
    }

    public function about()
    {
        $page = Page::where('slug', 'about-us')->orWhere('slug', 'about')->first();
        if (!$page) {
            // Check if static view exists
            if (view()->exists('frontend.about')) {
                return view('frontend.about');
            }
            
            // Fallback object
            return view('frontend.page', ['page' => (object)[
                'title' => 'About Us',
                'content' => '<div class="text-center py-5">
                    <h3>About Us</h3>
                    <p class="lead">We are a leading e-commerce platform providing high quality products.</p>
                    <p>Our story begins with a simple vision: to make shopping easy, affordable, and enjoyable for everyone.</p>
                </div>',
                'meta_title' => 'About Us',
                'meta_description' => 'About our company'
            ]]);
        }
        return view('frontend.page', compact('page'));
    }

    public function terms()
    {
        $page = Page::where('slug', 'terms-and-conditions')->orWhere('slug', 'terms')->first();
        if (!$page) {
             return view('frontend.page', ['page' => (object)[
                'title' => 'Terms & Conditions',
                'content' => '<p>Terms and conditions content goes here.</p>',
                'meta_title' => 'Terms & Conditions',
                'meta_description' => 'Terms & Conditions'
            ]]);
        }
        return view('frontend.page', compact('page'));
    }

    public function privacy()
    {
        $page = Page::where('slug', 'privacy-policy')->orWhere('slug', 'privacy')->first();
        if (!$page) {
            return view('frontend.page', ['page' => (object)[
                'title' => 'Privacy Policy',
                'content' => '<p>Privacy policy content goes here.</p>',
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'Privacy Policy'
            ]]);
        }
        return view('frontend.page', compact('page'));
    }
}
