<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\CheckoutController;

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');
// Grouping untuk URL berawalan /admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Rute Login bebas akses
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Mengamankan Route Administrasi di balik tembok (Middleware)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });
});


    //MIDTRANS
    Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');

Route::get('/event', [EventController::class, 'event'])->name('event');

Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');

Route::get('/ticket', [TicketController::class, 'ticket'])->name('ticket');

Route::get('/checkout/{event}',
    [CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::post('/checkout/{event}',
    [CheckoutController::class, 'store'])
    ->name('checkout.store');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTE
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

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
        ->name('transactions.index');

    // CATEGORY CRUD
    Route::resource('categories', CategoryController::class);

    // PARTNER CRUD
    Route::resource('partners', PartnerController::class);

});
    //tambahan

    Route::get('/payment/{order_id}',
        [CheckoutController::class, 'payment']
    )->name('checkout.payment');

    Route::get('/success/{order_id}',
        [CheckoutController::class, 'success']
    )->name('checkout.success');

