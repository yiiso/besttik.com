<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoParserController;
// 认证路由
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\UserDashboardController;


// 默认路由（英文）- 应用语言检测中间件

Route::middleware(['detect.language','set.locale'])->group(function (){
    Route::get('/', function () {
        return view('home');
    });
    // 用户中心页面
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

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

});


// 多语言路由组
Route::prefix('{locale}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['detect.language','set.locale'])
    ->group(function () {
        Route::get('/', function ($locale) {
            return view('home');
        });
    // 多语言页面路由
        Route::get('/batch-download', function ($locale) {
            return view('pages.batch-download');
        })->name('batch-download.locale');

        Route::get('/api', function ($locale) {
            return view('pages.api');
        })->name('api.locale');

        Route::get('/help', function ($locale) {
            return view('pages.help');
        })->name('help.locale');

        Route::get('/contact', function ($locale) {
            return view('pages.contact');
        })->name('contact.locale');

        Route::get('/privacy', function ($locale) {
            return view('pages.privacy');
        })->name('privacy.locale');

        Route::get('/terms', function ($locale) {
            return view('pages.terms');
        })->name('terms.locale');

        Route::get('/dashboard', function ($locale) {
            return view('pages.dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard.locale');
});

// API路由
Route::post('/parse', [VideoParserController::class, 'parse'])->name('video.parse');
Route::get('/parse-status', [VideoParserController::class, 'getParseStatus'])->name('video.parse.status');
Route::get('/authTest', [AuthController::class, 'authTest'])->name('auth.test');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 邮箱验证路由
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');
Route::post('/email/resend', [AuthController::class, 'resendVerificationEmail'])
    ->name('verification.resend');
Route::get('/email/verify',[AuthController::class,'emailVerify'])->name('verification.notice');

// Contact API
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// 需要登录和邮箱验证的路由
Route::middleware(['auth', 'verified'])->group(function () {
    // 用户仪表板
    Route::get('/api/dashboard', [UserDashboardController::class, 'getDashboardData'])->name('dashboard.data');

    // 推荐功能
    Route::get('/api/referral/link', [ReferralController::class, 'getReferralLink'])->name('referral.link');
    Route::get('/api/referral/stats', [ReferralController::class, 'getReferralStats'])->name('referral.stats');
});


// Google OAuth 路由
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');


// 管理员路由
Route::prefix('admin')->name('admin.')->group(function () {
    // 登录路由（不需要认证）
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    
    // 密码重置路由（不需要认证）
    Route::get('/forgot-password', [App\Http\Controllers\Admin\PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Admin\PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Admin\PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Admin\PasswordResetController::class, 'resetPassword'])->name('password.update');
    
    // 需要管理员认证的路由
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/parse-logs', [App\Http\Controllers\Admin\DashboardController::class, 'parseLogs'])->name('parse-logs');
        Route::get('/parse-logs/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'parseLogDetail'])->name('parse-log-detail');
        Route::get('/security', function () { return view('admin.security'); })->name('security');
        Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('password.update');
        Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
        
        // 安全相关接口
        Route::post('/unlock', [App\Http\Controllers\Admin\AuthController::class, 'unlock'])->name('unlock');
        Route::get('/login-stats', [App\Http\Controllers\Admin\AuthController::class, 'getLoginStats'])->name('login-stats');
        
        // API接口
        Route::get('/api/today', [App\Http\Controllers\Admin\DashboardController::class, 'getTodayData'])->name('api.today');
        Route::get('/api/today-hourly', [App\Http\Controllers\Admin\DashboardController::class, 'getTodayHourlyData'])->name('api.today-hourly');
        Route::get('/api/weekly', [App\Http\Controllers\Admin\DashboardController::class, 'getWeeklyData'])->name('api.weekly');
        Route::get('/api/stats', [App\Http\Controllers\Admin\DashboardController::class, 'getStatsDataApi'])->name('api.stats');
        Route::get('/api/parse-logs', [App\Http\Controllers\Admin\DashboardController::class, 'getParseLogsData'])->name('api.parse-logs');
    });
});