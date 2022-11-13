<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

//https://www.jairogarciarincon.com/clase/creacion-de-un-cms-en-php-con-laravel/enrutando-la-home


//Front-end
Route::get('/', [AppController::class, 'index'])->name('home');
Route::get('noticias', [AppController::class, 'noticias'])->name('noticias');
Route::get('noticia/{slug}', [AppController::class, 'noticia'])->name('noticia');
Route::get('acerca-de', [AppController::class, 'acercade'])->name('acerca-de');

//Back-end
Route::get('admin', [AdminController::class, 'index'])->name('admin');

//Auth
Route::get('acceder', [AuthController::class, 'acceder'])->name('acceder');
Route::post('autenticar', [AuthController::class, 'autenticar'])->name('autenticar');
Route::get('registro', [AuthController::class, 'registro'])->name('registro');
Route::post('registrarse', [AuthController::class, 'registrarse'])->name('registrarse');
Route::post('salir', [AuthController::class, 'salir'])->name('salir');


