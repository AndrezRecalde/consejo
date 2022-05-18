<?php

use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VeedoresController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'signUp']);

});

 
Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::get('/logout', [AuthController::class, 'logoutapi']);

    //StatesController
    Route::get('cantones', [StatesController::class, 'loadCantones']);                      //Devuelve todos los cantones
    Route::post('parroquias', [StatesController::class, 'loadParroquias']);               //Devuelve todas las parroquias con request
    Route::get('parroquias', [StatesController::class, 'loadParroquiasAll']);               //Devuelve todas las parroquias con request
    Route::post('recintos', [StatesController::class, 'loadRecintos']);                  //Devuelve todos los recintos con un request
    Route::get('recintos', [StatesController::class, 'loadRecintoAll']);                //Devuelve todos los recintos sin request
    Route::group(['middleware' => ['role:Administrador,api']], function () {
        Route::post('/show/supervisor', [SupervisorController::class, 'show']);
    });
    Route::group(['middleware' => ['role:Supervisor,api']], function () {
        Route::post('/show/coordinador', [CoordinadorController::class, 'show']);
    });
    Route::group(['middleware' => ['role:Administrador|Supervisor,api']], function () {
        //UsersController
        Route::post('/users',    [UsersController::class, 'index']);                         //Cargar todos los usuarios con parametro
        Route::get('/users-all', [UsersController::class, 'loadAllUsers']);                //Cargar todos los usuarios sin parametros
        Route::post('/store/user', [UsersController::class, 'store']);                    //Para guardar al usuario
        Route::post('/update/user/{user}', [UsersController::class, 'update']);          //Para editar al usuario
        Route::post('/delete/user', [UsersController::class, 'destroy']);               //Para eliminar al usuario
    });
    Route::group(['middleware' => ['role:Administrador|Supervisor|Coordinador,api']], function () {
        Route::post('/show/user', [UsersController::class, 'show']); 
    });
    //RolesController
    Route::get('roles', [RolesController::class, 'getRoles']);
    Route::get('permissions', [PermissionsController::class, 'getPermissions']);

    Route::group(['middleware' => ['role:Coordinador,api']], function () {
        //VeedoresController
        Route::get('/veedors-all', [VeedoresController::class, 'index']);
        Route::post('/store/veedor', [VeedoresController::class, 'store']);
        Route::post('/update/veedor/{veedor}', [VeedoresController::class, 'update'])->name('veedores');
        Route::post('/show/veedor', [VeedoresController::class, 'show']);
        Route::post('/delete/veedor', [VeedoresController::class, 'destroy']);             //Para eliminar al veedor
    });
});