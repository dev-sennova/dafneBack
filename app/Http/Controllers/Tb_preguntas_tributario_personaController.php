<?php

namespace App\Http\Controllers;

use App\Models\Tb_avances_tributario_persona;
use App\Models\Tb_enlaces_tributario_persona;
use App\Models\Tb_enunciados_tributario_persona;
use App\Models\Tb_preguntas_tributario_persona;
use Illuminate\Http\Request;

class Tb_preguntas_tributario_personaController extends Controller
{
    public function index(Request $request)
    {
        $preguntas_tributario_persona = Tb_preguntas_tributario_persona::orderBy('tb_preguntas_tributario_persona.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'preguntas_tributario_persona' => $preguntas_tributario_persona
        ];
    }

    public function indexOne(Request $request)
    {
        $preguntas_tributario_persona = Tb_preguntas_tributario_persona::orderBy('tb_preguntas_tributario_persona.id','desc')
        ->where('tb_preguntas_tributario_persona.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'preguntas_tributario_persona' => $preguntas_tributario_persona
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_preguntas_tributario_persona=new Tb_preguntas_tributario_persona();
            $tb_preguntas_tributario_persona->pregunta=$request->pregunta;
            $tb_preguntas_tributario_persona->estado=1;

            if ($tb_preguntas_tributario_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_tributario_persona creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_tributario_persona no pudo ser creada'
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
            $tb_preguntas_tributario_persona=Tb_preguntas_tributario_persona::findOrFail($request->id);
            $tb_preguntas_tributario_persona->pregunta=$request->pregunta;
            $tb_preguntas_tributario_persona->estado='1';

            if ($tb_preguntas_tributario_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_tributario_persona actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_tributario_persona no pudo ser actualizada'
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
            $tb_preguntas_tributario_persona=Tb_preguntas_tributario_persona::findOrFail($request->id);
            $tb_preguntas_tributario_persona->estado='0';

            if ($tb_preguntas_tributario_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_tributario_persona desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_tributario_persona no pudo ser desactivada'
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
            $tb_preguntas_tributario_persona=Tb_preguntas_tributario_persona::findOrFail($request->id);
            $tb_preguntas_tributario_persona->estado='1';

            if ($tb_preguntas_tributario_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'preguntas_tributario_persona activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'preguntas_tributario_persona no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function validateFlow(Request $request){
        $idUsuario=$request->idUsuario;
        $idPregunta=$request->idP;

        $cant_preguntas_simulacion = Tb_avances_tributario_persona::where('tb_avances_tributario_persona.idUsuario','=',$idUsuario)->count();

        if($cant_preguntas_simulacion>0){
            $max_preguntas_simulacion = Tb_avances_tributario_persona::where('tb_avances_tributario_persona.idUsuario','=',$idUsuario)

            ->select('tb_avances_tributario_persona.idExterno')
            ->orderBy('preguntas_tributario_persona.id','desc')
            ->first();
        }else{
            $max_preguntas_simulacion = 1;
        }

        $pregunta_simulacion=Tb_preguntas_tributario_persona::where('tb_preguntas_tributario_persona.id','=',$max_preguntas_simulacion)->get();

        return [
            'estado' => 'Ok',
            'pregunta_simulacion' => $pregunta_simulacion
        ];
    }

    public function preFlow(Request $request){
        $idUsuario=$request->idUsuario;
        $idPregunta=$request->idP;

        $pregunta_simulacion=Tb_preguntas_tributario_persona::where('tb_preguntas_tributario_persona.id','=',$idPregunta)->get();

        return [
            'estado' => 'Ok',
            'pregunta_simulacion' => $pregunta_simulacion
        ];
    }

    public function nextFlow(Request $request){
        $idUsuario=$request->idUsuario;
        $idPregunta=$request->idP;
        $valor=$request->valor;

        $pregunta_simulacion=Tb_preguntas_tributario_persona::where('tb_preguntas_tributario_persona.id','=',$idPregunta)->get();

        foreach($pregunta_simulacion as $vueltaP){
            $cadenaP = $vueltaP->pregunta;
            }

        switch ($idPregunta) {
            case '1':
                $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',1)->get();

            foreach($enunciado_simulacion as $vueltaE){
                $cadenaE = $vueltaE->pregunta;
                }

            try {
                $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                $tb_avances_tributario_persona->idExterno=1;
                $tb_avances_tributario_persona->cadena=$cadenaP;
                $tb_avances_tributario_persona->pregunta=0;
                $tb_avances_tributario_persona->enunciado=1;
                $tb_avances_tributario_persona->enlace=0;
                $tb_avances_tributario_persona->idUsuario=$idUsuario;
                $tb_avances_tributario_persona->estado=1;
                $tb_avances_tributario_persona->save();

                $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',1)->get();

                foreach($enlace_simulacion as $vueltaEn){
                    $cadenaEn = $vueltaEn->enlace;
                    }

                $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                $tb_preguntas_tributario_persona->idExterno=1;
                $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                $tb_preguntas_tributario_persona->pregunta=0;
                $tb_preguntas_tributario_persona->enunciado=0;
                $tb_preguntas_tributario_persona->enlace=1;
                $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                $tb_preguntas_tributario_persona->estado=1;
                $tb_preguntas_tributario_persona->save();

            } catch (\Exception $e) {
                return response()->json(['error' => 'Ocurrió un error interno'], 500);
            }
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si pregunta es 1 y entra por si'
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',2)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                        $cadenaE = $vueltaE->pregunta;
                        }
                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=2;
                            $tb_avances_tributario_persona->cadena=$cadenaP;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',9)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->pregunta;
                            }

                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=9;
                            $tb_avances_tributario_persona->cadena=$cadenaP;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',10)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->pregunta;
                            }

                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=10;
                            $tb_avances_tributario_persona->cadena=$cadenaP;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $next_question=10;
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
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',2)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }

                        try {
                            $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_preguntas_tributario_persona->idExterno=2;
                            $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                            $tb_preguntas_tributario_persona->pregunta=0;
                            $tb_preguntas_tributario_persona->enunciado=0;
                            $tb_preguntas_tributario_persona->enlace=1;
                            $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                            $tb_preguntas_tributario_persona->estado=1;
                            $tb_preguntas_tributario_persona->save();

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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',3)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->pregunta;
                            }
                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=3;
                            $tb_avances_tributario_persona->cadena=$cadenaP;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',2)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->pregunta;
                            }

                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=2;
                            $tb_avances_tributario_persona->cadena=$cadenaP;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',9)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->pregunta;
                            }

                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=9;
                            $tb_avances_tributario_persona->cadena=$cadenaP;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',10)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->pregunta;
                            }

                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=10;
                            $tb_avances_tributario_persona->cadena=$cadenaP;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $next_question=10;
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
                            $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',3)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }

                        try {
                            $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_preguntas_tributario_persona->idExterno=3;
                            $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                            $tb_preguntas_tributario_persona->pregunta=0;
                            $tb_preguntas_tributario_persona->enunciado=0;
                            $tb_preguntas_tributario_persona->enlace=1;
                            $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                            $tb_preguntas_tributario_persona->estado=1;
                            $tb_preguntas_tributario_persona->save();

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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',4)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=4;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',5)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }

                            $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_preguntas_tributario_persona->idExterno=5;
                            $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                            $tb_preguntas_tributario_persona->pregunta=0;
                            $tb_preguntas_tributario_persona->enunciado=0;
                            $tb_preguntas_tributario_persona->enlace=1;
                            $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                            $tb_preguntas_tributario_persona->estado=1;
                            $tb_preguntas_tributario_persona->save();

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
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',4)->get();

                        foreach($enlace_simulacion as $vueltaEn){
                            $cadenaEn = $vueltaEn->enlace;
                            }

                        try {
                            $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_preguntas_tributario_persona->idExterno=4;
                            $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                            $tb_preguntas_tributario_persona->pregunta=0;
                            $tb_preguntas_tributario_persona->enunciado=0;
                            $tb_preguntas_tributario_persona->enlace=1;
                            $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                            $tb_preguntas_tributario_persona->estado=1;
                            $tb_preguntas_tributario_persona->save();

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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',4)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }
                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=4;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',5)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }

                                $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                                $tb_preguntas_tributario_persona->idExterno=5;
                                $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                                $tb_preguntas_tributario_persona->pregunta=0;
                                $tb_preguntas_tributario_persona->enunciado=0;
                                $tb_preguntas_tributario_persona->enlace=1;
                                $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                                $tb_preguntas_tributario_persona->estado=1;
                                $tb_preguntas_tributario_persona->save();

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
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',7)->get();

                        foreach($enlace_simulacion as $vueltaEn){
                            $cadenaEn = $vueltaEn->enlace;
                            }

                        try {
                                $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                                $tb_preguntas_tributario_persona->idExterno=7;
                                $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                                $tb_preguntas_tributario_persona->pregunta=0;
                                $tb_preguntas_tributario_persona->enunciado=0;
                                $tb_preguntas_tributario_persona->enlace=1;
                                $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                                $tb_preguntas_tributario_persona->estado=1;
                                $tb_preguntas_tributario_persona->save();

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
            case '5':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',6)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }
                        try {
                                $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                                $tb_preguntas_tributario_persona->idExterno=6;
                                $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                                $tb_preguntas_tributario_persona->pregunta=0;
                                $tb_preguntas_tributario_persona->enunciado=0;
                                $tb_preguntas_tributario_persona->enlace=1;
                                $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                                $tb_preguntas_tributario_persona->estado=1;
                                $tb_preguntas_tributario_persona->save();

                            $next_question=7;
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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',5)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=5;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',8)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }

                                $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                                $tb_preguntas_tributario_persona->idExterno=8;
                                $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                                $tb_preguntas_tributario_persona->pregunta=0;
                                $tb_preguntas_tributario_persona->enunciado=0;
                                $tb_preguntas_tributario_persona->enlace=1;
                                $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                                $tb_preguntas_tributario_persona->estado=1;
                                $tb_preguntas_tributario_persona->save();

                                $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',6)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                                    $tb_avances_tributario_persona->idExterno=6;
                                    $tb_avances_tributario_persona->cadena=$cadenaE;
                                    $tb_avances_tributario_persona->pregunta=0;
                                    $tb_avances_tributario_persona->enunciado=1;
                                    $tb_avances_tributario_persona->enlace=0;
                                    $tb_avances_tributario_persona->idUsuario=$idUsuario;
                                    $tb_avances_tributario_persona->estado=1;
                                    $tb_avances_tributario_persona->save();

                            $next_question=14;
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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',8)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=8;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',9)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                                    $tb_avances_tributario_persona->idExterno=9;
                                    $tb_avances_tributario_persona->cadena=$cadenaE;
                                    $tb_avances_tributario_persona->pregunta=0;
                                    $tb_avances_tributario_persona->enunciado=1;
                                    $tb_avances_tributario_persona->enlace=0;
                                    $tb_avances_tributario_persona->idUsuario=$idUsuario;
                                    $tb_avances_tributario_persona->estado=1;
                                    $tb_avances_tributario_persona->save();
                                    $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',10)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                                    $tb_avances_tributario_persona->idExterno=10;
                                    $tb_avances_tributario_persona->cadena=$cadenaE;
                                    $tb_avances_tributario_persona->pregunta=0;
                                    $tb_avances_tributario_persona->enunciado=1;
                                    $tb_avances_tributario_persona->enlace=0;
                                    $tb_avances_tributario_persona->idUsuario=$idUsuario;
                                    $tb_avances_tributario_persona->estado=1;
                                    $tb_avances_tributario_persona->save();

                            $next_question=10;
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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',7)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=7;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',9)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                                    $tb_avances_tributario_persona->idExterno=9;
                                    $tb_avances_tributario_persona->cadena=$cadenaE;
                                    $tb_avances_tributario_persona->pregunta=0;
                                    $tb_avances_tributario_persona->enunciado=1;
                                    $tb_avances_tributario_persona->enlace=0;
                                    $tb_avances_tributario_persona->idUsuario=$idUsuario;
                                    $tb_avances_tributario_persona->estado=1;
                                    $tb_avances_tributario_persona->save();
                                    $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',10)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                                    $tb_avances_tributario_persona->idExterno=10;
                                    $tb_avances_tributario_persona->cadena=$cadenaE;
                                    $tb_avances_tributario_persona->pregunta=0;
                                    $tb_avances_tributario_persona->enunciado=1;
                                    $tb_avances_tributario_persona->enlace=0;
                                    $tb_avances_tributario_persona->idUsuario=$idUsuario;
                                    $tb_avances_tributario_persona->estado=1;
                                    $tb_avances_tributario_persona->save();

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
            case '7':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',5)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=5;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',8)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }

                                $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                                $tb_preguntas_tributario_persona->idExterno=8;
                                $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                                $tb_preguntas_tributario_persona->pregunta=0;
                                $tb_preguntas_tributario_persona->enunciado=0;
                                $tb_preguntas_tributario_persona->enlace=1;
                                $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                                $tb_preguntas_tributario_persona->estado=1;
                                $tb_preguntas_tributario_persona->save();

                                $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',6)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                                    $tb_avances_tributario_persona->idExterno=6;
                                    $tb_avances_tributario_persona->cadena=$cadenaE;
                                    $tb_avances_tributario_persona->pregunta=0;
                                    $tb_avances_tributario_persona->enunciado=1;
                                    $tb_avances_tributario_persona->enlace=0;
                                    $tb_avances_tributario_persona->idUsuario=$idUsuario;
                                    $tb_avances_tributario_persona->estado=1;
                                    $tb_avances_tributario_persona->save();

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
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',9)->get();

                        foreach($enlace_simulacion as $vueltaEn){
                            $cadenaEn = $vueltaEn->enlace;
                            }

                        try {
                                $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                                $tb_preguntas_tributario_persona->idExterno=9;
                                $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                                $tb_preguntas_tributario_persona->pregunta=0;
                                $tb_preguntas_tributario_persona->enunciado=0;
                                $tb_preguntas_tributario_persona->enlace=1;
                                $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                                $tb_preguntas_tributario_persona->estado=1;
                                $tb_preguntas_tributario_persona->save();

                            $next_question=8;
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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',11)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=11;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',17)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                    $cadenaE = $vueltaE->enunciado;
                                    }

                                    $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                                    $tb_avances_tributario_persona->idExterno=17;
                                    $tb_avances_tributario_persona->cadena=$cadenaE;
                                    $tb_avances_tributario_persona->pregunta=0;
                                    $tb_avances_tributario_persona->enunciado=1;
                                    $tb_avances_tributario_persona->enlace=0;
                                    $tb_avances_tributario_persona->idUsuario=$idUsuario;
                                    $tb_avances_tributario_persona->estado=1;
                                    $tb_avances_tributario_persona->save();

                                    $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',12)->get();

                                    foreach($enlace_simulacion as $vueltaEn){
                                        $cadenaEn = $vueltaEn->enlace;
                                        }
                                            $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                                            $tb_preguntas_tributario_persona->idExterno=12;
                                            $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                                            $tb_preguntas_tributario_persona->pregunta=0;
                                            $tb_preguntas_tributario_persona->enunciado=0;
                                            $tb_preguntas_tributario_persona->enlace=1;
                                            $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                                            $tb_preguntas_tributario_persona->estado=1;
                                            $tb_preguntas_tributario_persona->save();

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
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',10)->get();

                        foreach($enlace_simulacion as $vueltaEn){
                            $cadenaEn = $vueltaEn->enlace;
                            }

                        try {
                                $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                                $tb_preguntas_tributario_persona->idExterno=10;
                                $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                                $tb_preguntas_tributario_persona->pregunta=0;
                                $tb_preguntas_tributario_persona->enunciado=0;
                                $tb_preguntas_tributario_persona->enlace=1;
                                $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                                $tb_preguntas_tributario_persona->estado=1;
                                $tb_preguntas_tributario_persona->save();

                            $next_question=9;
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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',13)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=13;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',17)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=17;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',12)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }
                                    $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                                    $tb_preguntas_tributario_persona->idExterno=12;
                                    $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                                    $tb_preguntas_tributario_persona->pregunta=0;
                                    $tb_preguntas_tributario_persona->enunciado=0;
                                    $tb_preguntas_tributario_persona->enlace=1;
                                    $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                                    $tb_preguntas_tributario_persona->estado=1;
                                    $tb_preguntas_tributario_persona->save();

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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',12)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=12;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',17)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                                $tb_avances_tributario_persona->idExterno=17;
                                $tb_avances_tributario_persona->cadena=$cadenaE;
                                $tb_avances_tributario_persona->pregunta=0;
                                $tb_avances_tributario_persona->enunciado=1;
                                $tb_avances_tributario_persona->enlace=0;
                                $tb_avances_tributario_persona->idUsuario=$idUsuario;
                                $tb_avances_tributario_persona->estado=1;
                                $tb_avances_tributario_persona->save();

                            $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',12)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }
                                    $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                                    $tb_preguntas_tributario_persona->idExterno=12;
                                    $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                                    $tb_preguntas_tributario_persona->pregunta=0;
                                    $tb_preguntas_tributario_persona->enunciado=0;
                                    $tb_preguntas_tributario_persona->enlace=1;
                                    $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                                    $tb_preguntas_tributario_persona->estado=1;
                                    $tb_preguntas_tributario_persona->save();

                            $next_question=13;
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
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',11)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }
                        try {
                            $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_preguntas_tributario_persona->idExterno=11;
                            $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                            $tb_preguntas_tributario_persona->pregunta=0;
                            $tb_preguntas_tributario_persona->enunciado=0;
                            $tb_preguntas_tributario_persona->enlace=1;
                            $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                            $tb_preguntas_tributario_persona->estado=1;
                            $tb_preguntas_tributario_persona->save();

                                    $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',14)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=14;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',15)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }
                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=15;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $next_question=11;
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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',16)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }
                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=16;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $next_question=12;
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
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=11;
                            $tb_avances_tributario_persona->cadena=$cadenaP;
                            $tb_avances_tributario_persona->pregunta=1;
                            $tb_avances_tributario_persona->enunciado=0;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

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
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',13)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }
                        try {
                            $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_preguntas_tributario_persona->idExterno=13;
                            $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                            $tb_preguntas_tributario_persona->pregunta=0;
                            $tb_preguntas_tributario_persona->enunciado=0;
                            $tb_preguntas_tributario_persona->enlace=1;
                            $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                            $tb_preguntas_tributario_persona->estado=1;
                            $tb_preguntas_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',18)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=18;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',19)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=19;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                                $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

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
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',14)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }
                        try {
                            $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_preguntas_tributario_persona->idExterno=14;
                            $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                            $tb_preguntas_tributario_persona->pregunta=0;
                            $tb_preguntas_tributario_persona->enunciado=0;
                            $tb_preguntas_tributario_persona->enlace=1;
                            $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                            $tb_preguntas_tributario_persona->estado=1;
                            $tb_preguntas_tributario_persona->save();

                                    $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',20)->get();

                                    foreach($enunciado_simulacion as $vueltaE){
                                        $cadenaE = $vueltaE->enunciado;
                                        }

                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=20;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',21)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }
                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=21;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $next_question=14;
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
            case '14':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',24)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=24;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',22)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=22;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',23)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=23;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $next_question=16;
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
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=15;
                            $tb_avances_tributario_persona->cadena=$cadenaP;
                            $tb_avances_tributario_persona->pregunta=1;
                            $tb_avances_tributario_persona->enunciado=0;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

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
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',15)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }
                        try {
                            $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_preguntas_tributario_persona->idExterno=15;
                            $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                            $tb_preguntas_tributario_persona->pregunta=0;
                            $tb_preguntas_tributario_persona->enunciado=0;
                            $tb_preguntas_tributario_persona->enlace=1;
                            $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                            $tb_preguntas_tributario_persona->estado=1;
                            $tb_preguntas_tributario_persona->save();

                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',25)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                                $tb_avances_tributario_persona->idExterno=25;
                                $tb_avances_tributario_persona->cadena=$cadenaE;
                                $tb_avances_tributario_persona->pregunta=0;
                                $tb_avances_tributario_persona->enunciado=1;
                                $tb_avances_tributario_persona->enlace=0;
                                $tb_avances_tributario_persona->idUsuario=$idUsuario;
                                $tb_avances_tributario_persona->estado=1;
                                $tb_avances_tributario_persona->save();

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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',26)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=26;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

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
            case '17':
                switch ($valor) {
                    case '1':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorA'
                        $enlace_simulacion=Tb_enlaces_tributario_persona::where('tb_enlaces_tributario_persona.id','=',16)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }
                        try {
                            $tb_preguntas_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_preguntas_tributario_persona->idExterno=16;
                            $tb_preguntas_tributario_persona->cadena=$cadenaEn;
                            $tb_preguntas_tributario_persona->pregunta=0;
                            $tb_preguntas_tributario_persona->enunciado=0;
                            $tb_preguntas_tributario_persona->enlace=1;
                            $tb_preguntas_tributario_persona->idUsuario=$idUsuario;
                            $tb_preguntas_tributario_persona->estado=1;
                            $tb_preguntas_tributario_persona->save();

                            $next_question=18;
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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',27)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=27;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                            $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();

                            $next_question=99;
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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',25)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=25;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                                $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();
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
                        $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',23)->get();

                        foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                        try {
                            $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                            $tb_avances_tributario_persona->idExterno=23;
                            $tb_avances_tributario_persona->cadena=$cadenaE;
                            $tb_avances_tributario_persona->pregunta=0;
                            $tb_avances_tributario_persona->enunciado=1;
                                $tb_avances_tributario_persona->enlace=0;
                            $tb_avances_tributario_persona->idUsuario=$idUsuario;
                            $tb_avances_tributario_persona->estado=1;
                            $tb_avances_tributario_persona->save();
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
                            $enunciado_simulacion=Tb_enunciados_tributario_persona::where('tb_enunciados_tributario_persona.id','=',47)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            try {
                                $tb_avances_tributario_persona=new Tb_avances_tributario_persona();
                                $tb_avances_tributario_persona->idExterno=47;
                                $tb_avances_tributario_persona->cadena=$cadenaE;
                                $tb_avances_tributario_persona->pregunta=0;
                                $tb_avances_tributario_persona->enunciado=1;
                                $tb_avances_tributario_persona->enlace=0;
                                $tb_avances_tributario_persona->idUsuario=$idUsuario;
                                $tb_avances_tributario_persona->estado=1;
                                $tb_avances_tributario_persona->save();
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
