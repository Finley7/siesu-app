<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(static function () {
    Route::get('register', static function () : \Illuminate\View\View {
        return (new \App\Http\Controllers\Auth\RegisteredUserController())->create();
    })
                ->name('register');
    Route::post('register', static function (\Illuminate\Http\Request $request) : \Illuminate\Http\RedirectResponse {
        return (new \App\Http\Controllers\Auth\RegisteredUserController())->store($request);
    });
    Route::get('login', static function () : \Illuminate\View\View {
        return (new \App\Http\Controllers\Auth\AuthenticatedSessionController())->create();
    })
                ->name('login');
    Route::post('login', static function (\App\Http\Requests\Auth\LoginRequest $request) : \Illuminate\Http\RedirectResponse {
        return (new \App\Http\Controllers\Auth\AuthenticatedSessionController())->store($request);
    });
    Route::get('forgot-password', static function () : \Illuminate\View\View {
        return (new \App\Http\Controllers\Auth\PasswordResetLinkController())->create();
    })
                ->name('password.request');
    Route::post('forgot-password', static function (\Illuminate\Http\Request $request) : \Illuminate\Http\RedirectResponse {
        return (new \App\Http\Controllers\Auth\PasswordResetLinkController())->store($request);
    })
                ->name('password.email');
    Route::get('reset-password/{token}', static function (\Illuminate\Http\Request $request) : \Illuminate\View\View {
        return (new \App\Http\Controllers\Auth\NewPasswordController())->create($request);
    })
                ->name('password.reset');
    Route::post('reset-password', static function (\Illuminate\Http\Request $request) : \Illuminate\Http\RedirectResponse {
        return (new \App\Http\Controllers\Auth\NewPasswordController())->store($request);
    })
                ->name('password.store');
});

Route::middleware('auth')->group(static function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');
    Route::post('email/verification-notification', static function (\Illuminate\Http\Request $request) : \Illuminate\Http\RedirectResponse {
        return (new \App\Http\Controllers\Auth\EmailVerificationNotificationController())->store($request);
    })
                ->middleware('throttle:6,1')
                ->name('verification.send');
    Route::get('confirm-password', static function () : \Illuminate\View\View {
        return (new \App\Http\Controllers\Auth\ConfirmablePasswordController())->show();
    })
                ->name('password.confirm');
    Route::post('confirm-password', static function (\Illuminate\Http\Request $request) : \Illuminate\Http\RedirectResponse {
        return (new \App\Http\Controllers\Auth\ConfirmablePasswordController())->store($request);
    });
    Route::put('password', static function (\Illuminate\Http\Request $request) : \Illuminate\Http\RedirectResponse {
        return (new \App\Http\Controllers\Auth\PasswordController())->update($request);
    })->name('password.update');
    Route::post('logout', static function (\Illuminate\Http\Request $request) : \Illuminate\Http\RedirectResponse {
        return (new \App\Http\Controllers\Auth\AuthenticatedSessionController())->destroy($request);
    })
                ->name('logout');
});
