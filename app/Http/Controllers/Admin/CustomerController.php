<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Get all customers
        $customers = Customer::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    public function getData(Request $request)
    {
        $customers = Customer::all();
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
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:50',
            'address' => 'required|string',
            'password' => 'required|string|min:6',
            'zipcode' => 'nullable|string|max:50',
            'note' => 'nullable|string',
            'total_spent' => 'nullable|numeric',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'zipcode' => $request->zipcode,
            'note' => $request->note,
            'total_spent' => $request->total_spent ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Hash::make($request->password);
        }

        Customer::create($data);

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully');
    }

    public function show($customer)
    {
        $customer = Customer::findOrFail($customer);
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['customer' => $customer]);
        }

        return view('admin.customers.show', compact('customer'));
    }

    public function edit($customer)
    {
        $customer = Customer::findOrFail($customer);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $customer)
    {
        $cust = Customer::findOrFail($customer);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $cust->id,
            'phone' => 'required|string|max:50',
            'password' => 'nullable|string|min:6',
            'address' => 'required|string',
            'zipcode' => 'nullable|string|max:50',
            'note' => 'nullable|string',
            'total_spent' => 'nullable|numeric',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address', 'zipcode', 'note', 'total_spent']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->filled('password')) {
            $data['password'] = \Hash::make($request->password);
        }

        $cust->update($data);

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully');
    }

    public function destroy($customer)
    {
        Customer::findOrFail($customer)->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($customer)
    {
        $cust = Customer::findOrFail($customer);
        $cust->is_active = !$cust->is_active;
        $cust->save();
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

