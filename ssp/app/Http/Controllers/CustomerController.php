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
            return response()->json(['errors' => $validator->errors()], 422);
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

            // Generate token using Laravel Sanctum
            $token = $customer->createToken('customerToken')->plainTextToken;

            return response()->json([
                'message' => 'Customer registered successfully',
                'customer' => $customer,
                'token' => $token,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while registering the customer.'], 500);
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

        // Verify credentials
        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'Incorrect email or password'], 401);
        }

        // Generate token using Laravel Sanctum
        $token = $customer->createToken('customerToken')->plainTextToken;

        return response()->json([
            'message' => 'Customer logged in successfully',
            'customer' => $customer,
            'token' => $token,
        ], 200);
    }

    // Get customer count
    public function getCustomerCount()
    {
        $count = Customer::count();

        return response()->json(['count' => $count], 200);
    }

    // List all customers
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'DESC')->get();

        return response()->json($customers, 200);
    }

    // Show a specific customer
    public function show($id)
    {
        try {
            $customer = Customer::findOrFail($id);

            return response()->json($customer, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
    }

    // Store a new customer (Admin feature)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
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

            return response()->json(['message' => 'Customer added successfully', 'customer' => $customer], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while adding the customer.'], 500);
        }
    }

    // Update customer details
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules($id)); // Pass $id for unique validation

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
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

            return response()->json(['message' => 'Customer updated successfully', 'customer' => $customer], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the customer.'], 500);
        }
    }

    // Delete customer
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return response()->json(['message' => 'Customer deleted successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the customer.'], 500);
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

    public function getLoggedInCustomer(Request $request)
{
    return response()->json($request->user()); // This will return the authenticated user's details
}

}
