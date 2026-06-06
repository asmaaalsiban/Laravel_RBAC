<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware("auth:sanctum")->group(function () {
    //auth routes
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    //User management routes
    Route::controller(UserController::class)->group(function () {
        Route::post('/users', 'store');
        Route::get('/users', 'index');
        Route::get('/users/{id}', 'show');
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
        //Assign /remove roles to user
        Route::post("/user/{id}/role", "AssignRoleToUser");
        Route::delete("/user/{id}/role", "RemoveRoleFromUser");
        // //Assign /remove permission to user
        // Route::post('/users/{id}/permissions', 'AssignPermissionToUser');
        // Route::delete("/users/{id}/permissions", "RemovePermissionFromUser");
    });
    //Role management routes
    Route::controller(RoleController::class)->group(function () {
        Route::post('/roles', 'store');
        Route::get('/roles', 'index');
        Route::get('/roles/{id}', 'show');
        Route::put('/roles/{id}', 'update');
        Route::delete('/roles/{id}', 'destroy');
        //assign/remove permission to Role
        Route::post('/roles/{id}/permissions', 'assignPermissions');
        Route::delete('/roles/{id}/permissions', 'removePermissions');
    });
    //permission management routes
    Route::get("/permissions", [PermissionController::class, "index"]);
});
