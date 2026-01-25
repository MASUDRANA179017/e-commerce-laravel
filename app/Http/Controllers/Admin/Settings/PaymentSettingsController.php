<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    /**
     * Show payment settings form
     */
    public function index()
    {
        $settings = [];
        $keys = [
            'partial_payment_enabled',
            'partial_payment_minimum_percent',
            'advance_payment_enabled',
            'advance_payment_minimum_amount',
            'delivery_charge_advance_enabled',
            'delivery_charge_advance_percent',
        ];

        foreach ($keys as $key) {
            $settings[$key] = PaymentSetting::get($key);
        }

        return view('admin.settings.payment.index', compact('settings'));
    }

    /**
     * Update payment settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'partial_payment_enabled' => 'boolean',
            'partial_payment_minimum_percent' => 'required_if:partial_payment_enabled,true|nullable|numeric|min:0|max:100',
            'advance_payment_enabled' => 'boolean',
            'advance_payment_minimum_amount' => 'required_if:advance_payment_enabled,true|nullable|numeric|min:0',
            'delivery_charge_advance_enabled' => 'boolean',
            'delivery_charge_advance_percent' => 'required_if:delivery_charge_advance_enabled,true|nullable|numeric|min:0|max:100',
        ]);

        foreach ($validated as $key => $value) {
            PaymentSetting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Payment settings updated successfully');
    }
}
