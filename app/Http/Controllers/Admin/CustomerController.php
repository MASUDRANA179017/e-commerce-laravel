<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
        $query = Customer::query();

        return DataTables::of($query)
            ->addColumn('orders', function ($c) {
                return 0;
            })
            ->addColumn('total_spent', function ($c) {
                return number_format($c->total_spent, 2);
            })
            ->addColumn('is_active', function ($c) {
                return $c->is_active ? 1 : 0;
            })
            ->addColumn('actions', function ($c) {
                $view = '<a href="' . route('admin.customers.show', $c->id) . '" class="action-btn-info" title="View Details"><i class="fas fa-eye"></i></a> ';
                $view .= '<a href="#" class="action-btn-success btn-edit" data-id="' . $c->id . '" title="Edit"><i class="fas fa-edit"></i></a> ';
                $view .= '<form action="' . route('admin.customers.destroy', $c->id) . '" method="POST" class="delete-customer-form" style="display:inline-block;">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="action-btn-danger btn-delete btn btn-link p-0" title="Delete"><i class="fas fa-trash"></i></button></form>';
                return $view;
            })
            ->rawColumns(['actions'])
            ->editColumn('created_at', function ($c) {
                return $c->created_at ? $c->created_at->format('M d, Y') : '';
            })
            ->make(true);
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
            'password' => 'required|string|min:6|confirmed',
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
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'customer' => $data], 201);
        }

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully');
    }

    public function show($customer)
    {
        $customer = User::findOrFail($customer);
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
            'password' => 'nullable|string|min:6|confirmed',
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

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'customer' => $cust]);
        }

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully');
    }

    public function destroy($customer)
    {
        Customer::findOrFail($customer)->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully');
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
       public function login(Request $request)
    {
        log::info('Customer login attempt', ['email' => $request->input('email')]);
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }
}

