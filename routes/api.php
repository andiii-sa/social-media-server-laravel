<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogCategoryController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\PresenceListDayController;
use App\Http\Controllers\API\PresenceLocationWorkController;
use App\Http\Controllers\API\PresenceScheduleEmployeeController;
use App\Models\PresenceLocationWork;
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
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['jwt.verify'],], function () {
    // Route user have role Admin
    Route::group(['middleware' => 'isAdmin',], function () {
        Route::get('detailToken', [AuthController::class, 'detailToken']);

        // Blog
        Route::post('blog-category', [BlogCategoryController::class, 'created']);
        Route::put('blog-category/{id}/update', [BlogCategoryController::class, 'updated']);
        Route::put('blog-category/{id}/restore', [BlogCategoryController::class, 'restored']);
        Route::delete('blog-category/{id}', [BlogCategoryController::class, 'deleted']);
        Route::delete('blog-category/{id}/force', [BlogCategoryController::class, 'forceDeleted']);
        Route::post('blog-category/file-import', [BlogCategoryController::class, 'fileImportData']);

        Route::post('blog', [BlogController::class, 'created']);
        Route::post('blog/{id}/update', [BlogController::class, 'updated']);
        Route::delete('blog/{id}', [BlogController::class, 'deleted']);
        Route::delete('blog/{id}/force', [BlogController::class, 'forceDeleted']);
        Route::put('blog/{id}/restore', [BlogController::class, 'restored']);

        // Presence
        Route::post('presence/location-work', [PresenceLocationWorkController::class, 'created']);
        Route::put('presence/location-work/{id}/update', [PresenceLocationWorkController::class, 'updated']);
        Route::delete('presence/location-work/{id}', [PresenceLocationWorkController::class, 'deleted']);
        Route::delete('presence/location-work/{id}/force', [PresenceLocationWorkController::class, 'forceDeleted']);
        Route::put('presence/location-work/{id}/restore', [PresenceLocationWorkController::class, 'restored']);

        Route::post('presence/schedule', [PresenceScheduleEmployeeController::class, 'created']);
        Route::put('presence/schedule/{id}/update', [PresenceScheduleEmployeeController::class, 'updated']);
        Route::delete('presence/schedule/{id}', [PresenceScheduleEmployeeController::class, 'deleted']);
        Route::delete('presence/schedule/{id}/force', [PresenceScheduleEmployeeController::class, 'forceDeleted']);
        Route::put('presence/schedule/{id}/restore', [PresenceScheduleEmployeeController::class, 'restored']);
        Route::post('presence/schedule/file-import', [PresenceScheduleEmployeeController::class, 'fileImportData']);
    });

    // Route All Role

});


// Public

// Blog
Route::get('blog-category/all', [BlogCategoryController::class, 'showAll']);
Route::get('blog-category/{id}/detail', [BlogCategoryController::class, 'detail']);
Route::get('blog-category', [BlogCategoryController::class, 'show']);
Route::get('blog-category/file-export', [BlogCategoryController::class, 'fileExportData']);
Route::get('blog-category/file-export-format', [BlogCategoryController::class, 'fileExportFormat']);

Route::get('blog/all', [BlogController::class, 'showAll']);
Route::get('blog', [BlogController::class, 'show']);
Route::get('blog/{id}/detail', [BlogController::class, 'detail']);

// Presence
Route::get('presence/list-day/all', [PresenceListDayController::class, 'showAll']);

Route::get('presence/location-work/all', [PresenceLocationWorkController::class, 'showAll']);
Route::get('presence/location-work', [PresenceLocationWorkController::class, 'show']);
Route::get('presence/location-work/{id}/detail', [PresenceLocationWorkController::class, 'detail']);

Route::get('presence/schedule/all', [PresenceScheduleEmployeeController::class, 'showAll']);
Route::get('presence/schedule', [PresenceScheduleEmployeeController::class, 'show']);
Route::get('presence/schedule/{id}/detail', [PresenceScheduleEmployeeController::class, 'detail']);
Route::get('presence/schedule/file-export', [PresenceScheduleEmployeeController::class, 'fileExportData']);
Route::get('presence/schedule/file-export-format', [PresenceScheduleEmployeeController::class, 'fileExportFormat']);

// EXAMPLE MULTI SHEETS
Route::get('blog/file-export-ms', [BlogController::class, 'fileExportDataMS']);
