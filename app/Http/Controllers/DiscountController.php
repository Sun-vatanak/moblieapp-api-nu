<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::all();

        return response()->json([
            'message' => 'All discounts retrieved successfully',
            'data' => $discounts
        ]);
    }
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
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'percentage'  => 'required|numeric|min:0|max:100',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        $discount = Discount::create($request->only([
            'title',
            'percentage',
            'start_date',
            'end_date'
        ]));

        return response()->json([
            'message' => 'Discount created successfully',
            'data'    => $discount
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $discount = Discount::find($id);

        if (! $discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $request->validate([
            'title'       => 'sometimes|string|max:255',
            'percentage'  => 'sometimes|numeric|min:0|max:100',
            'start_date'  => 'sometimes|date',
            'end_date'    => 'sometimes|date|after_or_equal:start_date',
        ]);

        $discount->update($request->only([
            'title',
            'percentage',
            'start_date',
            'end_date'
        ]));

        return response()->json([
            'message' => 'Discount updated successfully',
            'data'    => $discount
        ]);
    }
}
