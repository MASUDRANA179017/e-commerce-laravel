<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->orWhereNull('role')->paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    public function getData(Request $request)
    {
        $customers = User::where('role', 'customer')->orWhereNull('role')->get();
        return response()->json(['data' => $customers]);
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer',
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully');
    }

    public function show($customer)
    {
        $customer = User::findOrFail($customer);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit($customer)
    {
        $customer = User::findOrFail($customer);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $customer)
    {
        $customer = User::findOrFail($customer);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
        ]);

        $customer->update($request->only(['name', 'email']));

        if ($request->filled('password')) {
            $customer->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully');
    }

    public function destroy($customer)
    {
        User::findOrFail($customer)->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($customer)
    {
        $customer = User::findOrFail($customer);
        $customer->update(['is_active' => !$customer->is_active]);
        return response()->json(['success' => true]);
    }

    public function groups()
    {
        return view('admin.customers.groups');
    }

    public function storeGroup(Request $request)
    {
        // Store customer group logic
        return response()->json(['success' => true]);
    }

    public function updateGroup(Request $request, $group)
    {
        // Update customer group logic
        return response()->json(['success' => true]);
    }

    public function destroyGroup($group)
    {
        // Delete customer group logic
        return response()->json(['success' => true]);
    }
}

