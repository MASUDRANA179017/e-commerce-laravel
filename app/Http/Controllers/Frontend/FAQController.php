<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FAQ;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::active()->website()->ordered()->get();
        return view('frontend.faq', compact('faqs'));
    }
}
