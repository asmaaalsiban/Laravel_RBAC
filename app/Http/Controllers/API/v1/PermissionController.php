<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return response()->json([
            "message" => "Permissions retrieved successfully",
            "data" => PermissionResource::collection($permissions)
        ], 200);
    }
}
