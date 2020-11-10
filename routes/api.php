<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\RegisterController;
use \App\Http\Controllers\CompanyController;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\ReviewController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('companies/{company}/products', ProductController::class);
    Route::apiResource('products/{product}/reviews', ReviewController::class);
});
