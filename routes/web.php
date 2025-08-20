<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

    // 使用帮助页面（单页面替代help模块）
    Route::get('/help', function () {
        return view('pages.help-guide');
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

    // 抖音专用解析页面
    Route::get('/douyin-parser', function () {
        return view('pages.douyin-parser');
    })->name('douyin-parser');

    Route::get('/douyin', function () {
        return view('pages.douyin-parser');
    })->name('douyin');

    Route::get('/抖音解析', function () {
        return view('pages.douyin-parser');
    })->name('douyin-chinese');

    // 其他平台专题页面
    Route::get('/xiaohongshu', function () {
        return view('pages.xiaohongshu-parser');
    })->name('xiaohongshu');

    Route::get('/小红书解析', function () {
        return view('pages.xiaohongshu-parser');
    })->name('xiaohongshu-chinese');

    // 删除这个路由定义（大约第72-74行）
    // Route::get('/youtube', function () {
    //     return view('pages.youtube-parser');
    // })->name('youtube');

    Route::get('/bilibili', function () {
        return view('pages.bilibili-parser');
    })->name('bilibili');

    Route::get('/B站解析', function () {
        return view('pages.bilibili-parser');
    })->name('bilibili-chinese');

    Route::get('/kuaishou', function () {
        return view('pages.kuaishou-parser');
    })->name('kuaishou');

    Route::get('/快手解析', function () {
        return view('pages.kuaishou-parser');
    })->name('kuaishou-chinese');

    Route::get('/weibo', function () {
        return view('pages.weibo-parser');
    })->name('weibo');

    Route::get('/微博解析', function () {
        return view('pages.weibo-parser');
    })->name('weibo-chinese');

    Route::get('/tiktok', function () {
        return view('pages.tiktok-parser');
    })->name('tiktok');

    Route::get('/instagram', function () {
        return view('pages.instagram-parser');
    })->name('instagram');

    Route::get('/facebook', function () {
        return view('pages.facebook-parser');
    })->name('facebook');

    Route::get('/twitter', function () {
        return view('pages.twitter-parser');
    })->name('twitter');

    Route::get('/snapchat', function () {
        return view('pages.snapchat-parser');
    })->name('snapchat');

    Route::get('/pinterest', function () {
        return view('pages.pinterest-parser');
    })->name('pinterest');

});


// 多语言路由组
Route::prefix('{locale}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['detect.language','set.locale'])
    ->group(function () {
        Route::get('/', function () {
            return view('home');
        });
    // 多语言页面路由
        Route::get('/batch-download', function () {
            return view('pages.batch-download');
        })->name('batch-download.locale');

        Route::get('/api', function () {
            return view('pages.api');
        })->name('api.locale');

        // 多语言使用帮助页面
        Route::get('/help', function () {
            return view('pages.help-guide');
        })->name('help.locale');

        Route::get('/contact', function () {
            return view('pages.contact');
        })->name('contact.locale');

        Route::get('/privacy', function () {
            return view('pages.privacy');
        })->name('privacy.locale');

        Route::get('/terms', function () {
            return view('pages.terms');
        })->name('terms.locale');

        Route::get('/dashboard', function () {
            return view('pages.dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard.locale');

        // 多语言抖音专用解析页面
        Route::get('/douyin-parser', function () {
            return view('pages.douyin-parser');
        })->name('douyin-parser.locale');

        Route::get('/douyin', function () {
            return view('pages.douyin-parser');
        })->name('douyin.locale');

        // 多语言其他平台专题页面
        Route::get('/xiaohongshu', function () {
            return view('pages.xiaohongshu-parser');
        })->name('xiaohongshu.locale');

        // 在本地化路由中删除YouTube路由（大约第179-181行）
        // Route::get('youtube', function () {
        //     return view('pages.youtube-parser');
        // })->name('youtube.locale');

        Route::get('/bilibili', function () {
            return view('pages.bilibili-parser');
        })->name('bilibili.locale');

        Route::get('/kuaishou', function () {
            return view('pages.kuaishou-parser');
        })->name('kuaishou.locale');

        Route::get('/weibo', function () {
            return view('pages.weibo-parser');
        })->name('weibo.locale');

        Route::get('/tiktok', function () {
            return view('pages.tiktok-parser');
        })->name('tiktok.locale');

        Route::get('/instagram', function () {
            return view('pages.instagram-parser');
        })->name('instagram.locale');

        Route::get('/facebook', function () {
            return view('pages.facebook-parser');
        })->name('facebook.locale');

        Route::get('/twitter', function () {
            return view('pages.twitter-parser');
        })->name('twitter.locale');

        Route::get('/snapchat', function () {
            return view('pages.snapchat-parser');
        })->name('snapchat.locale');

        Route::get('/pinterest', function () {
            return view('pages.pinterest-parser');
        })->name('pinterest.locale');
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
        Route::get('/security', [App\Http\Controllers\Admin\SecurityController::class, 'index'])->name('security');
        Route::get('/new-users', [App\Http\Controllers\Admin\DashboardController::class, 'newUsers'])->name('new-users');
        Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

        // 安全相关接口
        Route::post('/unlock', [App\Http\Controllers\Admin\SecurityController::class, 'unlock'])->name('unlock');
        Route::get('/login-stats', [App\Http\Controllers\Admin\SecurityController::class, 'getLoginStats'])->name('login-stats');
        Route::get('/abnormal-ips', [App\Http\Controllers\Admin\SecurityController::class, 'getAbnormalIps'])->name('abnormal-ips');
        Route::get('/abnormal-emails', [App\Http\Controllers\Admin\SecurityController::class, 'getAbnormalEmails'])->name('abnormal-emails');

        // API接口
        Route::get('/api/today', [App\Http\Controllers\Admin\DashboardController::class, 'getTodayData'])->name('api.today');
        Route::get('/api/today-hourly', [App\Http\Controllers\Admin\DashboardController::class, 'getTodayHourlyData'])->name('api.today-hourly');
        Route::get('/api/weekly', [App\Http\Controllers\Admin\DashboardController::class, 'getWeeklyData'])->name('api.weekly');
        Route::get('/api/stats', [App\Http\Controllers\Admin\DashboardController::class, 'getStatsDataApi'])->name('api.stats');
        Route::get('/api/parse-logs', [App\Http\Controllers\Admin\DashboardController::class, 'getParseLogsData'])->name('api.parse-logs');
        Route::get('/ip-stats', [App\Http\Controllers\Admin\DashboardController::class, 'getIpStats'])->name('ip-stats');
        Route::post('/batch-ip-location', [App\Http\Controllers\Admin\DashboardController::class, 'batchIpLocation'])->name('batch-ip-location');
    });
});
