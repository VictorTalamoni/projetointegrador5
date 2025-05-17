<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GasolinaController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('posts', PostController::class);

    // Novas rotas para JSON e importação
    Route::get('/precos-json', [PostController::class, 'showPrecosJson'])->name('posts.json');
    Route::get('/precos-importar', [PostController::class, 'importarJsonParaMongo'])->name('posts.importar');
});

// API pública (se necessário)
Route::get('/api/gasolina', [GasolinaController::class, 'getPrecos']);
