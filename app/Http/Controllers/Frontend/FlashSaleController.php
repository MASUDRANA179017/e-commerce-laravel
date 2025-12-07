<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    /**
     * Show current flash sale products list.
     */
    public function index()
    {
        $now = now();

        // Prefer active flash sale, otherwise nearest upcoming one
        $flashSale = FlashSale::whereIn('status', ['active', 'scheduled'])
            ->where('end_time', '>=', $now)
            ->orderByRaw("FIELD(status, 'active', 'scheduled', 'draft', 'ended')")
            ->orderByDesc('is_featured')
            ->orderBy('start_time')
            ->first();

        if (!$flashSale) {
            // No flash sale configured - redirect to shop
            return redirect()
                ->route('shop.index')
                ->with('info', 'No flash sale is currently available.');
        }

        // Load products for this flash sale
        $products = $flashSale->products()
            ->whereIn('status', ['active', 'Active', 1])
            ->with(['images', 'brand', 'categories'])
            ->paginate(12);

        return view('frontend.flash-sale', compact('flashSale', 'products'));
    }
}


