<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/event', [EventController::class, 'event'])->name('event');

Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');

Route::get('/ticket', [TicketController::class, 'ticket'])->name('ticket');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTE
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // EVENTS CRUD
    Route::get('/events', [AdminEventController::class, 'index'])
        ->name('admin.events');

    Route::get('/events/create', [AdminEventController::class, 'create'])
        ->name('admin.events.create');

    Route::post('/events', [AdminEventController::class, 'store'])
        ->name('admin.events.store');

    Route::get('/events/{id}/edit', [AdminEventController::class, 'edit'])
        ->name('admin.events.edit');

    Route::put('/events/{id}', [AdminEventController::class, 'update'])
        ->name('admin.events.update');

    Route::delete('/events/{id}', [AdminEventController::class, 'destroy'])
        ->name('admin.events.destroy');

    // TRANSACTIONS
    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('admin.transactions');

    // CATEGORY CRUD
    Route::resource('categories', CategoryController::class);

    // PARTNER CRUD
    Route::resource('partners', PartnerController::class);

});

/*
|--------------------------------------------------------------------------
| TEST ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/test', function () {
    return 'Test Route';
});

Route::get('/test/{id}', function ($id) {
    return 'Test Parameter: ' . $id;
});

Route::get('/test/{id}/{param}', function ($id, $param) {
    return 'Test Parameter: ' . $id . ' - Param:' . $param;
});

/*
|--------------------------------------------------------------------------
| LATIHAN
|--------------------------------------------------------------------------
*/

Route::get('/latihan1/{nama}', function ($nama) {
    return view('latihan1', ['nama' => $nama]);
});

Route::get('/latihan2/{nama}', function ($nama) {
    return view('latihan2', ['nama' => $nama]);
});