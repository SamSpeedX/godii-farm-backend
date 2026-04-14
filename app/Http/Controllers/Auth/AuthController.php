<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => "required|email|max:225",
                "password" => "required|string|min:4"
            ]);
            $user = User::where("email", $request->email)->first();
            if (! $user) {
                return response()->json([
                    "status" => "info",
                    "message" => "Email is not found!"
                ]);
            }
            if (! Hash::check($request->password, $user->password)) {
                return response()->json([
                    "status" => "info",
                    "message" => "Invalid password!",
                ]);
            }
            $token = $user->createToken('token-name')->plainTextToken;
            return response()->json([
                "status" => "success",
                "message" => "Welcome Back Dear ". $user->name,
                "auth_token" => $token,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong!",
                "error" => $th->getMessage(),
            ]);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                "name" => "resquired|string|min:4|max:225",
                "email" => "required|email|max:225",
                "password" => "required|string|min:4",
            ]);
            $user = User::where("email", $request->email)->first();
            if (! $user) {
                return response()->json([
                    "status" => "info",
                    "message" => "Account not Found Please register new Account.",
                ]);
            }
            $create = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);
            if (!$create) {
                return response()->json([
                    "status" => "info",
                    "message" => "Account not Created."
                ]);
            }
            return response()->json([
                "status" => "success",
                "message" => "Dear ". $$request->name . " your account created successful.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong!",
                "error" => $th->getMessage(),
            ]);
        }
    }
}
