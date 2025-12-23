<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\PageController;
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
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [PageController::class, 'index'])->name('home');

    Route::post('/login', AuthController::class)->name('login');
});



Route::group(['middleware' => 'auth'], function () {
    Route::get('/search', [PageController::class, 'search'])->name('trains.search');
    Route::get('/show/{id}', [PageController::class, 'show'])->name('routes.show');
    Route::get('/route/{route}/service', [PageController::class, 'service'])->name('routes.service');
    Route::get('/route/{route}/wagons/{wagon}/seats', [PageController::class, 'seats'])->name('routes.seats');
    Route::get('/route/{route}/wagons/{wagon}/passenger', [PageController::class, 'passenger'])->name('routes.passenger');
});

