<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\HeroController;

// Публичные роуты
Route::get('/', [HomeController::class, 'index']);
Route::get('/services', [PublicServiceController::class, 'index'])->name('services.index');
Route::get('/packages', [PublicServiceController::class, 'packages'])->name('packages.index');

// Авторизация
Route::get('/register', function () {
    return redirect('/')->with('open_auth', 'register');
});
Route::get('/login', function () {
    return redirect('/')->with('open_auth', 'login');
});
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Личный кабинет
Route::middleware(['auth'])->group(function () {
    Route::get('/cabinet', [UserController::class, 'index'])->name('cabinet');
    Route::post('/cabinet/profile', [UserController::class, 'updateProfile'])->name('update.profile');
    Route::post('/cabinet/password', [UserController::class, 'changePassword'])->name('change.password');
    Route::post('/cabinet/review', [UserController::class, 'submitReview'])->name('submit.review');
    Route::post('/cabinet/order', [UserController::class, 'createOrder'])->name('create.order');
    Route::post('/cabinet/favorite', [UserController::class, 'toggleFavorite'])->name('favorite.toggle');
    Route::delete('/cabinet/favorite/{favorite}', [UserController::class, 'removeFavorite'])->name('favorite.remove');
});

// Админка
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [DashboardController::class, 'users'])->name('admin.users');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('admin.orders');
    Route::patch('/orders/{order}', [DashboardController::class, 'updateOrderStatus'])->name('admin.orders.update');

    Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    Route::get('/content', [ContentController::class, 'edit'])->name('admin.content.edit');
    Route::post('/content', [ContentController::class, 'update'])->name('admin.content.update');
    Route::post('/content/slides', [ContentController::class, 'storeSlide'])->name('admin.slides.store');
    Route::post('/content/slides/{id}', [ContentController::class, 'updateSlide'])->name('admin.slides.update');
    Route::delete('/content/slides/{id}', [ContentController::class, 'destroySlide'])->name('admin.slides.destroy');

    Route::get('/heroes', [HeroController::class, 'index'])->name('admin.heroes.index');
    Route::post('/heroes', [HeroController::class, 'store'])->name('admin.heroes.store');
    Route::put('/heroes/{hero}', [HeroController::class, 'update'])->name('admin.heroes.update');
    Route::delete('/heroes/{hero}', [HeroController::class, 'destroy'])->name('admin.heroes.destroy');

    Route::resource('services', ServiceController::class)->names('admin.services');
    Route::resource('packages', PackageController::class)->names('admin.packages');
});
