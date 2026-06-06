<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData["password"] = Hash::make($validatedData["password"]);
        $user = User::create($validatedData);
        return response()->json([
            "message" => "User registered successfully",
            "user" => new UserResource($user),
        ], 201);
    }
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::where("email", $validatedData["email"])->first();
        if ($user && Hash::check($validatedData["password"], $user->password)) {
            $token = $user->createToken("auth_token")->plainTextToken;
            return response()->json([
                "message" => "User logged in successfully",
                "user" => new UserResource($user),
                "token" => $token,

            ], 200);
        }
        return response()->json([
            "message" => "Invalid email or password",
        ], 401);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "loggedout Successfully",
        ], 200);
    }
    public function profile(ProfileRequest $request)
    {
        return response()->json([
            "user" => new UserResource($request->user())
        ]);
    }
}
