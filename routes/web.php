<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\WebviewController;
use App\Http\Controllers\Admin\RitualController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PrayerController;
use App\Http\Controllers\Admin\MandanismController;
use App\Http\Controllers\Admin\HolyBookController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\StaticController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BaptismVenueController;
use App\Http\Controllers\Admin\BaptismController;
use App\Http\Controllers\Admin\FuneralController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ReligiousOccasionController;
use App\Http\Controllers\Admin\AdvertismentController;
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

Route::get('static-page-app', [WebviewController::class, 'app_term']);
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
    Route::resource('mandanism', MandanismController::class);
    Route::resource('ritual', RitualController::class);
    Route::resource('news', NewsController::class);
    Route::resource('prayer', PrayerController::class);
    Route::resource('books', HolyBookController::class);
    Route::resource('product', ProductController::class);
    Route::post('remove-image', [ProductController::class,'RemoveImage']);
    Route::resource('orders', OrderController::class);
    Route::resource('transaction', TransactionController::class);
    Route::resource('static-content', StaticController::class);
    Route::resource('color', ColorController::class);
    Route::resource('size', SizeController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('baptism-venue', BaptismVenueController::class);
    Route::resource('baptism', BaptismController::class);
    Route::resource('funeral', FuneralController::class);
    Route::resource('program', ProgramController::class);
    Route::resource('religious-occasion', ReligiousOccasionController::class);
    Route::resource('advertisment', AdvertismentController::class);
});

Route::controller(PaymentController::class)
    ->prefix('paypal')
    ->group(function () {
        Route::view('success', 'paypal.success')->name('paypal.success');
        Route::view('error', 'paypal.error')->name('paypal.error');
        Route::get('handle-payment', 'handlePayment')->name('make.payment');
        Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
        Route::get('payment-success', 'paymentSuccess')->name('success.payment');
    });