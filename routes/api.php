<?php

use App\Http\Resources\ProductJsonApiResource;
use App\Http\Resources\UserJsonApiResource;
use App\Http\Resources\OrderJsonApiResource;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products', function () {
    return new \App\Http\Resources\ProductCollection(Product::paginate());
});

Route::post('/v1/login', [\App\Http\Controllers\Api\LoginApiController::class, 'loginApi'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/profile', [\App\Http\Controllers\Api\LoginApiController::class, 'getProfile']);
    Route::post('/logout', [\App\Http\Controllers\Api\LoginApiController::class, 'logoutApi']);
});

// JSON:API v2 endpoints (Laravel 13 feature)
Route::prefix('v2')->group(function () {
    Route::get('/products', function () {
        return ProductJsonApiResource::collection(Product::paginate());
    });

    Route::get('/products/{product}', function (Product $product) {
        return new ProductJsonApiResource($product);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/users/{user}', function (User $user) {
            return new UserJsonApiResource($user->load('orders'));
        });

        Route::get('/orders', function (Request $request) {
            $orders = Order::where('user_id', $request->user()->id)->paginate();
            return OrderJsonApiResource::collection($orders);
        });

        Route::get('/orders/{order}', function (Order $order) {
            return new OrderJsonApiResource($order->load('user'));
        });
    });
});

// AI-powered endpoints (Laravel 13 AI SDK)
Route::middleware('auth:sanctum')->prefix('ai')->group(function () {
    Route::post('/product-description', [\App\Http\Controllers\Api\AiController::class, 'generateProductDescription']);
    Route::get('/products/{product}/generate-description', [\App\Http\Controllers\Api\AiController::class, 'generateDescription']);
});
