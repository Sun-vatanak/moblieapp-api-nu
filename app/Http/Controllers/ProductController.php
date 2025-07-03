<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 🧾 List all products with category and seller info
    public function index()
    {
        $products = Product::with(['category', 'seller', 'discount'])->get();

        return response()->json([
            'message' => 'Products retrieved successfully',
            'data'    => $products
        ]);
    }

    // 🔍 Show one product by ID
    public function show($id)
    {
        $product = Product::with(['category', 'seller'])->find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'message' => 'Product retrieved successfully',
            'data'    => $product
        ]);
    }

    // ➕ Create a new product
   public function store(Request $request)
{
    $request->validate([
        'name'             => 'required|string|max:255',
        'description'      => 'nullable|string',
        'price'            => 'required|numeric|min:0',
        'image'            => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
        'expiration_date'  => 'nullable|date',
        'origin'           => 'nullable|string',
        'category_id'      => 'required|exists:categories,id',
        'seller_id'        => 'required|exists:users,id',
        'discount_id'      => 'nullable|exists:discounts,id',
    ]);

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public'); // stored in storage/app/public/products
    }

    $product = Product::create([
        'name'             => $request->name,
        'description'      => $request->description,
        'price'            => $request->price,
        'image'            => $imagePath, // save only the path
        'expiration_date'  => $request->expiration_date,
        'origin'           => $request->origin,
        'category_id'      => $request->category_id,
        'seller_id'        => $request->seller_id,
        'discount_id'      => $request->discount_id,
    ]);

    return response()->json([
        'message' => 'Product created successfully',
        'product' => $product
    ], 201);
}


    // ✏️ Update an existing product
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'name'             => 'sometimes|string|max:255',
            'description'      => 'sometimes|nullable|string',
            'price'            => 'sometimes|numeric|min:0',
            'image'            => 'sometimes|nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
            'expiration_date'  => 'sometimes|nullable|date',
            'origin'           => 'sometimes|nullable|string',
            'category_id'      => 'sometimes|exists:categories,id',
            'seller_id'        => 'sometimes|exists:users,id',
        ]);

        $product->update($request->only([
            'name',
            'description',
            'price',
            'image',
            'expiration_date',
            'origin',
            'category_id',
            'seller_id'
        ]));

        return response()->json([
            'message' => 'Product updated successfully',
            'data'    => $product
        ]);
    }

    // ❌ Delete a product
    public function destroy($id)
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
