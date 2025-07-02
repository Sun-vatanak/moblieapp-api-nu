<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 🧍 Get authenticated user info
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'User profile retrieved successfully',
            'data' => [
                'user' => $request->user()
            ]

        ]);
    }

    // 🔍 Get user by ID
    public function show($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'message' => 'User by id  successfully',
            'data' => [
                'user' => $user
            ]
        ]);
    }
    // ✏️ Update user profile
  public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'sometimes|string|max:100',
        'image' => 'sometimes|file|mimes:jpg,jpeg,png,gif|max:2048',
        'email' => 'sometimes|email|unique:users,email,' . $request->user()->id,
        'password' => 'sometimes|confirmed|min:6',
    ]);

    $user = $request->user();

    $user->name = $request->input('name', $user->name);
    $user->email = $request->input('email', $user->email);

    if ($request->filled('password')) {
        $user->password = bcrypt($request->input('password'));
    }

    // If image upload
    if ($request->hasFile('image')) {
        $filename = time() . '_' . $request->image->getClientOriginalName();
        $path = $request->image->storeAs('public/user_images', $filename);
        $user->image = $filename;
    }

    $user->save();
    $user->refresh(); // ✅ force reload fresh data

    return response()->json([
        'message' => 'User profile updated successfully',
        'data' => [
            'user' => $user
        ]
    ]);
}

}
