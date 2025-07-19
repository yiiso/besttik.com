<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoParserController;

// 默认路由（英文）- 应用语言检测中间件
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

    // 多语言页面路由
    Route::get('/batch-download', function ($locale) {
        if (in_array($locale, ['zh', 'en', 'es','fr','ja'])) {
            app()->setLocale($locale);
            return view('pages.batch-download');
        }
        abort(404);
    })->name('batch-download.locale');

    Route::get('/api', function ($locale) {
        if (in_array($locale, ['zh', 'en', 'es','fr','ja'])) {
            app()->setLocale($locale);
            return view('pages.api');
        }
        abort(404);
    })->name('api.locale');

    Route::get('/help', function ($locale) {
        if (in_array($locale, ['zh', 'en', 'es','fr','ja'])) {
            app()->setLocale($locale);
            return view('pages.help');
        }
        abort(404);
    })->name('help.locale');

    Route::get('/contact', function ($locale) {
        if (in_array($locale, ['zh', 'en', 'es','fr','ja'])) {
            app()->setLocale($locale);
            return view('pages.contact');
        }
        abort(404);
    })->name('contact.locale');

    Route::get('/privacy', function ($locale) {
        if (in_array($locale, ['zh', 'en', 'es','fr','ja'])) {
            app()->setLocale($locale);
            return view('pages.privacy');
        }
        abort(404);
    })->name('privacy.locale');

    Route::get('/terms', function ($locale) {
        if (in_array($locale, ['zh', 'en', 'es','fr','ja'])) {
            app()->setLocale($locale);
            return view('pages.terms');
        }
        abort(404);
    })->name('terms.locale');
});

// API路由
Route::post('/parse', [VideoParserController::class, 'parse'])->name('video.parse');
Route::get('/parse-status', [VideoParserController::class, 'getParseStatus'])->name('video.parse.status');

// 语言设置路由
Route::post('/set-language-preference', function(\Illuminate\Http\Request $request) {
    $language = $request->input('language');
    $userSelected = $request->input('user_selected', false);

    if (in_array($language, ['zh', 'en', 'es', 'fr', 'ja'])) {
        // 设置cookie，有效期30天
        cookie()->queue('language', $language, 60 * 24 * 30);

        return response()->json([
            'status' => 'success',
            'message' => 'Language preference saved'
        ]);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'Invalid language'
    ], 400);
})->name('language.set');

// 认证路由
use App\Http\Controllers\AuthController;
Route::get('/authTest', [AuthController::class, 'authTest'])->name('auth.test');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth 路由
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// 页面路由
Route::get('/batch-download', function () {
    return view('pages.batch-download');
})->name('batch-download');

Route::get('/api', function () {
    return view('pages.api');
})->name('api');

Route::get('/help', function () {
    return view('pages.help');
})->name('help');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');
