<?php

use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest')->group(function () {
    Route::get('/register', [
        AuthController::class,
        'showRegister'
    ])->name('register');

    Route::post('/register', [
        AuthController::class,
        'register'
    ])->middleware('throttle:10,1');

    Route::get('/login', [
        AuthController::class,
        'showLogin'
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login'
    ])->middleware('throttle:10,1');
});

Route::post('/logout', [
    AuthController::class,
    'logout'
])->middleware('auth')->name('logout');

Route::get('/dashboard', function () {
    return view('account.dashboard');
})->name('dashboard');

Route::get('/', [MarketplaceController::class, 'home'])->name('home');
Route::get('/category/{category:slug}', [MarketplaceController::class, 'category'])->name('category.show');
Route::get('/{country}/{state}/{city}', [MarketplaceController::class, 'city'])
    ->where(['country' => '[a-z0-9-]+', 'state' => '[a-z0-9-]+', 'city' => '[a-z0-9-]+'])
    ->name('city.show');
Route::get('/{country}/{state}/{city}/category/{category:slug}', [MarketplaceController::class, 'cityCategory'])
    ->where(['country' => '[a-z0-9-]+', 'state' => '[a-z0-9-]+', 'city' => '[a-z0-9-]+'])
    ->name('city-category.show');
Route::get('/listing/{listing:slug}', [MarketplaceController::class, 'show'])->name('listing.show');

// Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
//     Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
//     Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
//     Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
//     Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
//     Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
//     Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');
// });

Route::middleware('auth')
    ->prefix('account')
    ->name('account.')
    ->group(function () {

        // Dashboard route
        Route::get('/dashboard', function () {
            return view('account.dashboard');
        })->name('dashboard');

        // Existing listing routes
        Route::get('/listings', [ListingController::class, 'index'])
            ->name('listings.index');

        Route::get('/listings/create', [ListingController::class, 'create'])
            ->name('listings.create');

        Route::post('/listings', [ListingController::class, 'store'])
            ->name('listings.store');

        Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])
            ->name('listings.edit');

        Route::put('/listings/{listing}', [ListingController::class, 'update'])
            ->name('listings.update');

        Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])
            ->name('listings.destroy');
    });