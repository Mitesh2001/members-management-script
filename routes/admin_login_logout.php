<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    // Admin Login/Logout
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout')
    ;

    // Admin Login Forgot
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request')
    ;
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email')
    ;

    // Admin Forgot Password Reset
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset')
    ;
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])
        ->name('password.update')
    ;
});
