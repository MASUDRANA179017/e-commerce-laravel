<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Get all users as customers (adjust query based on your actual user structure)
        $customers = User::withCount('orders')->paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    public function getData(Request $request)
    {
        $customers = User::all();
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
        $groups = CustomerGroup::latest()->get();
        return view('admin.customers.groups', compact('groups'));
    }

    public function storeGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        CustomerGroup::create([
            'name' => $request->name,
            'discount_percentage' => $request->discount_percentage ?? 0,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Customer group created successfully');
    }

    public function updateGroup(Request $request, $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $customerGroup = CustomerGroup::findOrFail($group);
        $customerGroup->update([
            'name' => $request->name,
            'discount_percentage' => $request->discount_percentage ?? 0,
        ]);

        return redirect()->back()->with('success', 'Customer group updated successfully');
    }

    public function destroyGroup($group)
    {
        CustomerGroup::findOrFail($group)->delete();
        return redirect()->back()->with('success', 'Customer group deleted successfully');
    }
}

