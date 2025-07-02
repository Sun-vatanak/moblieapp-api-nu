<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 🧾 View all items in the user's cart
    public function index(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $items = $cart->items()->with('product')->get();

        return response()->json([
            'message' => 'Cart items retrieved successfully',
            'data' => $items
        ]);
    }

    // ➕ Add product to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);

        $item = $cart->items()->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->quantity += $request->quantity;
            $item->save();
        } else {
            $item = CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return response()->json([
            'message' => 'Product added to cart successfully',
            'data' => $item
        ]);
    }

    // ✏️ Update quantity of a cart item
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::find($id);

        if (!$item || $item->cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Cart item not found or unauthorized'], 404);
        }

        $item->quantity = $request->quantity;
        $item->save();

        return response()->json([
            'message' => 'Cart item updated successfully',
            'data' => $item
        ]);
    }

    // ❌ Remove item from cart
    public function remove(Request $request, $id)
    {
        $item = CartItem::find($id);

        if (!$item || $item->cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Cart item not found or unauthorized'], 404);
        }

        $item->delete();

        return response()->json([
            'message' => 'Cart item removed successfully'
        ]);
    }
}
