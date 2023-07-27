<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\PaymentController;


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

Route::get('/cmd/{cmd}', function ($cmd) {
    Artisan::call($cmd);
    dd("run successfully");
});
Route::get('composer-update', function () {system('composer update');});
Route::get('composer-install', function () {system('composer install');});
Route::get('clear-cache', function () {echo Artisan::call('cache:clear');});
Route::get('clear-config', function () {echo Artisan::call('config:clear');});
Route::get('clear-route', function () {echo Artisan::call('route:clear');});

Route::get('/', function () {
    return redirect('login');
});

Route::get('login', [LoginController::class, 'Login']);
Route::post('login-data', [LoginController::class, 'index']);
Route::get('verify/{token}', [AuthController::class,'verify']);
Route::get('forgot-password/{token}', [AuthController::class,'forgotPassword']);
Route::post('forgot-password', [AuthController::class,'updatePassword']);

Route::group(['middleware'=>['checklogin','preventBackHistory']],function()
{
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('logout', [LoginController::class, 'logout']);
    Route::resource('users', UsersController::class);
});

Route::controller(PaymentController::class)
    ->prefix('paypal')
    ->group(function () {
        Route::view('payment', 'paypal.index')->name('create.payment');
        Route::get('handle-payment', 'handlePayment')->name('make.payment');
        Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
        Route::get('payment-success', 'paymentSuccess')->name('success.payment');
    });