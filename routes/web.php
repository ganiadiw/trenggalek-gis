<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubDistrictController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Guest\TouristDestinationController as GuestTouristDestinationController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TouristDestinationController;
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
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::middleware(['admin'])->group(function () {
            Route::get('users/search', [UserController::class, 'search'])->name('users.search');
            Route::resource('users', UserController::class);

            Route::get('sub-districts/search', [SubDistrictController::class, 'search'])->name('sub-districts.search');
            Route::get('sub-districts/{sub_district}/download', [SubDistrictController::class, 'download'])->name('sub-districts.download');
            Route::get('sub-districts/{sub_district}/related-tourist-destination', [SubDistrictController::class, 'relatedTouristDestination'])->name('sub-districts.related-tourist-destination');
            Route::resource('sub-districts', SubDistrictController::class);

            Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
            Route::resource('categories', CategoryController::class);
        });

        Route::get('tourist-destinations/search', [TouristDestinationController::class, 'search'])->name('tourist-destinations.search');
        Route::resource('tourist-destinations', TouristDestinationController::class);

        Route::prefix('images')->group(function () {
            Route::post('/', [ImageController::class, 'store'])->name('images.store');
            Route::delete('/{filename}', [ImageController::class, 'destroy'])->name('images.destroy');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tourist-destinations/{tourist_destination}', GuestTouristDestinationController::class)->name('guest.tourist-destinations.show');

require __DIR__.'/auth.php';
