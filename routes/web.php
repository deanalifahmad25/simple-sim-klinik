<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [RegistrationController::class, 'index'])->name('dashboard');
    Route::get('/registration-history', [RegistrationController::class, 'show'])->name('registration_history');
    Route::post('/search-registration-history', [RegistrationController::class, 'search'])->name('search_registration_history');
    Route::get('/registration-history/detail/{registration}', [RegistrationController::class, 'detail'])->name('registration_history_detail');

    Route::group(['middleware' => ['permission:registration']], function () {
        Route::get('/patient', [RegistrationController::class, 'patient'])->name('patient');
        Route::get('/registration/{patient?}', [RegistrationController::class, 'create'])->name('registration');
        Route::post('/registration', [RegistrationController::class, 'store'])->name('store_registration');
        Route::put('/registration/{patient}', [RegistrationController::class, 'update'])->name('store_patient_exist_registration');
        Route::delete('/registration/unregist/{patient}', [RegistrationController::class, 'destroy'])->name('destroy_registration');
    });

    Route::group(['middleware' => ['permission:vital_sign']], function () {
        Route::get('/vital_sign/{registration}', [ServiceController::class, 'vital_sign'])->name('vital_sign');
        Route::put('/vital_sign/{registration}', [ServiceController::class, 'store_vital_sign'])->name('store_vital_sign');
    });

    Route::group(['middleware' => ['permission:diagnose']], function () {
        Route::get('/diagnose/{registration}', [ServiceController::class, 'diagnose'])->name('diagnose');
        Route::put('/diagnose/{registration}', [ServiceController::class, 'store_diagnose'])->name('store_diagnose');
    });

    Route::group(['middleware' => ['permission:order']], function () {
        Route::get('/product', [ServiceController::class, 'product'])->name('product');
        Route::get('/product/create/{product?}', [ServiceController::class, 'create_product'])->name('create_product');
        Route::post('/product/save', [ServiceController::class, 'store_product'])->name('store_product');
        Route::put('/product/save/{product}', [ServiceController::class, 'update_product'])->name('update_product');
        Route::delete('/product/delete/{product}', [ServiceController::class, 'destroy_product'])->name('destroy_product');

        Route::get('/order/{registration}', [ServiceController::class, 'index'])->name('order');
        Route::post('/order/save/{registration}', [ServiceController::class, 'store'])->name('store_order');
        Route::delete('/order/delete/{order}', [ServiceController::class, 'destroy_order'])->name('destroy_order');
    });

    Route::group(['middleware' => ['role:superadmin']], function () {
        Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

        Route::post('register', [RegisteredUserController::class, 'store']);
    });
});

require __DIR__.'/auth.php';
