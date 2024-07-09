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
    Route::post('/verify-email','AuthController@verifyEmail')->name('verify_email'); 
    Route::post('/resend-email','AuthController@resendEmail')->name('resend_email');
    Route::post('register', 'AuthController@register');

    // Las siguientes rutas además del prefijo requieren que el usuario tenga un token válido

    Route::group(['middleware' => 'auth:api'], function() {
     Route::get('logout', 'AuthController@logout');
     Route::get('user', 'AuthController@user');
     Route::post('verifypassword','AuthController@verifyPassword');
     Route::post('changepassword','AuthController@changePassword');

     Route::get('/usuario-hobbies','OrientadorController@getHobbiesDeUsuariosGestionados');
     Route::post('/actualizar-hobby/{idHobby}','OrientadorController@actualizarEstadoHobby');
     Route::post('/eliminar-hobby/{idHobby}','OrientadorController@eliminarHobby');
     Route::get('/usuario-suenos','OrientadorController@getSuenosDeUsuariosGestionados');
     Route::post('/actualizar-sueno/{idSueno}','OrientadorController@actualizarEstadoSueno');
     Route::post('/eliminar-sueno/{idSueno}','OrientadorController@eliminarSueno');
     Route::get('/usuario-ideas','OrientadorController@getIdeasDeUsuariosGestionados');
     Route::post('/actualizar-idea/{idIdea}','OrientadorController@actualizarEstadoIdea');
     Route::post('/eliminar-idea/{idIdea}','OrientadorController@eliminarIdea');
     Route::get('/usuario-criterios','OrientadorController@getCriteriosDeUsuariosGestionados');
     Route::post('/actualizar-criterio/{idCriterio}','OrientadorController@actualizarEstadoCriterio');
     Route::post('/eliminar-criterio/{idCriterio}','OrientadorController@eliminarCriterio');
     Route::get('/obtener-gestor','OrientadorController@getGestorByUserId');

     Route::get("usuario", "Tb_usuarioController@index");
     Route::post("usuario/store", "Tb_usuarioController@store");
     Route::put("usuario/update", "Tb_usuarioController@update");
     Route::put("usuario/deactivate", "Tb_usuarioController@deactivate");
     Route::put("usuario/activate", "Tb_usuarioController@activate");
     Route::get("usuario/selectusuario/{id}", "Tb_usuarioController@indexOne");
     Route::get("usuario/selectemail/{id}", "Tb_usuarioController@indexUser");
     Route::get("usuario/selectemaillogin/{id}", "Tb_usuarioController@indexIdUser");
     Route::get("usuarioGestor", "Tb_usuarioController@indexGestor");
     Route::get("usuarioPendientes/{idUsuario}", "Tb_usuarioController@indexPendientes");
     Route::get("countUsuario/{idUsuario}", "Tb_usuarioController@countUsuario");
     Route::get("orientadores","Tb_usuarioController@indexOrientadores");
     Route::put("/usuario/{id}/cambiar-gestor","Tb_usuarioController@cambiarGestor");
     Route::get("/usuarios-gestor","Tb_usuarioController@indexUsuarioGestor");

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
     Route::get('ciudad/filterByDepartamento/{departamento_id}', "Tb_ciudadController@filterByDepartamento");


     Route::get('departamento', 'Tb_departamentoController@index');
     Route::post('departamento/store', 'Tb_departamentoController@store');
     Route::put('departamento/update', 'Tb_departamentoController@update');
     Route::put('departamento/deactivate', 'Tb_departamentoController@deactivate');
     Route::put('departamento/activate', 'Tb_departamentoController@activate');
     Route::get('departamento/selectdepartamento/{id}', 'Tb_departamentoController@indexOne');

     Route::get("bitacora", "Tb_bitacoraController@index");
     Route::post("bitacora/store", "Tb_bitacoraController@store");
     Route::put("bitacora/update", "Tb_bitacoraController@update");
     Route::put("bitacora/deactivate", "Tb_bitacoraController@deactivate");
     Route::put("bitacora/activate", "Tb_bitacoraController@activate");
     Route::get("bitacora/selectbitacora/{id}", "Tb_bitacoraController@indexOne");
     Route::get("bitacora/validaravance", "Tb_bitacoraController@validarAvance");
     Route::put("bitacora/updatereg", "Tb_bitacoraController@updateReg");

     Route::get("suenos", "Tb_suenosController@index");
     Route::post("suenos/store", "Tb_suenosController@store");
     Route::put("suenos/update", "Tb_suenosController@update");
     Route::put("suenos/deactivate", "Tb_suenosController@deactivate");
     Route::put("suenos/activate", "Tb_suenosController@activate");
     Route::get("suenos/selectsuenos/{id}", "Tb_suenosController@indexOne");
     Route::get("suenos/selectsuenosgeneral", "Tb_suenosController@indexGeneral");
     Route::get("suenos/selectsuenospropio/{id}", "Tb_suenosController@indexPropio");

     Route::get("ideas", "Tb_ideasController@index");
     Route::post("ideas/store", "Tb_ideasController@store");
     Route::put("ideas/update", "Tb_ideasController@update");
     Route::put("ideas/deactivate", "Tb_ideasController@deactivate");
     Route::put("ideas/activate", "Tb_ideasController@activate");
     Route::get("ideas/selectideas/{id}", "Tb_ideasController@indexOne");
     Route::get("ideas/selectideasgeneral", "Tb_ideasController@indexGeneral");
     Route::get("ideas/selectideaspropio/{id}", "Tb_ideasController@indexPropio");

     Route::get("hobbies", "Tb_hobbiesController@index");
     Route::post("hobbies/store", "Tb_hobbiesController@store");
     Route::put("hobbies/update", "Tb_hobbiesController@update");
     Route::put("hobbies/deactivate", "Tb_hobbiesController@deactivate");
     Route::put("hobbies/activate", "Tb_hobbiesController@activate");
     Route::get("hobbies/selecthobbies/{id}", "Tb_hobbiesController@indexOne");
     Route::get("hobbies/selecthobbiesgeneral", "Tb_hobbiesController@indexGeneral");
     Route::get("hobbies/selecthobbiespropio/{id}", "Tb_hobbiesController@indexPropio");

     Route::get("criterios", "Tb_criteriosController@index");
     Route::post("criterios/store", "Tb_criteriosController@store");
     Route::put("criterios/update", "Tb_criteriosController@update");
     Route::put("criterios/deactivate", "Tb_criteriosController@deactivate");
     Route::put("criterios/activate", "Tb_criteriosController@activate");
     Route::get("criterios/selectcriterios/{id}", "Tb_criteriosController@indexOne");
     Route::get("criterios/selectcriteriosgeneral", "Tb_criteriosController@indexGeneral");
     Route::get("criterios/selectcriteriospropio/{id}", "Tb_criteriosController@indexPropio");

     Route::get("criterios_evaluacion", "Tb_criterios_evaluacionController@index");
     Route::post("criterios_evaluacion/store", "Tb_criterios_evaluacionController@store");
     Route::put("criterios_evaluacion/update", "Tb_criterios_evaluacionController@update");
     Route::put("criterios_evaluacion/deactivate", "Tb_criterios_evaluacionController@deactivate");
     Route::put("criterios_evaluacion/activate", "Tb_criterios_evaluacionController@activate");
     Route::get("criterios_evaluacion/selectcriterios_evaluacion/{id}", "Tb_criterios_evaluacionController@indexOne");
     Route::get("criterios_evaluacion/calcularmatriz/{id}", "Tb_criterios_evaluacionController@calcularMatriz");

     Route::get("matriz_evaluacion", "Tb_matriz_evaluacionController@index");
     Route::post("matriz_evaluacion/store", "Tb_matriz_evaluacionController@store");
     Route::put("matriz_evaluacion/update", "Tb_matriz_evaluacionController@update");
     Route::put("matriz_evaluacion/deactivate", "Tb_matriz_evaluacionController@deactivate");
     Route::put("matriz_evaluacion/activate", "Tb_matriz_evaluacionController@activate");
     Route::get("matriz_evaluacion/selectmatriz_evaluacion/{id}", "Tb_matriz_evaluacionController@indexOne");
     Route::get("matriz_evaluacion/selectmatriz_usuario/{id}", "Tb_matriz_evaluacionController@indexByUser");

     Route::get("resumen_empresa", "Tb_resumen_empresaController@index");
     Route::post("resumen_empresa/store", "Tb_resumen_empresaController@store");
     Route::put("resumen_empresa/update", "Tb_resumen_empresaController@update");
     Route::put("resumen_empresa/deactivate", "Tb_resumen_empresaController@deactivate");
     Route::put("resumen_empresa/activate", "Tb_resumen_empresaController@activate");
     Route::get("resumen_empresa/selectresumen_empresa/{id}", "Tb_resumen_empresaController@indexOne");
     Route::get("resumen_empresa/selectresumen_empresa_usuario/{id}", "Tb_resumen_empresaController@indexByUser");

     Route::get("usuario_hobbies", "Tb_usuario_hobbiesController@index");
     Route::post("usuario_hobbies/store", "Tb_usuario_hobbiesController@store");
     Route::put("usuario_hobbies/update", "Tb_usuario_hobbiesController@update");
     Route::get("usuario_hobbies/selectusuario_hobbies/{id}", "Tb_usuario_hobbiesController@indexOne");
     Route::post("usuario_hobbies/closedeal", "Tb_usuario_hobbiesController@closeDeal");
     Route::get("usuario_hobbies/counthobbies/{id}", "Tb_usuario_hobbiesController@countHobbies");
     Route::get("usuario_hobbies/usuariohobbies/{id}", "Tb_usuario_hobbiesController@usuarioHobbies");
     Route::post("usuario_hobbies/updateusuariohobbies", "Tb_usuario_hobbiesController@updateUsuarioHobbies");

     Route::get("usuario_ideas", "Tb_usuario_ideasController@index");
     Route::post("usuario_ideas/store", "Tb_usuario_ideasController@store");
     Route::put("usuario_ideas/update", "Tb_usuario_ideasController@update");
     Route::get("usuario_ideas/selectusuario_ideas/{id}", "Tb_usuario_ideasController@indexOne");
     Route::post("usuario_ideas/closedeal", "Tb_usuario_ideasController@closeDeal");
     Route::get("usuario_ideas/countideas/{id}", "Tb_usuario_ideasController@countIdeas");
     Route::get("usuario_ideas/usuarioideas/{id}", "Tb_usuario_ideasController@usuarioIdeas");
     Route::post("usuario_ideas/updateusuarioideas", "Tb_usuario_ideasController@updateUsuarioIdeas");

     Route::get("usuario_suenos", "Tb_usuario_suenosController@index");
     Route::post("usuario_suenos/store", "Tb_usuario_suenosController@store");
     Route::put("usuario_suenos/update", "Tb_usuario_suenosController@update");
     Route::get("usuario_suenos/selectusuario_suenos/{id}", "Tb_usuario_suenosController@indexOne");
     Route::post("usuario_suenos/closedeal", "Tb_usuario_suenosController@closeDeal");
     Route::get("usuario_suenos/countsuenos/{id}", "Tb_usuario_suenosController@countSuenos");
     Route::get("usuario_suenos/usuariosuenos/{id}", "Tb_usuario_suenosController@usuarioSuenos");
     Route::post("usuario_suenos/updateusuariosuenos", "Tb_usuario_suenosController@updateUsuarioSuenos");

     Route::get("usuario_criterios", "Tb_usuario_criteriosController@index");
     Route::post("usuario_criterios/store", "Tb_usuario_criteriosController@store");
     Route::put("usuario_criterios/update", "Tb_usuario_criteriosController@update");
     Route::get("usuario_criterios/selectusuario_criterios/{id}", "Tb_usuario_criteriosController@indexOne");
     Route::post("usuario_criterios/closedeal", "Tb_usuario_criteriosController@closeDeal");
     Route::get("usuario_criterios/countcriterios/{id}", "Tb_usuario_criteriosController@countCriterios");
     Route::get("usuario_criterios/usuariocriterios/{id}", "Tb_usuario_criteriosController@usuarioCriterios");
     Route::post("usuario_criterios/updateusuariocriterios", "Tb_usuario_criteriosController@updateUsuarioCriterios");

     Route::get("usuario_rol", "Tb_usuario_rolController@index");
     Route::post("usuario_rol/store", "Tb_usuario_rolController@store");
     Route::put("usuario_rol/update", "Tb_usuario_rolController@update");
     Route::get("usuario_rol/selectusuario_rol/{id}", "Tb_usuario_rolController@indexOne");

     Route::get("escolaridad", "Tb_escolaridadController@index");
     Route::post("escolaridad/store", "Tb_escolaridadController@store");
     Route::put("escolaridad/update", "Tb_escolaridadController@update");
     Route::get("escolaridad/selectescolaridad/{id}", "Tb_escolaridadController@indexOne");
     Route::get("escolaridad/selectresumen_escolaridad_usuario/{id}", "Tb_escolaridadController@indexByUser");

     Route::get("ocupacion", "Tb_ocupacionController@index");
     Route::post("ocupacion/store", "Tb_ocupacionController@store");
     Route::put("ocupacion/update", "Tb_ocupacionController@update");
     Route::get("ocupacion/selectocupacion/{id}", "Tb_ocupacionController@indexOne");
     Route::get("ocupacion/selectresumen_ocupacion_usuario/{id}", "Tb_ocupacionController@indexByUser");

     Route::get("experiencia", "Tb_experienciaController@index");
     Route::post("experiencia/store", "Tb_experienciaController@store");
     Route::put("experiencia/update", "Tb_experienciaController@update");
     Route::get("experiencia/selectexperiencia/{id}", "Tb_experienciaController@indexOne");
     Route::get("experiencia/selectresumen_experiencia_usuario/{id}", "Tb_experienciaController@indexByUser");

     Route::post('/upload-image', 'ImageController@uploadImage');

     Route::get("preguntas_legal/next", "Tb_preguntas_legalController@validateFlow");
     Route::get("preguntas_legal/pre", "Tb_preguntas_legalController@preFlow");
     Route::get("preguntas_legal/nextflow", "Tb_preguntas_legalController@nextFlow");
     Route::get("preguntas_legal/validatepersona", "Tb_preguntas_legalController@validatePersona");

     Route::get("preguntas_tributario/next", "Tb_preguntas_tributarioController@validateFlow");
     Route::get("preguntas_tributario/pre", "Tb_preguntas_tributarioController@preFlow");
     Route::get("preguntas_tributario/nextflow", "Tb_preguntas_tributarioController@nextFlow");

     Route::get("preguntas_tributario_persona/next", "Tb_preguntas_tributario_personaController@validateFlow");
     Route::get("preguntas_tributario_persona/pre", "Tb_preguntas_tributario_personaController@preFlow");
     Route::get("preguntas_tributario_persona/nextflow", "Tb_preguntas_tributario_personaController@nextFlow");

     Route::get("matriz_dofa", "Tb_matriz_dofaController@index");
     Route::post("matriz_dofa/store", "Tb_matriz_dofaController@store");
     Route::put("matriz_dofa/update", "Tb_matriz_dofaController@update");
     Route::put("matriz_dofa/deactivate", "Tb_matriz_dofaController@deactivate");
     Route::put("matriz_dofa/activate", "Tb_matriz_dofaController@activate");
     Route::get("matriz_dofa/selectmatriz_dofa/{id}", "Tb_matriz_dofaController@indexOne");

     Route::get("modelo_canvas", "Tb_modelo_canvasController@index");
     Route::post("modelo_canvas/store", "Tb_modelo_canvasController@store");
     Route::put("modelo_canvas/update", "Tb_modelo_canvasController@update");
     Route::put("modelo_canvas/deactivate", "Tb_modelo_canvasController@deactivate");
     Route::put("modelo_canvas/activate", "Tb_modelo_canvasController@activate");
     Route::get("modelo_canvas/selectmodelo_canvas/{id}", "Tb_modelo_canvasController@indexOne");
     Route::get("modelo_canvas/selectmodelo_canvaspropio/{id}", "Tb_modelo_canvasController@indexPropio");

     Route::get("estrategias", "Tb_estrategiasController@index");
     Route::post("estrategias/store", "Tb_estrategiasController@store");
     Route::put("estrategias/update", "Tb_estrategiasController@update");
     Route::put("estrategias/deactivate", "Tb_estrategiasController@deactivate");
     Route::put("estrategias/activate", "Tb_estrategiasController@activate");
     Route::get("estrategias/selectestrategias/{id}", "Tb_estrategiasController@indexOne");

     Route::get("avances_legal", "Tb_avances_legalController@index");
     Route::post("avances_legal/store", "Tb_avances_legalController@store");
     Route::put("avances_legal/update", "Tb_avances_legalController@update");
     Route::put("avances_legal/deactivate", "Tb_avances_legalController@deactivate");
     Route::put("avances_legal/activate", "Tb_avances_legalController@activate");
     Route::get("avances_legal/selectavances_legal/{id}", "Tb_avances_legalController@indexOne");
     Route::get("avances_legal/selectavances_legalpropio/{id}", "Tb_avances_legalController@indexPropio");
     Route::get("avances_legal/selectavances_legalresumen/{id}", "Tb_avances_legalController@indexResumen");
     Route::get("avances_legal/resetlegal/{idUsuario}", "Tb_avances_legalController@resetLegal");
     Route::get("avances_legal/validarPersona/{idUsuario}", "Tb_avances_legalController@validarPersona");
     Route::get("avances_legal/validarRegistroEmpresa/{idUsuario}", "Tb_avances_legalController@validarRegistroEmpresa");

     Route::get("avances_tributario", "Tb_avances_tributarioController@index");
     Route::post("avances_tributario/store", "Tb_avances_tributarioController@store");
     Route::put("avances_tributario/update", "Tb_avances_tributarioController@update");
     Route::put("avances_tributario/deactivate", "Tb_avances_tributarioController@deactivate");
     Route::put("avances_tributario/activate", "Tb_avances_tributarioController@activate");
     Route::get("avances_tributario/selectavances_tributario/{id}", "Tb_avances_tributarioController@indexOne");
     Route::get("avances_tributario/selectavances_tributariopropio/{id}", "Tb_avances_tributarioController@indexPropio");
     Route::get("avances_tributario/selectavances_tributarioresumen/{id}", "Tb_avances_tributarioController@indexResumen");
     Route::get("avances_tributario/resettributarioempresa/{idUsuario}", "Tb_avances_tributarioController@resetTributarioEmpresa");

     Route::get("avances_tributario_persona", "Tb_avances_tributario_personaController@index");
     Route::post("avances_tributario_persona/store", "Tb_avances_tributario_personaController@store");
     Route::put("avances_tributario_persona/update", "Tb_avances_tributario_personaController@update");
     Route::put("avances_tributario_persona/deactivate", "Tb_avances_tributario_personaController@deactivate");
     Route::put("avances_tributario_persona/activate", "Tb_avances_tributario_personaController@activate");
     Route::get("avances_tributario_persona/selectavances_tributario_persona/{id}", "Tb_avances_tributario_personaController@indexOne");
     Route::get("avances_tributario_persona/selectavances_tributario_personapropio/{id}", "Tb_avances_tributario_personaController@indexPropio");
     Route::get("avances_tributario_persona/selectavances_tributario_personaresumen/{id}", "Tb_avances_tributario_personaController@indexResumen");
     Route::get("avances_tributario_persona/resettributariopersona/{idUsuario}", "Tb_avances_tributario_personaController@resetTributarioPersona");

     Route::get("variables_globales", "Tb_variables_globalesController@index");
     Route::post("variables_globales/store", "Tb_variables_globalesController@store");
     Route::put("variables_globales/update", "Tb_variables_globalesController@update");
     Route::put("variables_globales/deactivate", "Tb_variables_globalesController@deactivate");
     Route::put("variables_globales/activate", "Tb_variables_globalesController@activate");
     Route::get("variables_globales/selectvariables_globales/{id}", "Tb_variables_globalesController@indexOne");

     Route::get("codigo_ciiu", "Tb_codigo_ciiuController@index");
     Route::post("codigo_ciiu/store", "Tb_codigo_ciiuController@store");
     Route::put("codigo_ciiu/update", "Tb_codigo_ciiuController@update");
     Route::put("codigo_ciiu/deactivate", "Tb_codigo_ciiuController@deactivate");
     Route::put("codigo_ciiu/activate", "Tb_codigo_ciiuController@activate");
     Route::get("codigo_ciiu/selectcodigo_ciiu/{id}", "Tb_codigo_ciiuController@indexOne");

     Route::get("riesgo_arl", "Tb_riesgo_arlController@index");
     Route::post("riesgo_arl/store", "Tb_riesgo_arlController@store");
     Route::put("riesgo_arl/update", "Tb_riesgo_arlController@update");
     Route::put("riesgo_arl/deactivate", "Tb_riesgo_arlController@deactivate");
     Route::put("riesgo_arl/activate", "Tb_riesgo_arlController@activate");
     Route::get("riesgo_arl/selectriesgo_arl/{id}", "Tb_riesgo_arlController@indexOne");

     Route::get("cif", "Tb_cifController@index");
     Route::post("cif/store", "Tb_cifController@store");
     Route::put("cif/update", "Tb_cifController@update");
     Route::put("cif/deactivate", "Tb_cifController@deactivate");
     Route::put("cif/activate", "Tb_cifController@activate");
     Route::get("cif/selectcif/{id}", "Tb_cifController@indexOne");
     Route::get("cif/selectcif_propio/{id}", "Tb_cifController@indexPropio");

     Route::get("maquinaria", "Tb_maquinariaController@index");
     Route::post("maquinaria/store", "Tb_maquinariaController@store");
     Route::put("maquinaria/update", "Tb_maquinariaController@update");
     Route::put("maquinaria/deactivate", "Tb_maquinariaController@deactivate");
     Route::put("maquinaria/activate", "Tb_maquinariaController@activate");
     Route::get("maquinaria/selectmaquinaria/{id}", "Tb_maquinariaController@indexOne");
     Route::get("maquinaria/selectmaquinaria_propia/{id}", "Tb_maquinariaController@indexPropio");

     Route::get("consolidado_simulacion_financiera", "Tb_consolidado_simulacion_financieraController@index");
     Route::post("consolidado_simulacion_financiera/store", "Tb_consolidado_simulacion_financieraController@store");
     Route::put("consolidado_simulacion_financiera/update", "Tb_consolidado_simulacion_financieraController@update");
     Route::put("consolidado_simulacion_financiera/deactivate", "Tb_consolidado_simulacion_financieraController@deactivate");
     Route::put("consolidado_simulacion_financiera/activate", "Tb_consolidado_simulacion_financieraController@activate");
     Route::get("consolidado_simulacion_financiera/selectconsolidado_simulacion_financiera/{id}", "Tb_consolidado_simulacion_financieraController@indexOne");
     Route::get("consolidado_simulacion_financiera/select_propio/{id}", "Tb_consolidado_simulacion_financieraController@indexPropio");
     Route::get("consolidado_simulacion_financiera/resetfinanciera/{idUsuario}", "Tb_consolidado_simulacion_financieraController@resetFinanciera");

     Route::get("empleados_empresa", "Tb_empleados_empresaController@index");
     Route::post("empleados_empresa/store", "Tb_empleados_empresaController@store");
     Route::put("empleados_empresa/update", "Tb_empleados_empresaController@update");
     Route::put("empleados_empresa/deactivate", "Tb_empleados_empresaController@deactivate");
     Route::put("empleados_empresa/activate", "Tb_empleados_empresaController@activate");
     Route::get("empleados_empresa/selectempleados_empresa/{id}", "Tb_empleados_empresaController@indexOne");
     Route::get("empleados_empresa/selectempleados_propios/{id}", "Tb_empleados_empresaController@indexPropio");

     Route::get("perfiles_empresa", "Tb_perfiles_empresaController@index");
     Route::post("perfiles_empresa/store", "Tb_perfiles_empresaController@store");
     Route::put("perfiles_empresa/update", "Tb_perfiles_empresaController@update");
     Route::put("perfiles_empresa/deactivate", "Tb_perfiles_empresaController@deactivate");
     Route::put("perfiles_empresa/activate", "Tb_perfiles_empresaController@activate");
     Route::get("perfiles_empresa/selectperfiles_empresa/{id}", "Tb_perfiles_empresaController@indexOne");
     Route::get("perfiles_empresa/selectperfiles_propios/{id}", "Tb_perfiles_empresaController@indexPropio");

     Route::get("financiacion", "Tb_financiacionController@index");
     Route::post("financiacion/store", "Tb_financiacionController@store");
     Route::put("financiacion/update", "Tb_financiacionController@update");
     Route::put("financiacion/deactivate", "Tb_financiacionController@deactivate");
     Route::put("financiacion/activate", "Tb_financiacionController@activate");
     Route::get("financiacion/selectfinanciacion/{id}", "Tb_financiacionController@indexOne");
     Route::get("financiacion/selectfinanciacion_propio/{id}", "Tb_financiacionController@indexPropio");

     Route::get("gastos", "Tb_gastosController@index");
     Route::post("gastos/store", "Tb_gastosController@store");
     Route::put("gastos/update", "Tb_gastosController@update");
     Route::put("gastos/deactivate", "Tb_gastosController@deactivate");
     Route::put("gastos/activate", "Tb_gastosController@activate");
     Route::get("gastos/selectgastos/{id}", "Tb_gastosController@indexOne");
     Route::get("gastos/selectgastos_propio/{id}", "Tb_gastosController@indexPropio");

     Route::get("precio_venta", "Tb_precio_ventaController@index");
     Route::post("precio_venta/store", "Tb_precio_ventaController@store");
     Route::put("precio_venta/update", "Tb_precio_ventaController@update");
     Route::put("precio_venta/deactivate", "Tb_precio_ventaController@deactivate");
     Route::put("precio_venta/activate", "Tb_precio_ventaController@activate");
     Route::get("precio_venta/selectprecio_venta/{id}", "Tb_precio_ventaController@indexOne");
     Route::get("precio_venta/selectprecio_venta_propio/{id}", "Tb_precio_ventaController@indexPropio");

     Route::get("punto_equilibrio", "Tb_punto_equilibrioController@index");
     Route::post("punto_equilibrio/store", "Tb_punto_equilibrioController@store");
     Route::put("punto_equilibrio/update", "Tb_punto_equilibrioController@update");
     Route::put("punto_equilibrio/deactivate", "Tb_punto_equilibrioController@deactivate");
     Route::put("punto_equilibrio/activate", "Tb_punto_equilibrioController@activate");
     Route::get("punto_equilibrio/selectpunto_equilibrio/{id}", "Tb_punto_equilibrioController@indexOne");
     Route::get("punto_equilibrio/selectpunto_equilibrio_propio/{id}", "Tb_punto_equilibrioController@indexPropio");

     Route::get("proyeccion_mensual", "Tb_proyeccion_mensualController@index");
     Route::post("proyeccion_mensual/store", "Tb_proyeccion_mensualController@store");
     Route::put("proyeccion_mensual/update", "Tb_proyeccion_mensualController@update");
     Route::put("proyeccion_mensual/deactivate", "Tb_proyeccion_mensualController@deactivate");
     Route::put("proyeccion_mensual/activate", "Tb_proyeccion_mensualController@activate");
     Route::get("proyeccion_mensual/selectproyeccion_mensual/{id}", "Tb_proyeccion_mensualController@indexOne");
     Route::get("proyeccion_mensual/selectproyeccion_mensual_propio/{id}", "Tb_proyeccion_mensualController@indexPropio");

     Route::get("ingresos_adicionales", "Tb_ingresos_adicionalesController@index");
     Route::post("ingresos_adicionales/store", "Tb_ingresos_adicionalesController@store");
     Route::put("ingresos_adicionales/update", "Tb_ingresos_adicionalesController@update");
     Route::put("ingresos_adicionales/deactivate", "Tb_ingresos_adicionalesController@deactivate");
     Route::put("ingresos_adicionales/activate", "Tb_ingresos_adicionalesController@activate");
     Route::get("ingresos_adicionales/selectingresos_adicionales/{id}", "Tb_ingresos_adicionalesController@indexOne");
     Route::get("ingresos_adicionales/selectingresos_adicionales_propio/{id}", "Tb_ingresos_adicionalesController@indexPropio");

     Route::get("gastos_adicionales", "Tb_gastos_adicionalesController@index");
     Route::post("gastos_adicionales/store", "Tb_gastos_adicionalesController@store");
     Route::put("gastos_adicionales/update", "Tb_gastos_adicionalesController@update");
     Route::put("gastos_adicionales/deactivate", "Tb_gastos_adicionalesController@deactivate");
     Route::put("gastos_adicionales/activate", "Tb_gastos_adicionalesController@activate");
     Route::get("gastos_adicionales/selectgastos_adicionales/{id}", "Tb_gastos_adicionalesController@indexOne");
     Route::get("gastos_adicionales/selectgastos_adicionales_propio/{id}", "Tb_gastos_adicionalesController@indexPropio");

     Route::get("nomina_empleados_simula", "Tb_nomina_empleados_simulaController@index");
     Route::post("nomina_empleados_simula/store", "Tb_nomina_empleados_simulaController@store");
     Route::put("nomina_empleados_simula/update", "Tb_nomina_empleados_simulaController@update");
     Route::put("nomina_empleados_simula/deactivate", "Tb_nomina_empleados_simulaController@deactivate");
     Route::put("nomina_empleados_simula/activate", "Tb_nomina_empleados_simulaController@activate");
     Route::get("nomina_empleados_simula/selectnomina_empleados_simula/{id}", "Tb_nomina_empleados_simulaController@indexOne");
     Route::get("nomina_empleados_simula/selectnomina_empleados_simula_propio/{id}", "Tb_nomina_empleados_simulaController@indexPropio");

     Route::get("hoja_costos_simula", "Tb_hoja_costos_simulaController@index");
     Route::post("hoja_costos_simula/store", "Tb_hoja_costos_simulaController@store");
     Route::put("hoja_costos_simula/update", "Tb_hoja_costos_simulaController@update");
     Route::put("hoja_costos_simula/deactivate", "Tb_hoja_costos_simulaController@deactivate");
     Route::put("hoja_costos_simula/activate", "Tb_hoja_costos_simulaController@activate");
     Route::get("hoja_costos_simula/selecthoja_costos_simula/{id}", "Tb_hoja_costos_simulaController@indexOne");
     Route::get("hoja_costos_simula/selecthoja_costos_simula_propio/{id}", "Tb_hoja_costos_simulaController@indexPropio");
     Route::get("hoja_costos_simula/consolidado/{id}", "Tb_hoja_costos_simulaController@consolidado");
     Route::get("hoja_costos_simula/consolidadoUnidad/{id}", "Tb_hoja_costos_simulaController@consolidadoUnidad");

     Route::get("hoja_gastos_simula", "Tb_hoja_gastos_simulaController@index");
     Route::post("hoja_gastos_simula/store", "Tb_hoja_gastos_simulaController@store");
     Route::put("hoja_gastos_simula/update", "Tb_hoja_gastos_simulaController@update");
     Route::put("hoja_gastos_simula/deactivate", "Tb_hoja_gastos_simulaController@deactivate");
     Route::put("hoja_gastos_simula/activate", "Tb_hoja_gastos_simulaController@activate");
     Route::get("hoja_gastos_simula/selecthoja_gastos_simula/{id}", "Tb_hoja_gastos_simulaController@indexOne");
     Route::get("hoja_gastos_simula/selecthoja_gastos_simula_propio/{id}", "Tb_hoja_gastos_simulaController@indexPropio");
     Route::get("hoja_gastos_simula/consolidado/{id}", "Tb_hoja_gastos_simulaController@consolidado");

     Route::get("estado_resultados_simula", "Tb_estado_resultados_simulaController@index");
     Route::post("estado_resultados_simula/store", "Tb_estado_resultados_simulaController@store");
     Route::put("estado_resultados_simula/update", "Tb_estado_resultados_simulaController@update");
     Route::put("estado_resultados_simula/deactivate", "Tb_estado_resultados_simulaController@deactivate");
     Route::put("estado_resultados_simula/activate", "Tb_estado_resultados_simulaController@activate");
     Route::get("estado_resultados_simula/selectestado_resultados_simula/{id}", "Tb_estado_resultados_simulaController@indexOne");
     Route::get("estado_resultados_simula/selectestado_resultados_simula_propio/{id}", "Tb_estado_resultados_simulaController@indexPropio");

     Route::get("impuesto", "Tb_impuestoController@index");
     Route::post("impuesto/store", "Tb_impuestoController@store");
     Route::put("impuesto/update", "Tb_impuestoController@update");
     Route::put("impuesto/deactivate", "Tb_impuestoController@deactivate");
     Route::put("impuesto/activate", "Tb_impuestoController@activate");
     Route::get("impuesto/selectimpuesto/{id}", "Tb_impuestoController@indexOne");

     Route::get("formalizacion_persona", "Tb_formalizacion_personaController@index");
     Route::post("formalizacion_persona/store", "Tb_formalizacion_personaController@store");
     Route::put("formalizacion_persona/update", "Tb_formalizacion_personaController@update");
     Route::put("formalizacion_persona/deactivate", "Tb_formalizacion_personaController@deactivate");
     Route::put("formalizacion_persona/activate", "Tb_formalizacion_personaController@activate");
     Route::get("formalizacion_persona/selectformalizacion_persona/{id}", "Tb_formalizacion_personaController@indexOne");
     Route::get("formalizacion_persona/selectformalizacion_persona_propio/{id}", "Tb_formalizacion_personaController@indexPropio");

     Route::get("formalizacion_empresa", "Tb_formalizacion_empresaController@index");
     Route::post("formalizacion_empresa/store", "Tb_formalizacion_empresaController@store");
     Route::put("formalizacion_empresa/update", "Tb_formalizacion_empresaController@update");
     Route::put("formalizacion_empresa/deactivate", "Tb_formalizacion_empresaController@deactivate");
     Route::put("formalizacion_empresa/activate", "Tb_formalizacion_empresaController@activate");
     Route::get("formalizacion_empresa/selectformalizacion_empresa/{id}", "Tb_formalizacion_empresaController@indexOne");
     Route::get("formalizacion_empresa/selectformalizacion_empresa_propio/{id}", "Tb_formalizacion_empresaController@indexPropio");

     Route::get("directorio", "Tb_directorioController@index");
     Route::post("directorio/store", "Tb_directorioController@store");
     Route::put("directorio/update", "Tb_directorioController@update");
     Route::put("directorio/deactivate", "Tb_directorioController@deactivate");
     Route::put("directorio/activate", "Tb_directorioController@activate");
     Route::get("directorio/selectdirectorio/{id}", "Tb_directorioController@indexOne");


    });

});
