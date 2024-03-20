<?php

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
Route::post('v1/login', [UserController::class, 'login'])->name('login');
Route::apiResource('v1/user', UserController::class);
Route::apiResource('v1/categories', CategoryController::class);
Route::apiResource('v1/brand', BrandController::class);
Route::apiResource('v1/product', ProductController::class);
// // Route::put('/v1/categories/update/{id}', function(Request $request) {
// //     dd($request->all());
// });

