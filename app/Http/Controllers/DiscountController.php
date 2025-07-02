<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    // 🔍 Get a discount by ID
    public function show($id)
    {
        $discount = Discount::find($id);

        if (! $discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        return response()->json([
            'message' => 'Discount retrieved successfully',
            'data' => $discount
        ]);
    }

    // ➕ Create a new discount
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'percentage'  => 'required|numeric|min:0|max:100',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        $discount = Discount::create([
            'title'       => $request->title,
            'percentage'  => $request->percentage,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        return response()->json([
            'message' => 'Discount created successfully',
            'data'    => $discount
        ], 201);
    }
}
