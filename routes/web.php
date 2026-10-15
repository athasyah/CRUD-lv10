<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompanionsController;
use App\Http\Controllers\DestinationsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\TripsController;
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

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/'); // Redirect ke halaman utama setelah logout
})->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/register', function () {
    return view('auth.register'); // Pastikan file view ada
});

Auth::routes();

Route::resource('trips', TripsController::class);
Route::resource('destinations', DestinationsController::class);
Route::resource('activities', ActivitiesController::class);
Route::resource('expenses', ExpensesController::class);
Route::resource('companions', CompanionsController::class);
Route::get('/get-trip-dates/{destination}', [ActivitiesController::class, 'getTripDates']);


// Route untuk halaman edit 
Route::get('trips/{trip}/edit', [TripsController::class, 'edit'])->name('trips.edit');

// Route untuk update 
Route::put('trips/{trip}', [TripsController::class, 'update'])->name('trips.update');

// Route untuk update 
Route::put('/destinations/{destination}/edit', [DestinationsController::class, 'edit'])->name('destinations.edit');




