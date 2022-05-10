<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VeedoresController;

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
 
Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logoutweb']);

    Route::get('/perfil', [PerfilController::class, 'index']);
    Route::get('/registers/users',    [UsersController::class, 'indexview']);                         //vista de usuarios
    Route::get('/registers/veedores', [VeedoresController::class, 'indexview']);
    Route::get('/veedor/detail/{veedor}', [VeedoresController::class, 'detail']);
    //PDF
    Route::get('/users-pdf', [PDFController::class, 'getUsers']);
    Route::get('/veedores-pdf', [PDFController::class, 'getVeedores']);
});
Route::get('/login', [AuthController::class, 'loginIndex'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
