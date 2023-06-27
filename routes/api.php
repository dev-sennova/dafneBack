<?php

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@register');

    // Las siguientes rutas además del prefijo requieren que el usuario tenga un token válido

    Route::group(['middleware' => 'auth:api'], function() {
     Route::get('logout', 'AuthController@logout');
     Route::get('user', 'AuthController@user');

     Route::get("usuario", "Tb_usuarioController@index");
     Route::post("usuario/store", "Tb_usuarioController@store");
     Route::put("usuario/update", "Tb_usuarioController@update");
     Route::put("usuario/deactivate", "Tb_usuarioController@deactivate");
     Route::put("usuario/activate", "Tb_usuarioController@activate");
     Route::get("usuario/selectusuario/{id}", "Tb_usuarioController@indexOne");
     Route::get("usuario/selectemail/{id}", "Tb_usuarioController@indexUser");

     Route::get("rol", "Tb_rolController@index");
     Route::post("rol/store", "Tb_rolController@store");
     Route::put("rol/update", "Tb_rolController@update");
     Route::put("rol/deactivate", "Tb_rolController@deactivate");
     Route::put("rol/activate", "Tb_rolController@activate");
     Route::get("rol/selectrol/{id}", "Tb_rolController@indexOne");

     Route::get("ciudad", "Tb_ciudadController@index");
     Route::post("ciudad/store", "Tb_ciudadController@store");
     Route::put("ciudad/update", "Tb_ciudadController@update");
     Route::put("ciudad/deactivate", "Tb_ciudadController@deactivate");
     Route::put("ciudad/activate", "Tb_ciudadController@activate");
     Route::get("ciudad/selectciudad/{id}", "Tb_ciudadController@indexOne");

     Route::get("suenos", "Tb_suenosController@index");
     Route::post("suenos/store", "Tb_suenosController@store");
     Route::put("suenos/update", "Tb_suenosController@update");
     Route::put("suenos/deactivate", "Tb_suenosController@deactivate");
     Route::put("suenos/activate", "Tb_suenosController@activate");
     Route::get("suenos/selectsuenos/{id}", "Tb_suenosController@indexOne");

     Route::get("ideas", "Tb_ideasController@index");
     Route::post("ideas/store", "Tb_ideasController@store");
     Route::put("ideas/update", "Tb_ideasController@update");
     Route::put("ideas/deactivate", "Tb_ideasController@deactivate");
     Route::put("ideas/activate", "Tb_ideasController@activate");
     Route::get("ideas/selectideas/{id}", "Tb_ideasController@indexOne");

     Route::get("hobbies", "Tb_hobbiesController@index");
     Route::post("hobbies/store", "Tb_hobbiesController@store");
     Route::put("hobbies/update", "Tb_hobbiesController@update");
     Route::put("hobbies/deactivate", "Tb_hobbiesController@deactivate");
     Route::put("hobbies/activate", "Tb_hobbiesController@activate");
     Route::get("hobbies/selecthobbies/{id}", "Tb_hobbiesController@indexOne");
     Route::get("hobbies/selecthobbiesgeneral", "Tb_hobbiesController@indexGeneral");
     Route::get("hobbies/selecthobbiespropio/{id}", "Tb_hobbiesController@indexPropio");

     Route::get("criterios_evaluacion", "Tb_criterios_evaluacionController@index");
     Route::post("criterios_evaluacion/store", "Tb_criterios_evaluacionController@store");
     Route::put("criterios_evaluacion/update", "Tb_criterios_evaluacionController@update");
     Route::put("criterios_evaluacion/deactivate", "Tb_criterios_evaluacionController@deactivate");
     Route::put("criterios_evaluacion/activate", "Tb_criterios_evaluacionController@activate");
     Route::get("criterios_evaluacion/selectcriterios_evaluacion/{id}", "Tb_criterios_evaluacionController@indexOne");

     Route::get("usuario_hobbies", "Tb_usuario_hobbiesController@index");
     Route::post("usuario_hobbies/store", "Tb_usuario_hobbiesController@store");
     Route::put("usuario_hobbies/update", "Tb_usuario_hobbiesController@update");
     Route::get("usuario_hobbies/selectusuario_hobbies/{id}", "Tb_usuario_hobbiesController@indexOne");
     Route::post("usuario_hobbies/closedeal", "Tb_usuario_hobbiesController@closeDeal");

     Route::get("usuario_ideas", "Tb_usuario_ideasController@index");
     Route::post("usuario_ideas/store", "Tb_usuario_ideasController@store");
     Route::put("usuario_ideas/update", "Tb_usuario_ideasController@update");
     Route::get("usuario_ideas/selectusuario_ideas/{id}", "Tb_usuario_ideasController@indexOne");
     Route::post("usuario_ideas/closedeal", "Tb_usuario_ideasController@closeDeal");

     Route::get("usuario_rol", "Tb_usuario_rolController@index");
     Route::post("usuario_rol/store", "Tb_usuario_rolController@store");
     Route::put("usuario_rol/update", "Tb_usuario_rolController@update");
     Route::get("usuario_rol/selectusuario_rol/{id}", "Tb_usuario_rolController@indexOne");

     Route::get("usuario_suenos", "Tb_usuario_suenosController@index");
     Route::post("usuario_suenos/store", "Tb_usuario_suenosController@store");
     Route::put("usuario_suenos/update", "Tb_usuario_suenosController@update");
     Route::get("usuario_suenos/selectusuario_suenos/{id}", "Tb_usuario_suenosController@indexOne");

     Route::get("escolaridad", "Tb_escolaridadController@index");
     Route::post("escolaridad/store", "Tb_escolaridadController@store");
     Route::put("escolaridad/update", "Tb_escolaridadController@update");
     Route::get("escolaridad/selectescolaridad/{id}", "Tb_escolaridadController@indexOne");

     Route::get("ocupacion", "Tb_ocupacionController@index");
     Route::post("ocupacion/store", "Tb_ocupacionController@store");
     Route::put("ocupacion/update", "Tb_ocupacionController@update");
     Route::get("ocupacion/selectocupacion/{id}", "Tb_ocupacionController@indexOne");

     Route::get("experiencia", "Tb_experienciaController@index");
     Route::post("experiencia/store", "Tb_experienciaController@store");
     Route::put("experiencia/update", "Tb_experienciaController@update");
     Route::get("experiencia/selectexperiencia/{id}", "Tb_experienciaController@indexOne");
    });

});
