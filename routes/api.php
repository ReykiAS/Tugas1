<?php
use App\Http\Middleware\ApiProductMiddleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Models\Brand;
use App\Models\Product;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('v1/productss', [ProductController::class, 'index']);
Route::post('v1/login', [UserController::class, 'login'])->name('login');
Route::apiResource('v1/user', UserController::class);

//auth permasing masing user
Route::middleware('auth:sanctum',ApiProductMiddleware::class)->group(function() {
    Route::get('v1/products', [ProductController::class, 'index']);
    Route::get('v1/products/{product}', [ProductController::class, 'show']);
    Route::post('v1/products', [ProductController::class, 'store']);
    Route::put('v1/products/{product}', [ProductController::class, 'update']);
    Route::delete('v1/products/{product}', [ProductController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('v1/categories', CategoryController::class);
    Route::apiResource('v1/brand', BrandController::class);
});




