<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // Keep the register method unchanged
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:customers',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        $token = $customer->createToken('customerToken')->plainTextToken;

        return response()->json([
            'message' => 'Customer registered successfully',
            'customer' => $customer,
            'token' => $token,
        ], 200);
    }

    // Keep the login method unchanged
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json([
                'message' => 'Incorrect email or password',
            ], 401);
        }

        $token = $customer->createToken('customerToken')->plainTextToken;

        return response()->json([
            'message' => 'Customer logged in successfully',
            'customer' => $customer,
            'token' => $token,
        ], 200);
    }

    // Customer count (keep unchanged)
    public function getCustomerCount()
    {
        $count = Customer::count();
        return response()->json(['count' => $count]);
    }

    // List all customers
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'DESC')->get();
        return view('customers.index', compact('customers'));
    }

    // Show the form for creating a new customer
    public function create()
    {
        return view('customers.create');
    }

    // Store a newly created customer
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:customers',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully');
    }

    // Display a specific customer by ID
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    // Show the form for editing a customer
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    // Update a specific customer
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:customers,username,' . $id,
            'email' => 'required|string|email|max:255|unique:customers,email,' . $id,
            'phone_number' => 'required|string|max:15',
            'password' => 'nullable|string|min:6',
        ]);

        $customer = Customer::findOrFail($id);

        $customer->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password ? Hash::make($request->password) : $customer->password,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    // Remove the specified customer
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }
}
