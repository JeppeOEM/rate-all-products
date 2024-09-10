<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Auth\Events\Login;
use Inertia\Inertia;

#Login
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth');

Route::get('/register', function () {
    return inertia('Auth/Create');
});

#Users
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update'])->can('update', 'App\Models\User');

#Email verification
Route::get('/verify-email', EmailVerificationPromptController::class)
    ->name('verification.notice');
Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware('throttle:6,1');

#Auth required routes    
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', function () {
        return inertia('Home');
    });

    Route::get('/product-list', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
});
