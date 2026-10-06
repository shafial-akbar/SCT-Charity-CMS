<?php

use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\GalleryController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/galleries', [GalleryController::class, 'index'])->middleware('web.permission:galleries.view')->name('galleries.index');
    Route::get('/galleries/create', [GalleryController::class, 'create'])->middleware('web.permission:galleries.create')->name('galleries.create');
    Route::post('/galleries', [GalleryController::class, 'store'])->middleware('web.permission:galleries.create')->name('galleries.store');
    Route::get('/galleries/{gallery}', [GalleryController::class, 'show'])->middleware('web.permission:galleries.view')->name('galleries.show');
    Route::get('/galleries/{gallery}/edit', [GalleryController::class, 'edit'])->middleware('web.permission:galleries.update')->name('galleries.edit');
    Route::put('/galleries/{gallery}', [GalleryController::class, 'update'])->middleware('web.permission:galleries.update')->name('galleries.update');
    Route::delete('/galleries/{gallery}/cover', [GalleryController::class, 'removeCover'])->middleware('web.permission:galleries.update')->name('galleries.cover.remove');
    Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy'])->middleware('web.permission:galleries.delete')->name('galleries.destroy');

    Route::get('/gallery-categories', [GalleryCategoryController::class, 'index'])->middleware('web.permission:gallery_categories.view')->name('gallery-categories.index');
    Route::get('/gallery-categories/create', [GalleryCategoryController::class, 'create'])->middleware('web.permission:gallery_categories.create')->name('gallery-categories.create');
    Route::post('/gallery-categories', [GalleryCategoryController::class, 'store'])->middleware('web.permission:gallery_categories.create')->name('gallery-categories.store');
    Route::get('/gallery-categories/{galleryCategory}/edit', [GalleryCategoryController::class, 'edit'])->middleware('web.permission:gallery_categories.update')->name('gallery-categories.edit');
    Route::put('/gallery-categories/{galleryCategory}', [GalleryCategoryController::class, 'update'])->middleware('web.permission:gallery_categories.update')->name('gallery-categories.update');
    Route::delete('/gallery-categories/{galleryCategory}', [GalleryCategoryController::class, 'destroy'])->middleware('web.permission:gallery_categories.delete')->name('gallery-categories.destroy');
});
