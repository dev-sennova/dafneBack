<?php

namespace App\Http\Controllers;

use App\Models\Tb_avances_legal;
use App\Models\Tb_enunciados_legal;
use App\Models\Tb_preguntas_legal;
use Illuminate\Http\Request;

class Tb_preguntas_legalController extends Controller
{
    public function index(Request $request)
    {
        $preguntas_legal = Tb_preguntas_legal::orderBy('preguntas_legal.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'preguntas_legal' => $preguntas_legal
        ];
    }

    public function indexOne(Request $request)
    {
        $preguntas_legal = Tb_preguntas_legal::orderBy('preguntas_legal.id','desc')
        ->where('tb_preguntas_legal.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'preguntas_legal' => $preguntas_legal
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_preguntas_legal=new Tb_preguntas_legal();
            $tb_preguntas_legal->pregunta=$request->pregunta;
            $tb_preguntas_legal->estado=1;

            if ($tb_preguntas_legal->save()) {
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
            $tb_preguntas_legal=Tb_preguntas_legal::findOrFail($request->id);
            $tb_preguntas_legal->pregunta=$request->pregunta;
            $tb_preguntas_legal->estado='1';

            if ($tb_preguntas_legal->save()) {
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
            $tb_preguntas_legal=Tb_preguntas_legal::findOrFail($request->id);
            $tb_preguntas_legal->estado='0';

            if ($tb_preguntas_legal->save()) {
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
            $tb_preguntas_legal=Tb_preguntas_legal::findOrFail($request->id);
            $tb_preguntas_legal->estado='1';

            if ($tb_preguntas_legal->save()) {
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

        $cant_preguntas_simulacion = Tb_preguntas_legal::where('tb_avances_legal.idUsuario','=',$idUsuario)->count();

        if($cant_preguntas_simulacion>0){
            $max_preguntas_simulacion = Tb_avances_legal::where('tb_avances_legal.idUsuario','=',$idUsuario)

            ->select('tb_avances_legal.idExterno')
            ->orderBy('preguntas_caracterizacion.id','desc')
            ->first();
        }else{
            $max_preguntas_simulacion = 1;
        }

        $pregunta_simulacion=Tb_preguntas_legal::where('tb_preguntas_legal.id','=',$max_preguntas_simulacion)->get();

        return [
            'estado' => 'Ok',
            'pregunta_simulacion' => $pregunta_simulacion
        ];
    }

    public function preFlow(Request $request){
        $idUsuario=$request->idUsuario;
        $idPregunta=$request->idP;

        $pregunta_simulacion=Tb_preguntas_legal::where('tb_preguntas_legal.id','=',$idPregunta)->get();

        return [
            'estado' => 'Ok',
            'pregunta_simulacion' => $pregunta_simulacion
        ];
    }

    public function nextFlow(Request $request){
        $idUsuario=$request->idUsuario;
        $idPregunta=$request->idP;
        $valor=$request->valor;

        $pregunta_simulacion=Tb_preguntas_legal::where('tb_preguntas_legal.id','=',$idPregunta)->get();

        foreach($pregunta_simulacion as $vueltaP){
            $cadenaP = $vueltaP->pregunta;
            }

        switch ($idPregunta) {
            case '1':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si pregunta es 1 y entra por si'
                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=1;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',1)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->pregunta;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=1;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=2;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',2)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->pregunta;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=2;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',5)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=5;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();


                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',6)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=6;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=3;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',4)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=4;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',6)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=6;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',3)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=3;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',6)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=6;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=5;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',7)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=7;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=6;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=6;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=7;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',8)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=8;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',9)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=9;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',10)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=10;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',12)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=12;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',11)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=11;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',15)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=15;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=10;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=11;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',17)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=17;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',13)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=13;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',14)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=14;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=13;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',16)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=16;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',16)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=16;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=14;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',18)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=18;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',16)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=16;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',21)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=21;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',19)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=19;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',22)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=22;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',20)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=20;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',25)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=25;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',23)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=23;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',26)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=26;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',24)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=24;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=20;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',27)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=27;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=21;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',28)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=28;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',29)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=29;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=22;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',30)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=30;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',35)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=35;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',36)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_preguntas_legal=new Tb_preguntas_legal();
                                    $tb_preguntas_legal->idExterno=36;
                                    $tb_preguntas_legal->cadena=$cadenaE;
                                    $tb_preguntas_legal->pregunta=0;
                                    $tb_preguntas_legal->enunciado=1;
                                    $tb_preguntas_legal->idUsuario=$idUsuario;
                                    $tb_preguntas_legal->estado=1;
                                    $tb_preguntas_legal->save();

                                    $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',37)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_preguntas_legal=new Tb_preguntas_legal();
                                        $tb_preguntas_legal->idExterno=37;
                                        $tb_preguntas_legal->cadena=$cadenaE;
                                        $tb_preguntas_legal->pregunta=0;
                                        $tb_preguntas_legal->enunciado=1;
                                        $tb_preguntas_legal->idUsuario=$idUsuario;
                                        $tb_preguntas_legal->estado=1;
                                        $tb_preguntas_legal->save();

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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=23;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',33)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=33;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',31)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=31;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',34)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=34;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',35)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=35;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',36)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_preguntas_legal=new Tb_preguntas_legal();
                                    $tb_preguntas_legal->idExterno=36;
                                    $tb_preguntas_legal->cadena=$cadenaE;
                                    $tb_preguntas_legal->pregunta=0;
                                    $tb_preguntas_legal->enunciado=1;
                                    $tb_preguntas_legal->idUsuario=$idUsuario;
                                    $tb_preguntas_legal->estado=1;
                                    $tb_preguntas_legal->save();

                                    $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',37)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_preguntas_legal=new Tb_preguntas_legal();
                                        $tb_preguntas_legal->idExterno=37;
                                        $tb_preguntas_legal->cadena=$cadenaE;
                                        $tb_preguntas_legal->pregunta=0;
                                        $tb_preguntas_legal->enunciado=1;
                                        $tb_preguntas_legal->idUsuario=$idUsuario;
                                        $tb_preguntas_legal->estado=1;
                                        $tb_preguntas_legal->save();

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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',32)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=32;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();


                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',35)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=35;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',36)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_preguntas_legal=new Tb_preguntas_legal();
                                    $tb_preguntas_legal->idExterno=36;
                                    $tb_preguntas_legal->cadena=$cadenaE;
                                    $tb_preguntas_legal->pregunta=0;
                                    $tb_preguntas_legal->enunciado=1;
                                    $tb_preguntas_legal->idUsuario=$idUsuario;
                                    $tb_preguntas_legal->estado=1;
                                    $tb_preguntas_legal->save();

                                    $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',37)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_preguntas_legal=new Tb_preguntas_legal();
                                        $tb_preguntas_legal->idExterno=37;
                                        $tb_preguntas_legal->cadena=$cadenaE;
                                        $tb_preguntas_legal->pregunta=0;
                                        $tb_preguntas_legal->enunciado=1;
                                        $tb_preguntas_legal->idUsuario=$idUsuario;
                                        $tb_preguntas_legal->estado=1;
                                        $tb_preguntas_legal->save();

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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=26;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',39)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=39;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',40)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=40;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',41)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_preguntas_legal=new Tb_preguntas_legal();
                                    $tb_preguntas_legal->idExterno=41;
                                    $tb_preguntas_legal->cadena=$cadenaE;
                                    $tb_preguntas_legal->pregunta=0;
                                    $tb_preguntas_legal->enunciado=1;
                                    $tb_preguntas_legal->idUsuario=$idUsuario;
                                    $tb_preguntas_legal->estado=1;
                                    $tb_preguntas_legal->save();

                                    $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',42)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_preguntas_legal=new Tb_preguntas_legal();
                                        $tb_preguntas_legal->idExterno=42;
                                        $tb_preguntas_legal->cadena=$cadenaE;
                                        $tb_preguntas_legal->pregunta=0;
                                        $tb_preguntas_legal->enunciado=1;
                                        $tb_preguntas_legal->idUsuario=$idUsuario;
                                        $tb_preguntas_legal->estado=1;
                                        $tb_preguntas_legal->save();

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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',39)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=39;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',40)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=40;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',41)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_preguntas_legal=new Tb_preguntas_legal();
                                    $tb_preguntas_legal->idExterno=41;
                                    $tb_preguntas_legal->cadena=$cadenaE;
                                    $tb_preguntas_legal->pregunta=0;
                                    $tb_preguntas_legal->enunciado=1;
                                    $tb_preguntas_legal->idUsuario=$idUsuario;
                                    $tb_preguntas_legal->estado=1;
                                    $tb_preguntas_legal->save();

                                    $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',42)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_preguntas_legal=new Tb_preguntas_legal();
                                        $tb_preguntas_legal->idExterno=42;
                                        $tb_preguntas_legal->cadena=$cadenaE;
                                        $tb_preguntas_legal->pregunta=0;
                                        $tb_preguntas_legal->enunciado=1;
                                        $tb_preguntas_legal->idUsuario=$idUsuario;
                                        $tb_preguntas_legal->estado=1;
                                        $tb_preguntas_legal->save();

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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',38)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=38;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',39)->get();

                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=39;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',40)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=40;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',41)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_preguntas_legal=new Tb_preguntas_legal();
                                    $tb_preguntas_legal->idExterno=41;
                                    $tb_preguntas_legal->cadena=$cadenaE;
                                    $tb_preguntas_legal->pregunta=0;
                                    $tb_preguntas_legal->enunciado=1;
                                    $tb_preguntas_legal->idUsuario=$idUsuario;
                                    $tb_preguntas_legal->estado=1;
                                    $tb_preguntas_legal->save();

                                    $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',42)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                                        $tb_preguntas_legal=new Tb_preguntas_legal();
                                        $tb_preguntas_legal->idExterno=42;
                                        $tb_preguntas_legal->cadena=$cadenaE;
                                        $tb_preguntas_legal->pregunta=0;
                                        $tb_preguntas_legal->enunciado=1;
                                        $tb_preguntas_legal->idUsuario=$idUsuario;
                                        $tb_preguntas_legal->estado=1;
                                        $tb_preguntas_legal->save();

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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',43)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=43;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',44)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=44;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=28;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',43)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=43;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',44)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=44;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=29;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                        $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',43)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=43;
                            $tb_preguntas_legal->cadena=$cadenaE;
                            $tb_preguntas_legal->pregunta=0;
                            $tb_preguntas_legal->enunciado=1;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',44)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=44;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

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
                            $tb_preguntas_legal=new Tb_preguntas_legal();
                            $tb_preguntas_legal->idExterno=30;
                            $tb_preguntas_legal->cadena=$cadenaP;
                            $tb_preguntas_legal->pregunta=1;
                            $tb_preguntas_legal->enunciado=0;
                            $tb_preguntas_legal->idUsuario=$idUsuario;
                            $tb_preguntas_legal->estado=1;
                            $tb_preguntas_legal->save();
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
                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',43)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            try {
                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=43;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',44)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_preguntas_legal=new Tb_preguntas_legal();
                                    $tb_preguntas_legal->idExterno=44;
                                    $tb_preguntas_legal->cadena=$cadenaE;
                                    $tb_preguntas_legal->pregunta=0;
                                    $tb_preguntas_legal->enunciado=1;
                                    $tb_preguntas_legal->idUsuario=$idUsuario;
                                    $tb_preguntas_legal->estado=1;
                                    $tb_preguntas_legal->save();

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
                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',45)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            try {
                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=45;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',46)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_preguntas_legal=new Tb_preguntas_legal();
                                    $tb_preguntas_legal->idExterno=46;
                                    $tb_preguntas_legal->cadena=$cadenaE;
                                    $tb_preguntas_legal->pregunta=0;
                                    $tb_preguntas_legal->enunciado=1;
                                    $tb_preguntas_legal->idUsuario=$idUsuario;
                                    $tb_preguntas_legal->estado=1;
                                    $tb_preguntas_legal->save();

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
                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',47)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            try {
                                $tb_preguntas_legal=new Tb_preguntas_legal();
                                $tb_preguntas_legal->idExterno=47;
                                $tb_preguntas_legal->cadena=$cadenaE;
                                $tb_preguntas_legal->pregunta=0;
                                $tb_preguntas_legal->enunciado=1;
                                $tb_preguntas_legal->idUsuario=$idUsuario;
                                $tb_preguntas_legal->estado=1;
                                $tb_preguntas_legal->save();
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
