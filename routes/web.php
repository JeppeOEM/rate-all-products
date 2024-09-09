<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Auth\Events\Login;
use Inertia\Inertia;

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store']);
Route::post('logout', [LoginController::class, 'destroy'])->middleware('auth');

Route::get('/auth/create', function () {
    return inertia('Auth/Create');
});

Route::get('/users/create', function () {
    return Inertia('Users/Create');
})->can('create', 'App\Models\User');


Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update'])->can('update', 'App\Models\User');

Route::get('verify-email', EmailVerificationPromptController::class)
->name('verification.notice');

Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
->middleware(['signed', 'throttle:6,1'])
->name('verification.verify');

Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
->middleware('throttle:6,1')
->name('verification.send');


Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return inertia('Home');
    });

    // Route::get('/auth/login', function () {
    //     return inertia('Auth/Login');
    // });

    Route::get('/filelist', function () {
        $allFiles = Storage::allFiles('/unimported');
        $archivedFiles = Storage::allFiles('/archived');
        return response()->json([
            'files' => $allFiles,
            'archivedFiles' => $archivedFiles,
        ]);
    });
});
