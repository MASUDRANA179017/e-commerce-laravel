<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // Get all users as customers (adjust query based on your actual user structure)
        $customers = User::paginate(20);
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
        $groups = CustomerGroup::where('is_active', true)->get();
        return view('admin.customers.create', compact('groups'));
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
            'username' => $username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer',
        ]);

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
        $customer = User::findOrFail($customer);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $customer)
    {
        $cust = Customer::findOrFail($customer);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
        ]);

        $customer->update($request->only(['name', 'email']));

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
        $groups = CustomerGroup::withCount('customers')->latest()->get();
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

