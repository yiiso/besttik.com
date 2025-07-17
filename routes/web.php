<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoParserController;

// 默认路由（中文）
Route::get('/', function () {
    app()->setLocale('zh');
    return view('home');
});

// 多语言路由组
Route::prefix('{locale}')->where(['locale' => '[a-zA-Z]{2}'])->group(function () {
    Route::get('/', function ($locale) {
        if (in_array($locale, ['zh', 'en', 'es'])) {
            app()->setLocale($locale);
            return view('home');
        }
        abort(404);
    });
});

// API路由
Route::post('/parse', [VideoParserController::class, 'parse'])->name('video.parse');
