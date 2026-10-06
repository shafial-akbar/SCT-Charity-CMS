<?php

use App\Http\Controllers\Admin\GalleryPhotoController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/gallery-photos', [GalleryPhotoController::class, 'index'])
        ->middleware('web.permission:gallery_photos.view')
        ->name('gallery-photos.index');

    Route::get('/gallery-photos/create', [GalleryPhotoController::class, 'create'])
        ->middleware('web.permission:gallery_photos.create')
        ->name('gallery-photos.create');

    Route::post('/gallery-photos', [GalleryPhotoController::class, 'store'])
        ->middleware('web.permission:gallery_photos.create')
        ->name('gallery-photos.store');

    Route::get('/gallery-photos/{galleryPhoto}', [GalleryPhotoController::class, 'show'])
        ->middleware('web.permission:gallery_photos.view')
        ->name('gallery-photos.show');

    Route::get('/gallery-photos/{galleryPhoto}/edit', [GalleryPhotoController::class, 'edit'])
        ->middleware('web.permission:gallery_photos.update')
        ->name('gallery-photos.edit');

    Route::put('/gallery-photos/{galleryPhoto}', [GalleryPhotoController::class, 'update'])
        ->middleware('web.permission:gallery_photos.update')
        ->name('gallery-photos.update');

    Route::delete('/gallery-photos/{galleryPhoto}', [GalleryPhotoController::class, 'destroy'])
        ->middleware('web.permission:gallery_photos.delete')
        ->name('gallery-photos.destroy');
});
