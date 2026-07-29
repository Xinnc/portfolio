<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;



//доступно всем
Route::post('/review', [ReviewController::class, 'store']);
Route::get('/review', [ReviewController::class, 'index']);
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/project/{category:slug}', [ProjectController::class, 'index']);
Route::get('/settings', [UserController::class, 'settings']);

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/info', function () {
        $user = auth()->user();
        $bool = false;
        if ($user->role == 'admin') {
            $bool = true;
        }
        return $bool;
    });
    Route::get('/logout', [UserController::class, 'logout']);
    //отзывы
    Route::patch('/review/{review}', [ReviewController::class, 'update']);
    Route::get('/review/all', [ReviewController::class, 'indexAll']);
    Route::delete('/review/{review}', [ReviewController::class, 'destroy']);
    //категории
    Route::apiResource('/category', CategoryController::class)->only(['store', 'update', 'destroy']);
    Route::get('/category/all', [CategoryController::class, 'indexAll']);
    //проекты
    Route::post('/project/{category}', [ProjectController::class, 'store']);
    Route::post('/project/{project}/media', [ProjectController::class, 'storeMedia']);
    Route::patch('/project/{project}', [ProjectController::class, 'update']);
    Route::delete('/project/{project}', [ProjectController::class, 'destroy']);
    Route::delete('/project/media/{media}', [ProjectController::class, 'destroyMedia']);
    Route::get('/project/media/{project}', [ProjectController::class, 'getMedia']);
    //контактные данные
    Route::patch('/settings', [UserController::class, 'updateSettings']);
    Route::post('/settings', [UserController::class, 'createSettings']);
});
