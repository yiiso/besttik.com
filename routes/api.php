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
                'youtube' => ['name' => 'YouTube', 'domains' => ['youtube.com', 'youtu.be']],
                'tiktok' => ['name' => 'TikTok', 'domains' => ['tiktok.com']],
                'instagram' => ['name' => 'Instagram', 'domains' => ['instagram.com']],
                'twitter' => ['name' => 'Twitter/X', 'domains' => ['twitter.com', 'x.com']],
                'facebook' => ['name' => 'Facebook', 'domains' => ['facebook.com', 'fb.com']],
                'bilibili' => ['name' => 'Bilibili', 'domains' => ['bilibili.com']],
                'douyin' => ['name' => 'Douyin', 'domains' => ['douyin.com']]
            ]
        ]);
    })->name('api.supported-platforms');
});