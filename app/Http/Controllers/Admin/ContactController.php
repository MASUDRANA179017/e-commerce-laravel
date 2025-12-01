<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Show all contact messages in the admin panel
    public function index(Request $request)
    {
        // If request wants JSON (DataTables AJAX)
        if ($request->ajax()) {
            $messages = ContactMessage::latest()->get();

            return datatables()->of($messages)
                ->addIndexColumn() // adds a serial number column
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.contact.show', $row->id).'" class="btn btn-sm btn-primary">View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Otherwise show admin contact view
        return view('admin.contact');
    }

    // Store a new contact message
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($request->only('name','email','subject','message'));

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    // Optional: view single message
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        return view('admin.contact_show', compact('message'));
    }
}
