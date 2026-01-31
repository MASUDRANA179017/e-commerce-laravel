<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\TermsCondition;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
            $page = Page::where('slug', $slug)->where('status', true)->first();

            if (!$page) {
                // Return a generic page if not found (no 404)
                return view('frontend.page', ['page' => (object)[
                    'title' => ucwords(str_replace('-', ' ', $slug)),
                    'content' => null,
                    'meta_title' => ucwords(str_replace('-', ' ', $slug)),
                    'meta_description' => 'Page coming soon'
                ]]);
            }

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
        $term = TermsCondition::where('status', 'active')->latest()->first();
        return view('frontend.pages.terms-and-conditions', compact('term'));
    }

    public function privacy()
    {
        return view('frontend.pages.privacy-policy');
    }
}
