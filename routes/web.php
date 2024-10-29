<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/enviar', [MainController::class, 'main'])->name('main');
Route::post('/upload-ponto', [MainController::class, 'handleUpload'])->name('ponto.upload.handle');

Route::get('/', [MenuController::class, 'menu'])->name('menu');
Route::get('/get-servidor', [MenuController::class, 'getServidor'])->name('getServidor');
