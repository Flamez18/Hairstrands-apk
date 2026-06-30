<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Customer Routes (Protected with role:user)
    Route::middleware('role:user')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Marketplace
        Route::get('/toko', [MarketplaceController::class, 'index'])->name('marketplace');
        Route::get('/toko/{slug}', [MarketplaceController::class, 'detail'])->name('marketplace.detail');

        // Cart
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

        // Checkout
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

        // Payment Simulation
        Route::get('/payment/dummy/{id}', [PaymentController::class, 'dummy'])->name('payment.dummy');
        Route::post('/payment/process/{id}', [PaymentController::class, 'simulateProcess'])->name('payment.process');
        Route::get('/payment/success/{id}', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('/payment/invoice/{id}', [PaymentController::class, 'invoice'])->name('payment.invoice');

        // Expert Booking
        Route::get('/dokter', [ExpertController::class, 'index'])->name('experts');
        Route::get('/dokter/{id}', [ExpertController::class, 'detail'])->name('experts.detail');
        Route::post('/dokter/booking', [ExpertController::class, 'booking'])->name('experts.booking');
        Route::get('/dokter/booking/success/{id}', [ExpertController::class, 'bookingSuccess'])->name('experts.booking_success');

        // Profile & History
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Admin Routes (Protected with role:admin)
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // CRUD Categories
        Route::get('/categories', [AdminController::class, 'categoriesIndex'])->name('admin.categories.index');
        Route::get('/categories/create', [AdminController::class, 'categoriesCreate'])->name('admin.categories.create');
        Route::post('/categories', [AdminController::class, 'categoriesStore'])->name('admin.categories.store');
        Route::get('/categories/{id}/edit', [AdminController::class, 'categoriesEdit'])->name('admin.categories.edit');
        Route::post('/categories/{id}', [AdminController::class, 'categoriesUpdate'])->name('admin.categories.update');
        Route::delete('/categories/{id}', [AdminController::class, 'categoriesDestroy'])->name('admin.categories.destroy');

        // CRUD Products
        Route::get('/products', [AdminController::class, 'productsIndex'])->name('admin.products.index');
        Route::get('/products/create', [AdminController::class, 'productsCreate'])->name('admin.products.create');
        Route::post('/products', [AdminController::class, 'productsStore'])->name('admin.products.store');
        Route::get('/products/{id}/edit', [AdminController::class, 'productsEdit'])->name('admin.products.edit');
        Route::post('/products/{id}', [AdminController::class, 'productsUpdate'])->name('admin.products.update');
        Route::delete('/products/{id}', [AdminController::class, 'productsDestroy'])->name('admin.products.destroy');

        // CRUD Hair Experts
        Route::get('/experts', [AdminController::class, 'expertsIndex'])->name('admin.experts.index');
        Route::get('/experts/create', [AdminController::class, 'expertsCreate'])->name('admin.experts.create');
        Route::post('/experts', [AdminController::class, 'expertsStore'])->name('admin.experts.store');
        Route::get('/experts/{id}/edit', [AdminController::class, 'expertsEdit'])->name('admin.experts.edit');
        Route::post('/experts/{id}', [AdminController::class, 'expertsUpdate'])->name('admin.experts.update');
        Route::delete('/experts/{id}', [AdminController::class, 'expertsDestroy'])->name('admin.experts.destroy');

        // CRUD Schedules
        Route::get('/schedules', [AdminController::class, 'schedulesIndex'])->name('admin.schedules.index');
        Route::get('/schedules/create', [AdminController::class, 'schedulesCreate'])->name('admin.schedules.create');
        Route::post('/schedules', [AdminController::class, 'schedulesStore'])->name('admin.schedules.store');
        Route::delete('/schedules/{id}', [AdminController::class, 'schedulesDestroy'])->name('admin.schedules.destroy');

        // Manage Bookings
        Route::get('/bookings', [AdminController::class, 'bookingsIndex'])->name('admin.bookings.index');
        Route::post('/bookings/{id}/status', [AdminController::class, 'updateBookingStatus'])->name('admin.bookings.status');
    });
});
