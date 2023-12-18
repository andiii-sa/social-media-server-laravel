<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => ['jwt.verify'],
], function () {
    Route::get('detailToken', [AuthController::class, 'detailToken']);
});


Route::get('blog-category/all', [BlogCategoryController::class, 'getAll']);
Route::get('blog-category/{id}/detail', [BlogCategoryController::class, 'detail']);
Route::get('blog-category', [BlogCategoryController::class, 'get']);
Route::post('blog-category', [BlogCategoryController::class, 'create']);
Route::put('blog-category/{id}/update', [BlogCategoryController::class, 'update']);
Route::put('blog-category/{id}/restore', [BlogCategoryController::class, 'restore']);
Route::delete('blog-category/{id}', [BlogCategoryController::class, 'delete']);
Route::delete('blog-category/{id}/permanent', [BlogCategoryController::class, 'deletePermanent']);
