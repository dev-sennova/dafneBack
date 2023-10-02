<?php

namespace App\Http\Controllers;

use App\Models\Tb_preguntas_caracterizacion;
use App\Models\Tb_avances_simulacion;
use App\models\Tb_enunciados;
use Illuminate\Http\Request;

class Tb_preguntas_caracterizacionController extends Controller
{
    public function index(Request $request)
    {
        $preguntas_caracterizacion = Tb_preguntas_caracterizacion::orderBy('preguntas_caracterizacion.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'preguntas_caracterizacion' => $preguntas_caracterizacion
        ];
    }

    public function indexOne(Request $request)
    {
        $preguntas_caracterizacion = Tb_preguntas_caracterizacion::orderBy('preguntas_caracterizacion.id','desc')
        ->where('tb_preguntas_caracterizacion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'preguntas_caracterizacion' => $preguntas_caracterizacion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_preguntas_caracterizacion=new Tb_preguntas_caracterizacion();
            $tb_preguntas_caracterizacion->pregunta=$request->pregunta;
            $tb_preguntas_caracterizacion->estado=1;

            if ($tb_preguntas_caracterizacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_caracterizacion creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_caracterizacion no pudo ser creada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_preguntas_caracterizacion=Tb_preguntas_caracterizacion::findOrFail($request->id);
            $tb_preguntas_caracterizacion->pregunta=$request->pregunta;
            $tb_preguntas_caracterizacion->estado='1';

            if ($tb_preguntas_caracterizacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_caracterizacion actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_caracterizacion no pudo ser actualizada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function deactivate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_preguntas_caracterizacion=Tb_preguntas_caracterizacion::findOrFail($request->id);
            $tb_preguntas_caracterizacion->estado='0';

            if ($tb_preguntas_caracterizacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_caracterizacion desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_caracterizacion no pudo ser desactivada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function activate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_preguntas_caracterizacion=Tb_preguntas_caracterizacion::findOrFail($request->id);
            $tb_preguntas_caracterizacion->estado='1';

            if ($tb_preguntas_caracterizacion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_caracterizacion activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_caracterizacion no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function validateFlow(Request $request){
        $idUsuario=$request->idUsuario;
        $idPregunta=$request->idP;

        $cant_preguntas_simulacion = Tb_avances_simulacion::where('tb_avances_simulacion.idUsuario','=',$idUsuario)->count();

        if($cant_preguntas_simulacion>0){
            $max_preguntas_simulacion = Tb_avances_simulacion::where('tb_avances_simulacion.idUsuario','=',$idUsuario)
            ->select('tb_avances_simulacion.idExterno')
            ->orderBy('preguntas_caracterizacion.id','desc')
            ->first();
        }else{
            $max_preguntas_simulacion = 1;
        }

        $pregunta_simulacion=Tb_preguntas_caracterizacion::where('tb_preguntas_caracterizacion.id','=',$max_preguntas_simulacion)->get();

        return [
            'estado' => 'Ok',
            'pregunta_simulacion' => $pregunta_simulacion
        ];
    }

    public function preFlow(Request $request){
        $idUsuario=$request->idUsuario;
        $idPregunta=$request->idP;

        $pregunta_simulacion=Tb_preguntas_caracterizacion::where('tb_preguntas_caracterizacion.id','=',$idPregunta)->get();

        return [
            'estado' => 'Ok',
            'pregunta_simulacion' => $pregunta_simulacion
        ];
    }

    public function nextFlow(Request $request){
        $idUsuario=$request->idUsuario;
        $idPregunta=$request->idP;
        $valor=$request->valor;

        $pregunta_simulacion=Tb_preguntas_caracterizacion::where('tb_preguntas_caracterizacion.id','=',$idPregunta)->get();

        foreach($pregunta_simulacion as $vueltaP){
            $cadenaP = $vueltaP->pregunta;
            }

        switch ($idPregunta) {
            case '1':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si pregunta es 1 y entra por si'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=1;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=2;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si  si pregunta es 1 y entra por no'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',1)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->pregunta;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=1;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=2;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '2':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=2;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=3;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',2)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->pregunta;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=2;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=3;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '3':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',5)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=5;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();


                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',6)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=6;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $next_question=5;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=3;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $next_question=4;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '4':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',4)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=4;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',6)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=6;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $next_question=5;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',3)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=3;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',6)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=6;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $next_question=5;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '5':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=5;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=6;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',7)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=7;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=6;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '6':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=6;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=9;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=6;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=7;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '7':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=7;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=8;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',8)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=8;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=16;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '8':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',9)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=9;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=17;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',10)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=10;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=17;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '9':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',12)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=12;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=11;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',11)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=11;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=10;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '10':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',15)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=15;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=17;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=10;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=12;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                            // Código a ejecutar si $variable1 es 'valor1' pero $variable2 no coincide con ningún caso anterior
                    }
                break;
            case '11':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=11;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=13;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',17)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=17;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=17;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '12':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',13)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=13;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=17;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',14)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=14;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=17;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '13':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=13;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=14;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',16)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=16;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=17;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '14':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',16)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=16;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=17;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=14;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=15;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '15':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',18)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=18;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=17;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',16)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=16;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=17;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '16':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',21)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=21;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=20;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',19)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=19;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=18;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '17':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',22)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=22;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=21;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',20)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=20;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=19;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '18':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',25)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=25;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=20;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',23)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=23;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=20;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '19':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',26)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=26;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=21;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',24)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=24;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=21;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '20':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=20;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=22;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',27)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=27;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=22;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                            // Código a ejecutar si $variable1 es 'valor1' pero $variable2 no coincide con ningún caso anterior
                    }
                break;
            case '21':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=21;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=23;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',28)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=28;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=23;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '22':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',29)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=29;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=32;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=22;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=24;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '23':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',30)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=30;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',35)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=35;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                                $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',36)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_simulacion=new Tb_avances_simulacion();
                                    $tb_avances_simulacion->idExterno=36;
                                    $tb_avances_simulacion->cadena=$cadenaE;
                                    $tb_avances_simulacion->pregunta=0;
                                    $tb_avances_simulacion->enunciado=1;
                                    $tb_avances_simulacion->idUsuario=$idUsuario;
                                    $tb_avances_simulacion->estado=1;
                                    $tb_avances_simulacion->save();

                                    $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',37)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_avances_simulacion=new Tb_avances_simulacion();
                                        $tb_avances_simulacion->idExterno=37;
                                        $tb_avances_simulacion->cadena=$cadenaE;
                                        $tb_avances_simulacion->pregunta=0;
                                        $tb_avances_simulacion->enunciado=1;
                                        $tb_avances_simulacion->idUsuario=$idUsuario;
                                        $tb_avances_simulacion->estado=1;
                                        $tb_avances_simulacion->save();

                            $next_question=26;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=23;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=25;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '24':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',33)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=33;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=32;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',31)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=31;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=32;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '25':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',34)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=34;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',35)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=35;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                                $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',36)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_simulacion=new Tb_avances_simulacion();
                                    $tb_avances_simulacion->idExterno=36;
                                    $tb_avances_simulacion->cadena=$cadenaE;
                                    $tb_avances_simulacion->pregunta=0;
                                    $tb_avances_simulacion->enunciado=1;
                                    $tb_avances_simulacion->idUsuario=$idUsuario;
                                    $tb_avances_simulacion->estado=1;
                                    $tb_avances_simulacion->save();

                                    $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',37)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_avances_simulacion=new Tb_avances_simulacion();
                                        $tb_avances_simulacion->idExterno=37;
                                        $tb_avances_simulacion->cadena=$cadenaE;
                                        $tb_avances_simulacion->pregunta=0;
                                        $tb_avances_simulacion->enunciado=1;
                                        $tb_avances_simulacion->idUsuario=$idUsuario;
                                        $tb_avances_simulacion->estado=1;
                                        $tb_avances_simulacion->save();

                            $next_question=26;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',32)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=32;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();


                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',35)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=35;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                                $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',36)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_simulacion=new Tb_avances_simulacion();
                                    $tb_avances_simulacion->idExterno=36;
                                    $tb_avances_simulacion->cadena=$cadenaE;
                                    $tb_avances_simulacion->pregunta=0;
                                    $tb_avances_simulacion->enunciado=1;
                                    $tb_avances_simulacion->idUsuario=$idUsuario;
                                    $tb_avances_simulacion->estado=1;
                                    $tb_avances_simulacion->save();

                                    $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',37)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_avances_simulacion=new Tb_avances_simulacion();
                                        $tb_avances_simulacion->idExterno=37;
                                        $tb_avances_simulacion->cadena=$cadenaE;
                                        $tb_avances_simulacion->pregunta=0;
                                        $tb_avances_simulacion->enunciado=1;
                                        $tb_avances_simulacion->idUsuario=$idUsuario;
                                        $tb_avances_simulacion->estado=1;
                                        $tb_avances_simulacion->save();

                            $next_question=26;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '26':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=26;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=27;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',39)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=39;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',40)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=40;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                                $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',41)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_simulacion=new Tb_avances_simulacion();
                                    $tb_avances_simulacion->idExterno=41;
                                    $tb_avances_simulacion->cadena=$cadenaE;
                                    $tb_avances_simulacion->pregunta=0;
                                    $tb_avances_simulacion->enunciado=1;
                                    $tb_avances_simulacion->idUsuario=$idUsuario;
                                    $tb_avances_simulacion->estado=1;
                                    $tb_avances_simulacion->save();

                                    $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',42)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_avances_simulacion=new Tb_avances_simulacion();
                                        $tb_avances_simulacion->idExterno=42;
                                        $tb_avances_simulacion->cadena=$cadenaE;
                                        $tb_avances_simulacion->pregunta=0;
                                        $tb_avances_simulacion->enunciado=1;
                                        $tb_avances_simulacion->idUsuario=$idUsuario;
                                        $tb_avances_simulacion->estado=1;
                                        $tb_avances_simulacion->save();

                            $next_question=28;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '27':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',39)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=39;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',40)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=40;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                                $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',41)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_simulacion=new Tb_avances_simulacion();
                                    $tb_avances_simulacion->idExterno=41;
                                    $tb_avances_simulacion->cadena=$cadenaE;
                                    $tb_avances_simulacion->pregunta=0;
                                    $tb_avances_simulacion->enunciado=1;
                                    $tb_avances_simulacion->idUsuario=$idUsuario;
                                    $tb_avances_simulacion->estado=1;
                                    $tb_avances_simulacion->save();

                                    $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',42)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_avances_simulacion=new Tb_avances_simulacion();
                                        $tb_avances_simulacion->idExterno=42;
                                        $tb_avances_simulacion->cadena=$cadenaE;
                                        $tb_avances_simulacion->pregunta=0;
                                        $tb_avances_simulacion->enunciado=1;
                                        $tb_avances_simulacion->idUsuario=$idUsuario;
                                        $tb_avances_simulacion->estado=1;
                                        $tb_avances_simulacion->save();

                            $next_question=28;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',38)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=38;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',39)->get();

                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=39;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',40)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=40;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                                $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',41)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_simulacion=new Tb_avances_simulacion();
                                    $tb_avances_simulacion->idExterno=41;
                                    $tb_avances_simulacion->cadena=$cadenaE;
                                    $tb_avances_simulacion->pregunta=0;
                                    $tb_avances_simulacion->enunciado=1;
                                    $tb_avances_simulacion->idUsuario=$idUsuario;
                                    $tb_avances_simulacion->estado=1;
                                    $tb_avances_simulacion->save();

                                    $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',42)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_avances_simulacion=new Tb_avances_simulacion();
                                        $tb_avances_simulacion->idExterno=42;
                                        $tb_avances_simulacion->cadena=$cadenaE;
                                        $tb_avances_simulacion->pregunta=0;
                                        $tb_avances_simulacion->enunciado=1;
                                        $tb_avances_simulacion->idUsuario=$idUsuario;
                                        $tb_avances_simulacion->estado=1;
                                        $tb_avances_simulacion->save();

                            $next_question=28;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '28':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',43)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=43;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',44)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=44;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                            $next_question=32;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=28;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=29;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '29':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',43)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=43;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',44)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=44;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                            $next_question=32;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=29;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=30;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                    // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                    return [
                        'estado' => 'error',
                        'mensaje' => "El caso no existe"
                    ];
                }
                break;
            case '30':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',43)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=43;
                            $tb_avances_simulacion->cadena=$cadenaE;
                            $tb_avances_simulacion->pregunta=0;
                            $tb_avances_simulacion->enunciado=1;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();

                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',44)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=44;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                            $next_question=32;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $tb_avances_simulacion=new Tb_avances_simulacion();
                            $tb_avances_simulacion->idExterno=30;
                            $tb_avances_simulacion->cadena=$cadenaP;
                            $tb_avances_simulacion->pregunta=1;
                            $tb_avances_simulacion->enunciado=0;
                            $tb_avances_simulacion->idUsuario=$idUsuario;
                            $tb_avances_simulacion->estado=1;
                            $tb_avances_simulacion->save();
                            $next_question=3;
                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'], 500);
                        }
                        break;
                    default:
                        // Código a ejecutar si $variable1 es 'valor1' pero $variable2 no coincide con ningún caso anterior
                        return [
                            'estado' => 'error',
                            'mensaje' => "El caso no existe"
                        ];
                    }
                break;
                case '31':
                    switch ($valor) {
                        case '1':
                            // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',43)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            try {
                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=43;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                                $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',44)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_simulacion=new Tb_avances_simulacion();
                                    $tb_avances_simulacion->idExterno=44;
                                    $tb_avances_simulacion->cadena=$cadenaE;
                                    $tb_avances_simulacion->pregunta=0;
                                    $tb_avances_simulacion->enunciado=1;
                                    $tb_avances_simulacion->idUsuario=$idUsuario;
                                    $tb_avances_simulacion->estado=1;
                                    $tb_avances_simulacion->save();

                                $next_question=32;
                                return response()->json([
                                    'estado' => 'Ok',
                                    'message' => $next_question
                                   ]);
                            } catch (\Exception $e) {
                                return response()->json(['error' => 'Ocurrió un error interno'], 500);
                            }
                            break;
                        case '2':
                            // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',45)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            try {
                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=45;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();

                                $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',46)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_simulacion=new Tb_avances_simulacion();
                                    $tb_avances_simulacion->idExterno=46;
                                    $tb_avances_simulacion->cadena=$cadenaE;
                                    $tb_avances_simulacion->pregunta=0;
                                    $tb_avances_simulacion->enunciado=1;
                                    $tb_avances_simulacion->idUsuario=$idUsuario;
                                    $tb_avances_simulacion->estado=1;
                                    $tb_avances_simulacion->save();

                                $next_question=32;
                                return response()->json([
                                    'estado' => 'Ok',
                                    'message' => $next_question
                                   ]);
                            } catch (\Exception $e) {
                                return response()->json(['error' => 'Ocurrió un error interno'], 500);
                            }
                            break;
                        default:
                            // Código a ejecutar si $variable1 es 'valor1' pero $variable2 no coincide con ningún caso anterior
                            return [
                                'estado' => 'error',
                                'mensaje' => "El caso no existe"
                            ];
                        }
                        break;
                case '32':
                    switch ($valor) {
                        case '1':
                            // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                            $enunciado_simulacion=Tb_enunciados::where('tb_enunciados.id','=',47)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            try {
                                $tb_avances_simulacion=new Tb_avances_simulacion();
                                $tb_avances_simulacion->idExterno=47;
                                $tb_avances_simulacion->cadena=$cadenaE;
                                $tb_avances_simulacion->pregunta=0;
                                $tb_avances_simulacion->enunciado=1;
                                $tb_avances_simulacion->idUsuario=$idUsuario;
                                $tb_avances_simulacion->estado=1;
                                $tb_avances_simulacion->save();
                                $next_question=99;
                                return response()->json([
                                    'estado' => 'Ok',
                                    'message' => $next_question
                                   ]);
                            } catch (\Exception $e) {
                                return response()->json(['error' => 'Ocurrió un error interno'], 500);
                            }
                            break;
                        case '2':
                            // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                                $next_question=99;
                                return response()->json([
                                    'estado' => 'Ok',
                                    'message' => $next_question
                                   ]);
                            break;
                        default:
                                // Código a ejecutar si $variable1 es 'valor1' pero $variable2 no coincide con ningún caso anterior
                        }
                break;
            default:
                // Código a ejecutar si $variable1 no coincide con ningún caso anterior
                return [
                    'estado' => 'error',
                    'mensaje' => "El caso no existe"
                ];
        }

        return [
            'estado' => 'Ok',
            'pregunta_simulacion' => $pregunta_simulacion
        ];
    }
}
