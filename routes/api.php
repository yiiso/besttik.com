<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoParserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API routes for video parsing
Route::prefix('v1')->group(function () {
    Route::post('/parse', [VideoParserController::class, 'parse'])->name('api.video.parse');
    
    Route::get('/supported-platforms', function () {
        return response()->json([
            'platforms' => [
                'douyin' => ['name' => '抖音', 'domains' => ['douyin.com', 'iesdouyin.com']],
                'tiktok' => ['name' => 'TikTok', 'domains' => ['tiktok.com', 'vm.tiktok.com']],
                'instagram' => ['name' => 'Instagram', 'domains' => ['instagram.com']],
                'bilibili' => ['name' => 'B站', 'domains' => ['bilibili.com', 'b23.tv']],
                'kuaishou' => ['name' => '快手', 'domains' => ['kuaishou.com', 'kwai.com']],
                'xiaohongshu' => ['name' => '小红书', 'domains' => ['xiaohongshu.com', 'xhslink.com']],
                'weibo' => ['name' => '微博', 'domains' => ['weibo.com', 'weibo.cn']],
                'twitter' => ['name' => 'Twitter', 'domains' => ['twitter.com', 'x.com']],
                'facebook' => ['name' => 'Facebook', 'domains' => ['facebook.com', 'fb.com']],
                'snapchat' => ['name' => 'Snapchat', 'domains' => ['snapchat.com']],
                // 删除这行 YouTube 配置（第18行）
                // 'youtube' => ['name' => 'YouTube', 'domains' => ['youtube.com', 'youtu.be']],
            ]
        ]);
    })->name('api.supported-platforms');
});// 管理
员API路由
Route::prefix('admin')->middleware('admin.auth')->group(function () {
    Route::get('/stats/today', [App\Http\Controllers\Admin\DashboardController::class, 'getTodayData']);
    Route::get('/stats/weekly', [App\Http\Controllers\Admin\DashboardController::class, 'getWeeklyData']);
});