<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function(){
    return response()->json(['message' => 'Test route']);
});

Route::controller(AuthenticationController::class)->group(function (){
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    // Order controller
    Route::controller(OrderController::class)->prefix('orders')->group(function () {
        Route::post('/store','store');
        Route::get('/show/{id}', 'show');
    });

    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::post('/update', 'update');
    });
});
