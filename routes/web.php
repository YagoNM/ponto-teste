<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'main'])->name('main');
Route::post('/upload-ponto', [MainController::class, 'handleUpload'])->name('ponto.upload.handle');