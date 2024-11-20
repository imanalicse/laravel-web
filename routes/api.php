<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products', function () {
    return new \App\Http\Resources\ProductCollection(Product::paginate());
});

Route::post('/login', [\App\Http\Controllers\Api\LoginApiController::class, 'loginApi']);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/profile', [\App\Http\Controllers\Api\LoginApiController::class, 'getProfile']);
    Route::post('/logout', [\App\Http\Controllers\Api\LoginApiController::class, 'logoutApi']);
});
