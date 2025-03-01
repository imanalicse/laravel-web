<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\AdminAuth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Enum\UserRole;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('dispatch-event/{order_id}', [PageController::class, 'dispatchEvent']);
Route::get('dispatch-job/', [PageController::class, 'dispatchJob']);

Route::get('/login', [LoginController::class, 'login'])->name("login");
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
Route::get('/registration', [RegisterController::class,'registration'])->name("registration");
Route::post('/registration', [RegisterController::class, 'registrationSubmit'])->name('registration.submit');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/products', [ProductController::class, 'index'])->name("products");

Route::post('/add-to-cart', [CartController::class, 'addToCart']);
Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout', [CheckoutController::class,'checkout']);

Route::singleton('profile', ProfileController::class)->middleware('auth.basic'); // Singleton Resource Controllers

Route::prefix('admin')->group(static function() {
    Route::get('/login', [AdminLoginController::class, 'login'])->name("admin.login");
    Route::post('/login', [AdminLoginController::class, 'authenticate'])->name('admin.login.submit');

    Route::middleware('auth:admin')->group(static function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [UsersController::class, 'index'])->name('admin.users');
        Route::resource('products', ProductAdminController::class)->name('index','admin.products.index');

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

        Route::get('/super', function () {
            return 'super_admin';
        })->middleware('role:'. UserRole::SUPER_ADMIN);
    });
});

// Payment
Route::post('/paypal/createPayPalOrder', [\App\Http\Controllers\Payment\PayPalController::class, 'createPayPalOrder']);
Route::post('/paypal/orders/{paypal_order_id}/capture', [\App\Http\Controllers\Payment\PayPalController::class, 'capturePayPalPayment']);
Route::get('/stripe/create-payment-intent', [\App\Http\Controllers\Payment\StripeController::class, 'createPaymentIntent']);
Route::post('/stripe/order', [\App\Http\Controllers\CheckoutController::class, 'createStripeOrder']);
Route::get('/order/success/{reference_code}', [\App\Http\Controllers\CheckoutController::class, 'orderSuccess']);
Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index']);
Route::get('/send-email', [\App\Http\Controllers\MailController::class, 'sendTestEmail']);

// Resource API
Route::get('/user/{id}', function (string $id) {
    return new UserResource(User::findOrFail($id));
});
Route::get('/users', function () {
    return new UserCollection(User::all());
});
