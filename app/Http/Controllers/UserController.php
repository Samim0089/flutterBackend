<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // List all users
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'count' => User::count(),
            'data' => User::all()
        ]);
    }

    // Get single user
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status'=>'error','message'=>'User not found'],404);
        }
        return response()->json($user);
    }

    // Create a new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'lastName' => 'required|string',
        ]);

        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status'=>'error','message'=>'User not found'],404);
        }
        $user->update($request->all());
        return response()->json($user);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status'=>'error','message'=>'User not found'],404);
        }
        $user->delete();
        return response()->json(['status'=>'success','message'=>'User deleted']);
    }
}
