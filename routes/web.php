<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MidtransWebhookController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\Admin\OrganizerController;


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});


/*
|--------------------------------------------------------------------------
| GOOGLE LOGIN CUSTOMER
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');


/*
|--------------------------------------------------------------------------
| LOGOUT CUSTOMER
|--------------------------------------------------------------------------
*/

Route::post('/customer/logout', function () {

    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');

})->name('customer.logout');


/*
|--------------------------------------------------------------------------
| MIDTRANS
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle']);


/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/event', [EventController::class, 'event'])
    ->name('event');

Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');

Route::get('/checkout', [EventController::class, 'checkout'])
    ->name('checkout');


/*
|--------------------------------------------------------------------------
| CUSTOMER YANG SUDAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | REVIEW
    |--------------------------------------------------------------------------
    */

    Route::post('/reviews/{event}', [ReviewController::class, 'store'])
        ->name('reviews.store');


    /*
    |--------------------------------------------------------------------------
    | TICKET
    |--------------------------------------------------------------------------
    */

    Route::get('/ticket', [TicketController::class, 'ticket'])
        ->name('ticket');


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    Route::get('/checkout/{event}', [CheckoutController::class, 'create'])
        ->name('checkout.create');

    Route::post('/checkout/{event}', [CheckoutController::class, 'store'])
        ->name('checkout.store');


    /*
    |--------------------------------------------------------------------------
    | PAYMENT
    |--------------------------------------------------------------------------
    */

    Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])
        ->name('checkout.payment');

    Route::get('/success/{order_id}', [CheckoutController::class, 'success'])
        ->name('checkout.success');

});


/*
|--------------------------------------------------------------------------
| ADMIN + ORGANIZER
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        Route::get('/transactions', [TransactionController::class, 'index'])
            ->name('transactions.index');


        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

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

        Route::get(
    '/certificate/{transaction}',
    [TransactionController::class, 'certificate']
)->name('transactions.certificate');

Route::get('/admin/transactions/pdf', [TransactionController::class, 'exportPdf'])
    ->name('transactions.pdf');
    });


/*
|--------------------------------------------------------------------------
| SUPER ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'superadmin'])
    ->group(function () {

        Route::resource('categories', CategoryController::class);

        Route::resource('partners', PartnerController::class);

        Route::resource('jabatan', JabatanController::class);

        Route::resource('pengurus', PengurusController::class);

        Route::resource('organizers', OrganizerController::class);

    });