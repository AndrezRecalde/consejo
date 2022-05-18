<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VeedoresController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\CoordinadorController;

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
    Route::get('/coordinador/detail/{coordinador}', [CoordinadorController::class, 'detail']);
    Route::get('/supervisor/detail/{supervisor}', [SupervisorController::class, 'detail']);
    //PDF
    Route::get('/users-pdf/{user}', [PDFController::class, 'getUsers']);
    Route::get('/users-pdf', [PDFController::class, 'getUsersAll']);
    Route::get('/veedores-pdf', [PDFController::class, 'getVeedores']);

    Route::get('/veedores-supervisores', [PDFController::class, 'getSupervisores']);
    Route::get('/veedores-coordinadores', [PDFController::class, 'getCoordinadores']);

    Route::get('/veedores-coordinadores/{user}', [PDFController::class, 'getVeedoresWithCoord']);

    Route::get('/veedores-parroquias/{user}', [PDFController::class, 'getVeedoresWithParroquia']);


});
Route::get('/login', [AuthController::class, 'loginIndex'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
