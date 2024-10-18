<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'main'])->name('main');
Route::post('/upload-ponto', [MainController::class, 'handleUpload'])->name('ponto.upload.handle');

Route::get('/menu', [MenuController::class, 'menu'])->name('menu');