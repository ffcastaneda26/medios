<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');

// Categorías
Route::get('/{category:slug}', [HomeController::class, 'category'])
    ->name('category.show')
    ->where('category', '[a-zA-Z0-9\-]+');

// Detalle de noticia
Route::get('/noticia/{slug}', [HomeController::class, 'show'])
    ->name('news.show')
    ->where('slug', '[a-zA-Z0-9\-]+');
