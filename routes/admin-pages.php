<?php

use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PageSectionController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/pages', [PageController::class, 'index'])->name('pages.index')->middleware('web.permission:pages.view');
    Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create')->middleware('web.permission:pages.create');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store')->middleware('web.permission:pages.create');
    Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit')->middleware('web.permission:pages.update');
    Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update')->middleware('web.permission:pages.update');
    Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy')->middleware('web.permission:pages.delete');

    Route::get('/pages/{page}/sections/create', [PageSectionController::class, 'create'])->name('pages.sections.create')->middleware('web.permission:pages.sections.create');
    Route::post('/pages/{page}/sections', [PageSectionController::class, 'store'])->name('pages.sections.store')->middleware('web.permission:pages.sections.create');
    Route::get('/pages/{page}/sections/{section}/edit', [PageSectionController::class, 'edit'])->name('pages.sections.edit')->middleware('web.permission:pages.sections.update');
    Route::put('/pages/{page}/sections/{section}', [PageSectionController::class, 'update'])->name('pages.sections.update')->middleware('web.permission:pages.sections.update');
    Route::delete('/pages/{page}/sections/{section}', [PageSectionController::class, 'destroy'])->name('pages.sections.destroy')->middleware('web.permission:pages.sections.delete');
});
