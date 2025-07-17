<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoParserController;

// 默认路由（英文）
Route::get('/', function () {
    app()->setLocale('en');
    return view('home');
});

// 多语言路由组
Route::prefix('{locale}')->where(['locale' => '[a-zA-Z]{2}'])->group(function () {
    Route::get('/', function ($locale) {
        if (in_array($locale, ['zh', 'en', 'es','fr','ja'])) {
            app()->setLocale($locale);
            return view('home');
        }
        abort(404);
    });
});

// API路由
Route::post('/parse', [VideoParserController::class, 'parse'])->name('video.parse');

// 认证路由
use App\Http\Controllers\AuthController;
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth 路由
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
