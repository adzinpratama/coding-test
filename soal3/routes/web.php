<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MutasiController,
    TopupController,
    WithdrawController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login', 301);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {


    Route::resource('topup', TopupController::class)
        ->only('index', 'store');
    Route::prefix('/topup')->as('topup.')->group(function () {

        Route::get('/choose-method', [TopupController::class, 'choose_method'])
            ->name('choose-method');
    });

    Route::prefix('/withdraw')->as('withdraw.')->group(function () {

        Route::get('/', [WithdrawController::class, 'index'])->name('index');

        Route::post('/store', [WithdrawController::class, 'store'])->name('store');
    });

    Route::prefix('/mutasi')->as('mutasi.')->group(function () {
        Route::get('/', [MutasiController::class, 'index'])->name('index');
    });
});



require __DIR__ . '/auth.php';
