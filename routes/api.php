<?php

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
        Route::get('/', 'index');              // api/v1/users (جلب الجميع)
        Route::post('/', 'store');             // api/v1/users (إنشاء مستخدم)
        Route::get('/{id}', 'show');           // api/v1/users/{id} (عرض مستخدم)
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');

        // إدارة أدوار المستخدم
        Route::post('/{id}/role', 'AssignRoleToUser');     // api/v1/users/{id}/role
        Route::delete('/{id}/role', 'RemoveRoleFromUser'); // api/v1/users/{id}/role
    });

    // مجموعة إدارة الأدوار (Role Management)
    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index');              // api/v1/roles
        Route::post('/', 'store');             // api/v1/roles
        Route::get('/{id}', 'show');           // api/v1/roles/{id}
        Route::put('/{id}', 'update');         // api/v1/roles/{id}
        Route::delete('/{id}', 'destroy');     // api/v1/roles/{id}

        // إدارة صلاحيات الدور
        Route::post('/{id}/permissions', 'assignPermissions');     // api/v1/roles/{id}/permissions
        Route::delete('/{id}/permissions', 'removePermissions');   // api/v1/roles/{id}/permissions
    });


    Route::controller(PermissionController::class)->prefix('permissions')->group(function () {
        Route::get('/', 'index');
    });

});