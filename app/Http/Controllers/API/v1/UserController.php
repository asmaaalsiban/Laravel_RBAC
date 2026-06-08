<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Requests\API\V1\StoreUserRequest;
use App\Http\Requests\API\V1\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            "users" => UserResource::collection($users)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create($validatedData);
        return response()->json([
            "message" => "User created successfully",
            "user" => new UserResource($user)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            "message" => "User details",
            "user" => new UserResource($user)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $user = User::findOrFail($id);
        $user->update($validatedData);
        return response()->json([
            "message" => "User updated successfully",
            "user" => new UserResource($user)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            "message" => "User deleted successfully",
        ], 200);
    }
    //assign/remove role to user
    public function AssignRoleToUser(Request $request, string $id)
    {

        $request->validate([
            "name" => ["required", "exists:roles,name"]
        ]);

        $user = User::findOrFail($id);
        $role = Role::where('name', $request->name)->first();
        $user->roles()->attach($role->id)->unique();

        return response()->json([
            "message" => "Role assigned to user successfully",
            "data" => new UserResource($user)
        ], 200);
    }

    public function RemoveRoleFromUser(Request $request, string $id)
    {
        $request->validate([
            "name" => ["required", "exists:roles,name"]
        ]);

        $user = User::findOrFail($id);
        $role = Role::where('name', $request->name)->first();
        $user->roles()->detach($role->id);
        return response()->json([
            "message" => "Role removed from user successfully",
            "data" => new UserResource($user)
        ], 200);
    }


}