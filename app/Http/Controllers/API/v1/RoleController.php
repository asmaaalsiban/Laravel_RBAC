<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Requests\API\V1\AssingPermissionsRequest;
use App\Http\Requests\API\V1\StoreRoleRequest;
use App\Http\Requests\API\V1\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
// use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            "message" => "Roles retrieved successfully",
            "data" => RoleResource::collection($roles)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $data = Role::create($request->validated());
        return response()->json([
            "message" => "Role created successfully",
            "data" => new RoleResource($data)
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        return response()->json([

            "data" => new RoleResource($role)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->validated());
        return response()->json([
            "message" => "Role updated successfully",
            "data" => new RoleResource($role)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json([
            "message" => "Role deleted successfully"
        ], 200);
    }
    //assign permission to Role
    public function assignPermissions(string $id, AssingPermissionsRequest $request)
    {
        $role = Role::findOrFail($id);
        $role->permissions()->attach($request->validated()['permissions']);
        return response()->json([
            "message" => "Permissions assigned successfully",
            "data" => new RoleResource($role)
        ], 200);

    }
    //remove permission from Role
    public function removePermissions(string $id, Request $request)
    {
        $role = Role::findOrFail($id);
        $role->permissions()->detach($request->input('permissions'));
        return response()->json([
            "message" => "Permissions removed successfully",
            "data" => new RoleResource($role)
        ], 200);
    }
}