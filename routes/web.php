<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get("/usuario", "Tb_usuarioController@index");
Route::get("/usuario/store", "Tb_usuarioController@store");
Route::put("/usuario/update", "Tb_usuarioController@update");
Route::put("/usuario/deactivate", "Tb_usuarioController@deactivate");
Route::put("/usuario/activate", "Tb_usuarioController@activate");
Route::get("/usuario/selectusuario", "Tb_usuarioController@indexOne");
