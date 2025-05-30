<?php

use App\Models\User;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// check if one user exists, do not allow registration after that

//if (User::exists()) {
//    $mware = 'auth';
//} else {
//    $mware = 'guest';
//}


Route::get('/register', [RegisteredUserController::class, 'create'])
    //    ->middleware($mware)
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);
//    ->middleware($mware);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    //    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
//    ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    //    ->middleware($mware)
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    //    ->middleware($mware)
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    //    ->middleware($mware)
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    //    ->middleware($mware)
    ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    //    ->middleware('auth')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    //    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    //    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);
//    ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    //    ->middleware('auth')
    ->name('logout');
