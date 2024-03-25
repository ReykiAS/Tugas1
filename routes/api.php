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
Route::get('v1/products', [ProductController::class, 'index']);
Route::post('v1/login', [UserController::class, 'login'])->name('login');
Route::apiResource('v1/user', UserController::class);


Route::middleware('auth:sanctum', ApiProductMiddleware::class)->prefix('v1')->group(function () {
    Route::get('products/deleted', [ProductController::class, 'showDeleted'])->name('products.deleted.index');
    Route::put('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::apiResource('products', ProductController::class)->except(['index']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function() {
    Route::get('categories/deleted', [CategoryController::class, 'showDeleted']);
    Route::put('categories/{id}/restore', [CategoryController::class, 'restore']);
    Route::get('brands/deleted', [BrandController::class, 'showDeleted']);
    Route::put('brand/{id}/restore', [BrandController::class, 'restore']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('brands', BrandController::class);
    Route::post('/logout', [UserController::class, 'logout']);
});




