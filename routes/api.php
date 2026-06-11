<?php

use App\Enums\PermissionsEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\PermissionController;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware("auth:sanctum")->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index')->middleware('hasPermissions:' . PermissionsEnum::VIEW_USERS->value);
        Route::post('/', 'store')->middleware('hasPermissions:' . PermissionsEnum::CREATE_USER->value);
        Route::get('/{id}', 'show')->middleware('hasPermissions:' . PermissionsEnum::VIEW_USER->value);
        Route::put('/{id}', 'update')->middleware('hasPermissions:' . PermissionsEnum::UPDATE_USER->value);
        Route::delete('/{id}', 'destroy')->middleware('hasPermissions:' . PermissionsEnum::DELETE_USER->value);

        // إدارة أدوار المستخدم
        Route::post('/{id}/role', 'AssignRoleToUser');
        Route::delete('/{id}/role', 'RemoveRoleFromUser');
    });

    // مجموعة إدارة الأدوار (Role Management)
    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index')->middleware('hasPermissions:' . PermissionsEnum::VIEW_ROLES->value);
        Route::post('/', 'store')->middleware('hasPermissions:' . PermissionsEnum::CREATE_ROLE->value);
        Route::put('/{id}', 'update')->middleware('hasPermissions:' . PermissionsEnum::UPDATE_ROLE->value);
        Route::delete('/{id}', 'destroy')->middleware('hasPermissions:' . PermissionsEnum::DELETE_ROLE->value);
        Route::get('/{id}', 'show')->middleware('hasPermissions:' . PermissionsEnum::VIEW_ROLE->value);

        // إدارة صلاحيات الدور
        Route::post('/{id}/permissions', 'assignPermissions');
        Route::delete('/{id}/permissions', 'removePermissions');
    });


    Route::controller(PermissionController::class)->prefix('permissions')->group(function () {
        Route::get('/', 'index')->middleware('hasPermissions:' . PermissionsEnum::VIEW_PERMISSIONS->value);
    });

});
