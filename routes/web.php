<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubDistrictController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('users/search', [UserController::class, 'search'])->name('users.search');
        Route::resource('users', UserController::class)->middleware('admin');

        Route::get('sub-districts/search', [SubDistrictController::class, 'search'])->name('sub-districts.search');
        Route::resource('sub-districts', SubDistrictController::class)->middleware('admin');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
