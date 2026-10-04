<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Admin\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login'])
        ->middleware('throttle:login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/logout-all', [AuthController::class, 'logoutAll']);

        Route::post('/admin/users/{user}/roles', [UserRoleController::class, 'assign'])
            ->middleware('permission:users.roles.assign');

        Route::delete('/admin/users/{user}/roles/{role}', [UserRoleController::class, 'remove'])
            ->middleware('permission:users.roles.remove');
    });
});
