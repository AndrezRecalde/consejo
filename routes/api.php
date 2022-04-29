<?php

use App\Http\Controllers\StatesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VeedoresController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//StatesController
Route::get('cantones', [StatesController::class, 'loadCantones']);                      //Devuelve todos los cantones
Route::post('parroquias', [StatesController::class, 'loadParroquias']);               //Devuelve todas las parroquias con request
Route::post('recintos', [StatesController::class, 'loadRecintos']);                  //Devuelve todos los recintos con un request
Route::get('recintos', [StatesController::class, 'loadRecintoAll']);                //Devuelve todos los recintos sin request


//UsersController
Route::post('/users',    [UsersController::class, 'index']);                         //Cargar todos los usuarios con parametro
Route::get('/users-all', [UsersController::class , 'loadAllUsers']);                //Cargar todos los usuarios sin parametros
Route::post('/show/user', [UsersController::class, 'show']);                       //Para ver al usuario
Route::post('/store/user', [UsersController::class, 'store']);                    //Para guardar al usuario
Route::post('/update/user/{user}', [UsersController::class, 'update']);          //Para editar al usuario
Route::post('/delete/user', [UsersController::class, 'destroy']);               //Para eliminar al usuario


//VeedoresController
Route::get('/veedores', [VeedoresController::class, 'index']);
Route::post('/store/veedor', [VeedoresController::class, 'store']);
Route::post('/update/veedor/{veedor}', [VeedoresController::class, 'update']);
Route::post('/show/veedor', [VeedoresController::class, 'show']);
Route::post('/delete/veedor', [VeedoresController::class, 'destroy']);             //Para eliminar al veedor






