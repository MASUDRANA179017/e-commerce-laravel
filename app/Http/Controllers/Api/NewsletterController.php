<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email',
            'name' => 'nullable|string|max:255',
        ]);

        try {
            $newsletter = Newsletter::subscribe($validated['email'], $validated['name'] ?? null);

            return response()->json([
                'success' => true,
                'message' => 'Successfully subscribed to our newsletter!',
                'data' => $newsletter,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to subscribe. Please try again.',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Unsubscribe from newsletter via token
     */
    public function unsubscribe($token)
    {
        try {
            $newsletter = Newsletter::where('subscription_token', $token)->firstOrFail();
            $newsletter->unsubscribe();

            return response()->json([
                'success' => true,
                'message' => 'Successfully unsubscribed from newsletter.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token.',
            ], 404);
        }
    }

    /**
     * Check subscription status
     */
    public function checkStatus(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $newsletter = Newsletter::where('email', $validated['email'])->first();

        if (!$newsletter) {
            return response()->json([
                'success' => true,
                'subscribed' => false,
                'message' => 'Email not found in our system.',
            ]);
        }

        return response()->json([
            'success' => true,
            'subscribed' => $newsletter->status === 'subscribed',
            'status' => $newsletter->status,
        ]);
    }
}
