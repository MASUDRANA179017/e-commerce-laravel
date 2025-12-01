<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function coupons()
    {
        return view('admin.marketing.coupons');
    }

    public function couponsData(Request $request)
    {
        $coupons = collect(); // Coupon::all()
        return response()->json(['data' => $coupons]);
    }

    public function storeCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
        ]);

        // Create coupon logic
        return response()->json(['success' => true, 'message' => 'Coupon created']);
    }

    public function showCoupon($coupon)
    {
        return response()->json(['coupon' => $coupon]);
    }

    public function updateCoupon(Request $request, $coupon)
    {
        // Update coupon logic
        return response()->json(['success' => true, 'message' => 'Coupon updated']);
    }

    public function destroyCoupon($coupon)
    {
        // Delete coupon logic
        return response()->json(['success' => true]);
    }

    public function toggleCoupon($coupon)
    {
        // Toggle coupon status
        return response()->json(['success' => true]);
    }

    public function flashSales()
    {
        return view('admin.marketing.flash-sales');
    }

    public function storeFlashSale(Request $request)
    {
        // Create flash sale logic
        return response()->json(['success' => true, 'message' => 'Flash sale created']);
    }

    public function updateFlashSale(Request $request, $sale)
    {
        // Update flash sale logic
        return response()->json(['success' => true]);
    }

    public function destroyFlashSale($sale)
    {
        // Delete flash sale logic
        return response()->json(['success' => true]);
    }

    public function newsletters()
    {
        return view('admin.marketing.newsletters');
    }

    public function subscribers()
    {
        return response()->json(['subscribers' => collect()]);
    }

    public function sendNewsletter(Request $request)
    {
        // Send newsletter logic
        return response()->json(['success' => true, 'message' => 'Newsletter sent']);
    }

    public function deleteSubscriber($subscriber)
    {
        // Delete subscriber logic
        return response()->json(['success' => true]);
    }
}

