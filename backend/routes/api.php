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

// authentication route with JWT 
Route::group([

    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

// route with no authentication 
Route::post('users', [UserController::class, 'store']); // register user



// Route::group(['middleware' => 'multi.auth:api,api-admins'], function () {
Route::apiResource('users', UserController::class)->except(['store']);
Route::apiResource('products', ProductController::class);
Route::get('products/title/{title}', [ProductController::class, 'showByName']);
Route::get('products/{id} ', [ProductController::class, 'show']);

Route::apiResource('carts', CartController::class);

// });











Route::delete('/users/{id}/cart', [CartController::class, 'destroyAllCartItems']);
Route::get('/users/{id}/cart', [CartController::class, 'getAllCartItems']);




Route::apiResource('orders', OrderController::class);
Route::get('/orders/{id}/cancel', [OrderController::class, 'cancel']);
Route::get('/orders/{id}/done', [OrderController::class, 'done']);
// Route::get('/orders', [OrderController::class, 'index']);

Route::apiResource('admins', AdminController::class);
