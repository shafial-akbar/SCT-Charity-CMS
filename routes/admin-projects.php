<?php
use App\Http\Controllers\Admin\ProjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/projects',[ProjectController::class,'index'])->middleware('web.permission:projects.view')->name('projects.index');
    Route::get('/projects/create',[ProjectController::class,'create'])->middleware('web.permission:projects.create')->name('projects.create');
    Route::post('/projects',[ProjectController::class,'store'])->middleware('web.permission:projects.create')->name('projects.store');
    Route::get('/projects/{project}/edit',[ProjectController::class,'edit'])->middleware('web.permission:projects.update')->name('projects.edit');
    Route::put('/projects/{project}',[ProjectController::class,'update'])->middleware('web.permission:projects.update')->name('projects.update');
    Route::delete('/projects/{project}',[ProjectController::class,'destroy'])->middleware('web.permission:projects.delete')->name('projects.destroy');
});
