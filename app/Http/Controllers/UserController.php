<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function addUser(UserRequest $request)
    {
        $existingUser = User::where('email', $request->email)
            ->first();
        if ($existingUser){
            return response()->json(['error'=>'user already exists'], 422);
        }
        $user = User::create([
            'email' => $request->email,
            'password' =>Hash::make($request->password)
        ]);

        return response()->json(['message' => 'Subscription created successfully', 'data' => $user], 201);
    }
}
