<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Existing dashboard method
    public function dashboard()
    {
        $totalProducts = Product::count();
        $deletedProducts = Product::onlyTrashed()->count();

        $mobileCount = Product::where('category', 'mobile')->count();
        $headsetCount = Product::where('category', 'headset')->count();
        $speakerCount = Product::where('category', 'speaker')->count();
        $laptopCount = Product::where('category', 'laptop')->count();

        return view('dashboard', compact('totalProducts', 'deletedProducts', 'mobileCount', 'headsetCount', 'speakerCount', 'laptopCount'));
    }

    // Existing index method
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        $categories = Product::select('category')->distinct()->get();

        return view('products.index', compact('products', 'categories'));
    }

    // Existing filter method
    public function filterByCategory(Request $request)
    {
        $category = $request->get('category');
        $categories = Product::select('category')->distinct()->get();

        if ($category) {
            $products = Product::where('category', $category)->get();
        } else {
            $products = Product::all();
        }

        return view('products.index', compact('products', 'categories'));
    }

    // Existing create method
    public function create()
    {
        return view('products.create');
    }

    // Existing store method
    public function store(Request $request)
    {
        $data = $request->all();
        $data['attributes'] = $request->has('attributes') ? json_encode($request->attributes) : json_encode([]);

        Product::create($data);

        return redirect()->route('products')->with('success', 'Product added successfully');
    }

    // Existing show method
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    // Existing edit method
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    // Existing update method
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->all();
        $data['attributes'] = $request->has('attributes') ? json_encode($request->attributes) : json_encode([]);

        $product->update($data);

        return redirect()->route('products')->with('success', 'Product updated successfully');
    }

    // Existing destroy method
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('products')->with('success', 'Product deleted successfully');
    }

    // API Methods for CRUD Operations

    /**
     * API: Display a listing of products.
     */
    public function apiIndex()
    {
        $products = Product::all();
        return response()->json([
            'success' => true,
            'data' => $products
        ], 200);
    }

    /**
     * API: Store a newly created product.
     */
    public function apiStore(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_code' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'quantity' => 'required|integer',
            'location' => 'required|string',
            'attributes' => 'nullable|array', // Optional, can be an array
        ]);

        $product = Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'product_code' => $request->product_code,
            'description' => $request->description,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'location' => $request->location,
            'attributes' => json_encode($request->attributes ?? []),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully!',
            'data' => $product
        ], 201);
    }

    /**
     * API: Display a specific product.
     */
    public function apiShow($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }

    /**
     * API: Update a specific product.
     */
    public function apiUpdate(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!'
            ], 404);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'product_code' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => 'sometimes|string',
            'quantity' => 'sometimes|integer',
            'location' => 'sometimes|string',
            'attributes' => 'nullable|array', // Optional, can be an array
        ]);

        $product->update([
            'title' => $request->title ?? $product->title,
            'price' => $request->price ?? $product->price,
            'product_code' => $request->product_code ?? $product->product_code,
            'description' => $request->description ?? $product->description,
            'category' => $request->category ?? $product->category,
            'quantity' => $request->quantity ?? $product->quantity,
            'location' => $request->location ?? $product->location,
            'attributes' => $request->attributes ? json_encode($request->attributes) : $product->attributes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully!',
            'data' => $product
        ], 200);
    }

    /**
     * API: Remove a specific product from storage.
     */
    public function apiDestroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully!'
        ], 200);
    }
}
