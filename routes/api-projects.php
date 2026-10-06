<?php
use App\Http\Controllers\Api\V1\ProjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function(){
    Route::get('/projects',[ProjectController::class,'index'])->name('api.v1.projects.index');
    Route::get('/projects/{slug}',[ProjectController::class,'show'])->name('api.v1.projects.show');
});
