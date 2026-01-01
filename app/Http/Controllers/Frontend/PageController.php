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
            // Fallback or create default if not exists, or show static view if exists
            if (view()->exists('frontend.about')) {
                return view('frontend.about');
            }
            abort(404);
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
