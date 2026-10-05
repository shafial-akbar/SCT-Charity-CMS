<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'create'])->name('login');

    Route::post('/login', [AdminLoginController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');

    Route::middleware('auth')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');

        Route::get('/users', [UserController::class, 'index'])
            ->middleware('web.permission:users.view')->name('users.index');

        Route::get('/roles', [RoleController::class, 'index'])
            ->middleware('web.permission:roles.view')->name('roles.index');

        Route::get('/permissions', [PermissionController::class, 'index'])
            ->middleware('web.permission:permissions.view')->name('permissions.index');
    });
});
