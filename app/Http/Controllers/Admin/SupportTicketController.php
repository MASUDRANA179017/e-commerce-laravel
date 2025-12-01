<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;

class SupportTicketController extends Controller
{
    public function create()
    {
        return view('admin.support.create'); // points to your Blade
    }

    public function store(Request $request)
    {
        $request->validate([
            'special_id' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
            'description' => 'required|string',
        ]);

        $data = $request->only('special_id', 'email', 'description');

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/support_attachments', $filename);
            $data['attachment'] = $filename;
        }

        SupportTicket::create($data);

        return redirect()->back()->with('success', 'Support ticket submitted successfully!');
    }
    public function index()
    {
        $tickets = SupportTicket::all(); // fetch all tickets
        return view('admin.support.create', compact('tickets'));
    }

}
