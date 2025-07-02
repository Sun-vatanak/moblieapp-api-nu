<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 🔍 Get all categories
    public function index()
    {
        return response()->json([
            'message' => 'Categories retrieved successfully',
            'data'    => Category::all()
        ]);
    }

    // ➕ Create new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'data'    => $category
        ], 201);
    }

    // 🔍 Get a single category
    public function show($id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json([
            'message' => 'Category retrieved successfully',
            'data'    => $category
        ]);
    }

    // ✏️ Update category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Category updated successfully',
            'data'    => $category
        ]);
    }

    // ❌ Delete category
    public function destroy($id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
