<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // Register a new customer
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        try {
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            $token = $customer->createToken('customerToken')->plainTextToken;

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Customer registered successfully',
                    'customer' => $customer,
                    'token' => $token,
                ], 200);
            } else {
                return view('Customers.success', ['customer' => $customer]); // Correct view path
            }

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'An error occurred while registering the customer.'], 500);
            } else {
                return redirect()->back()->with('error', 'An error occurred while registering the customer.');
            }
        }
    }

    // Customer login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Incorrect email or password'], 401);
            } else {
                return redirect()->back()->withErrors(['email' => 'Incorrect email or password']);
            }
        }

        $token = $customer->createToken('customerToken')->plainTextToken;

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Customer logged in successfully',
                'customer' => $customer,
                'token' => $token,
            ], 200);
        } else {
            return view('Customers.dashboard', ['customer' => $customer]); // Correct view path
        }
    }

    // Get customer count
    public function getCustomerCount(Request $request)
    {
        $count = Customer::count();

        if ($request->wantsJson()) {
            return response()->json(['count' => $count], 200);
        } else {
            return view('Customers.count', ['count' => $count]); // Correct view path
        }
    }

    // List all customers
    public function index(Request $request)
    {
        $customers = Customer::orderBy('created_at', 'DESC')->get();

        if ($request->wantsJson()) {
            return response()->json($customers, 200);
        } else {
            return view('Customers.index', ['customers' => $customers]); // Correct view path
        }
    }

    // Show a specific customer
    public function show(Request $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);

            if ($request->wantsJson()) {
                return response()->json($customer, 200);
            } else {
                return view('Customers.show', ['customer' => $customer]); // Correct view path
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Customer not found'], 404);
            } else {
                return redirect()->back()->with('error', 'Customer not found.');
            }
        }
    }
    public function edit($id)
{
    try {
        $customer = Customer::findOrFail($id);

        // Return the edit view with the customer's data
        return view('Customers.edit', ['customer' => $customer]);
    } catch (\Exception $e) {
        return redirect()->route('customers.index')->with('error', 'Customer not found.');
    }
}

    // Store a new customer (Admin feature)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        try {
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Customer added successfully', 'customer' => $customer], 201);
            } else {
                return redirect()->route('customers.index')->with('success', 'Customer added successfully');
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'An error occurred while adding the customer.'], 500);
            } else {
                return redirect()->back()->with('error', 'An error occurred while adding the customer.');
            }
        }
    }

    // Update customer details
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules($id)); // Pass $id for unique validation

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        try {
            $customer = Customer::findOrFail($id);

            $customer->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => $request->password ? Hash::make($request->password) : $customer->password,
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Customer updated successfully', 'customer' => $customer], 200);
            } else {
                return redirect()->route('customers.show', $customer->id)->with('success', 'Customer updated successfully');
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'An error occurred while updating the customer.'], 500);
            } else {
                return redirect()->back()->with('error', 'An error occurred while updating the customer.');
            }
        }
    }

    // Delete customer
    public function destroy(Request $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Customer deleted successfully'], 200);
            } else {
                return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'An error occurred while deleting the customer.'], 500);
            } else {
                return redirect()->back()->with('error', 'An error occurred while deleting the customer.');
            }
        }
    }

    // Validation rules (DRY)
    private function rules($id = null)
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:customers,username,' . $id,
            'email' => 'required|string|email|max:255|unique:customers,email,' . $id,
            'phone_number' => 'required|string|max:15',
            'password' => $id ? 'nullable|string|min:6' : 'required|string|min:6', // Password required if new
        ];
    }

    // Get the logged-in customer's details
    public function getLoggedInCustomer(Request $request)
    {
        return response()->json($request->user()); // This returns the authenticated user's details in JSON
    }
}
