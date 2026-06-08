<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\TicketController;
use App\Http\Controllers\Public\UserController;
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


    Route::post('/login', AuthController::class)->name('login');
});
Route::get('/home', [PageController::class, 'index'])->name('home');
Route::get('/', [PageController::class, 'index']);


Route::group(['middleware' => 'auth'], function () {
    Route::get('/search', [PageController::class, 'search'])->name('trains.search');
    Route::get('/show/{id}', [PageController::class, 'show'])->name('routes.show');
    Route::get('/route/{route}/service', [PageController::class, 'service'])->name('routes.service');
    Route::get('/route/{route}/wagons/{wagon}/seats', [PageController::class, 'seats'])->name('routes.seats');
    Route::get('/route/{route}/wagons/{wagon}/passenger', [PageController::class, 'passenger'])->name('routes.passenger');



    Route::get('/passport', [PageController::class, 'passport'])->name('pages.passport');
    Route::get('/passenger/create', [UserController::class, 'create'])->name('passenger.create');
    Route::get('/passenger/{id}/edit', [UserController::class, 'edit'])->name('passenger.edit');
    Route::get('/passenger/{id}', [UserController::class, 'show'])->name('passenger.show');
    Route::post('/passenger', [UserController::class, 'store'])->name('passenger.store');
    Route::put('/passenger/{id}', [UserController::class, 'update'])->name('passenger.update');



    Route::post('/ticket/store', [TicketController::class, 'store'])->name('ticket.store');



    Route::post('/logout', AuthController::class)->name('logout');
});

