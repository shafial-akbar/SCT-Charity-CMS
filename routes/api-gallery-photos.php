<?php

use App\Http\Controllers\Api\V1\GalleryPhotoController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    Route::get('/gallery-photos', [GalleryPhotoController::class, 'index'])
        ->name('api.v1.gallery-photos.index');

    Route::get('/gallery-photos/{identifier}', [GalleryPhotoController::class, 'show'])
        ->name('api.v1.gallery-photos.show');
});
