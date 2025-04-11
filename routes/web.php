<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas da sua aplicação.
| Estas rotas são carregadas pelo RouteServiceProvider dentro do grupo "web".
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rotas de autenticação (login, logout, register, etc)
Auth::routes();

// Rota principal após login
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('posts', PostController::class);
});
