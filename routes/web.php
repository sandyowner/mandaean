<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('login');
});

Route::get('login', [LoginController::class, 'Login']);
Route::post('login-data', [LoginController::class, 'index']);

Route::group(['middleware'=>['checklogin','preventBackHistory']],function()
{
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('logout', [LoginController::class, 'logout']);
});