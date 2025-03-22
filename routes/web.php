<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

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

// Registration routes
Route::get('register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('active/{user}', [RegisterController::class, 'active'])->middleware('signed')->name('active');

// Authentication routes
Route::get('/', [AuthController::class, 'create'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::get('2fa/{id}', [AuthController::class, 'create2FA'])->where('id', '[0-9]+')->middleware(['signed'])->name('2fa');
Route::post('2fa/{id}', [AuthController::class, 'verify2FA'])->where('id', '[0-9]+')->name('2fa.verify');

// Protected routes
Route::middleware(['auth', 'isActive'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

// Fallback route
Route::view('notfound', 'notfound')->name('notfound');