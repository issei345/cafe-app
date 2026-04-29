<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController; // TAMBAHAN

Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menus/{id}', [MenuController::class, 'show']);
Route::post('/menus', [MenuController::class, 'store']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);

// ORDER (TAMBAHAN)
Route::post('/orders', [OrderController::class, 'store']);

// test endpoint
Route::get('/test', function () {
    return response()->json([
        'message' => 'API jalan'
    ]);
});