<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\AdminAuth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'login'])->name("login");
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');

Route::get('/registration', [RegisterController::class,'registration'])->name("registration");
Route::post('/registration', [RegisterController::class, 'registrationSubmit'])->name('registration.submit');

Route::get('/home', [PageController::class, 'home'])->name('home');
Route::get('/profile', [PageController::class, 'profile'])->name('profile')->middleware('auth.basic');

Route::prefix('admin')->group(static function() {
    Route::get('/login', [AdminLoginController::class, 'login'])->name("admin.login");
    Route::post('/login', [AdminLoginController::class, 'authenticate'])->name('admin.login.submit');

    Route::middleware('auth:admin')->group(static function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [UsersController::class, 'index'])->name('admin.users');
        Route::resource('products', ProductController::class)->name('index','admin.products');

        // Start: Password confirm
        Route::get('/confirm-password', function () {
            return view('auth.admin.confirm-password');
        })->middleware('auth:admin')->name('password.confirm');

        Route::post('/confirm-password', [LoginController::class, 'confirmPassword'])->middleware(['auth', 'throttle:6,1']);

        Route::get('/settings', function () {
            return 'setting';
        })->middleware(['password.confirm']);

        Route::post('/settings', function () {
            // ...
        })->middleware(['password.confirm']);
        // End: Password confirm

    });
});

Route::fallback(function () {
    return view('page.404');
});
