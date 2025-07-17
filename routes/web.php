<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoParserController;

Route::get('/', function () {
    return view('home');
});

Route::post('/parse', [VideoParserController::class, 'parse'])->name('video.parse');
