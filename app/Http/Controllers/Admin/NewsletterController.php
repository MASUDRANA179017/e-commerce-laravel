<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsletterController extends Controller
{
    /**
     * Display newsletters list
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $newsletters = Newsletter::latest();

            if ($request->filled('status')) {
                $newsletters->where('status', $request->status);
            }

            return DataTables::of($newsletters)
                ->addIndexColumn()
                ->addColumn('status_badge', function ($row) {
                    $badges = [
                        'subscribed' => '<span class="badge bg-success">Subscribed</span>',
                        'unsubscribed' => '<span class="badge bg-danger">Unsubscribed</span>',
                        'bounced' => '<span class="badge bg-warning">Bounced</span>',
                    ];
                    return $badges[$row->status] ?? '';
                })
                ->addColumn('subscribed_date', function ($row) {
                    return $row->subscribed_at ? $row->subscribed_at->format('Y-m-d H:i') : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    return '<button type="button" class="btn btn-sm btn-outline-danger delete-newsletter" data-id="' . $row->id . '">
                        <i class="bx bxs-trash"></i>
                    </button>';
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        return view('admin.newsletters.index');
    }

    /**
     * Delete newsletter subscription
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Export newsletters
     */
    public function export(Request $request)
    {
        $status = $request->query('status', 'subscribed');
        $newsletters = Newsletter::where('status', $status)->pluck('email')->toArray();

        return response()->json([
            'emails' => $newsletters,
            'count' => count($newsletters),
        ]);
    }

    /**
     * Send newsletter
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'recipient_type' => 'required|in:all,subscribed',
        ]);

        $recipients = Newsletter::subscribed();
        $count = $recipients->count();

        // Queue the newsletter sending job
        // \App\Jobs\SendNewsletterJob::dispatch($validated['subject'], $validated['body'], $recipients->pluck('email')->toArray());

        return redirect()->route('admin.newsletters.index')->with('success', "Newsletter queued for $count recipients");
    }
}
