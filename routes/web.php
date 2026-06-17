<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Private\AdminController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\TicketController;
use App\Http\Controllers\Public\UserController;
use App\Http\Controllers\PassangerController;
use App\Http\Controllers\Auth\LogoutController;
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
    Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('/admin/submit', [AdminController::class, 'login'])->name('admin.login.submit');
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
    Route::get('/ticket/{ticket}', [TicketController::class, 'show'])->name('ticket.show');



    Route::get('/personal', [UserController::class, 'personal'])->name('users.personal');
    Route::get('/logout', LogoutController::class)->name('logout');



    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['can:admin'])
        ->group(function () {

            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::get('/tickets', [AdminController::class, 'tickets'])->name('tickets');
            Route::get('/users', [AdminController::class, 'users'])->name('users');
            Route::get('/passangers', [AdminController::class, 'passangers'])->name('passangers');
            Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
            Route::get('/admin/users/import', [AdminController::class, 'showPdf'])->name('users.import.page');
            Route::post('/admin/users/import', [AdminController::class, 'import'])->name('users.import');
            Route::get('/admin/users/pdf/{file}', [AdminController::class, 'viewPdf'])->name('users.pdf.view');
            Route::get('/admin/users/pdf/{file}/download', [AdminController::class, 'downloadPdf'])->name('users.pdf.download');
            Route::delete('/admin/users/pdf/{file}', [AdminController::class, 'deleteFile'])
                ->name('pdf.delete');
            Route::get('/admin/groups', [GroupController::class, 'index'])->name('groups.index');
            Route::get('/admin/groups', [GroupController::class, 'groups'])
                ->name('groups');

            Route::get('/admin/groups/{id}', [GroupController::class, 'showGroup'])
                ->name('groups.show');
            Route::delete('/admin/groups/{id}', [GroupController::class, 'deleteGroup'])->name('groups.delete');
            Route::delete('/admin/users/{id}', [GroupController::class, 'deleteUser'])->name('users.delete');

            Route::get('/admin/tickets', [AdminController::class, 'tickets'])->name('tickets');
            Route::get('/admin/tickets/{id}', [AdminController::class, 'showTicket'])->name('tickets.show');
            Route::delete('/admin/tickets/{id}', [AdminController::class, 'deleteTicket'])->name('tickets.delete');

            Route::get('/admin/passangers', [PassangerController::class, 'passangers'])->name('passangers');
            Route::get('/admin/passangers/{id}', [PassangerController::class, 'showPassanger'])->name('passangers.show');
            Route::delete('/admin/passangers/{id}', [PassangerController::class, 'deletePassanger'])->name('passangers.delete');
        });
});

