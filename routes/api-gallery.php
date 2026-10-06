<?php

use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\GalleryPhotoController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {

    Route::get('/galleries', [GalleryController::class, 'index'])
        ->name('api.v1.galleries.index');

    Route::get('/galleries/{slug}', [GalleryController::class, 'show'])
        ->name('api.v1.galleries.show');

    Route::get('/gallery-photos', [GalleryPhotoController::class, 'index'])
        ->name('api.v1.gallery-photos.index');

    Route::get('/gallery-photos/gallery/{slug}', [GalleryPhotoController::class, 'gallery'])
        ->name('api.v1.gallery-photos.gallery');

    Route::get('/gallery-photos/{id}', [GalleryPhotoController::class, 'show'])
        ->name('api.v1.gallery-photos.show');

});