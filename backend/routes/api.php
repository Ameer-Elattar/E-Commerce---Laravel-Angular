<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([

    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::group(['middleware' => 'auth'], function () {
    Route::apiResource('users', UserController::class);
});


Route::apiResource('products', ProductController::class)->middleware("auth");
Route::apiResource('carts', CartController::class);

Route::get('products/title/{title}', [ProductController::class, 'showByName']);




Route::delete('/users/{id}/cart', [CartController::class, 'destroyAllCartItems']);
Route::get('/users/{id}/cart', [CartController::class, 'getAllCartItems']);



Route::delete('/users/{id}/cart', [CartController::class, 'destroyAllCartItems']);
Route::get('/users/{id}/cart', [CartController::class, 'getAllCartItems']);




Route::apiResource('orders', OrderController::class);
// Route::get('/orders', [OrderController::class, 'index']);