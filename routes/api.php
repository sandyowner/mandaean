<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ContainerController;
use App\Http\Controllers\Api\CategoryController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('signup', [AuthController::class,'singup']);
Route::post('login', [AuthController::class,'login']);
Route::post('forgot', [AuthController::class,'forgot']);
Route::post('get-otp', [AuthController::class,'getOTP']);
Route::post('verify-otp', [AuthController::class,'verifyOTP']);
Route::get('countries/insert', [ContainerController::class,'countriesInsert']);
Route::get('countries', [ContainerController::class,'countries']);
Route::middleware('auth:sanctum')->group( function () {
    Route::post('profile', [UserController::class,'profile']);
    Route::post('update-profile', [UserController::class,'updateProfile']);
    Route::post('delete-account', [UserController::class,'deleteAccount']);
    Route::get('mandanism-list', [CategoryController::class,'MandanismList']);
    Route::get('mandanism-detail/{id}', [CategoryController::class,'MandanismDetail']);
    Route::get('latest-news-list', [CategoryController::class,'LatestNewsList']);
    Route::get('latest-news-detail/{id}', [CategoryController::class,'LatestNewsDetail']);
    Route::get('holy-book-list', [CategoryController::class,'HolyBookList']);
});