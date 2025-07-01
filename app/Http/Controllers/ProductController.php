<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 🧾 List all products with category and seller info
    public function index() {
        return Product::with('category', 'seller')->get();
    }

    // 🔍 Get one product by ID
    public function show($id) {
        return Product::with('category', 'seller')->findOrFail($id);
    }

    // ➕ Create a new product
    public function store(Request $request) {
        // ✅ Validate incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'seller_id' => 'required|exists:users,id'
        ]);

        // 🧪 Create the product
        $product = Product::create($request->all());

        // ✅ Return the created product
        return response()->json($product, 201);
    }

    // ✏️ Update product details
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);

        // Update with validated input
        $product->update($request->all());

        return response()->json($product);
    }

    // ❌ Delete a product
    public function destroy($id) {
        Product::destroy($id);
        return response()->json(['message' => 'Product deleted']);
    }
}
