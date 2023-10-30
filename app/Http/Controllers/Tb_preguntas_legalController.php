<?php

namespace App\Http\Controllers;

use App\Models\Tb_avances_legal;
use App\Models\Tb_enlaces_legal;
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
            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
        }

    }

    public function validatePersona(Request $request){
        $idUsuario=$request->idUsuario;

        try {
            $cant_enunciado = Tb_avances_legal::where('tb_avances_legal.idUsuario','=',$idUsuario)
            ->where('tb_avances_legal.enunciado','=',1)
            ->where('tb_avances_legal.idExterno','=',8)
            ->count();

            return [
                'estado' => 'Ok',
                'cant_enunciado' => $cant_enunciado
            ];
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
        }
    }

    public function validateFlow(Request $request){
        $idUsuario=$request->idUsuario;

        $cant_preguntas_simulacion = Tb_avances_legal::where('tb_avances_legal.idUsuario','=',$idUsuario)->count();

        if($cant_preguntas_simulacion>0){
            $preguntas_simulacion = Tb_avances_legal::where('tb_avances_legal.idUsuario','=',$idUsuario)
            ->orderBy('tb_avances_legal.id','asc')
            ->get();

            foreach($preguntas_simulacion as $vueltaP){
                $max_preguntas_simulacion = $vueltaP->next;
                }
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
        $idPregunta=$request->idP;

        $pregunta_simulacion=Tb_preguntas_legal::where('tb_preguntas_legal.id','=',$idPregunta)->get();

        return [
            'estado' => 'Ok',
            'pregunta_simulacion' => $pregunta_simulacion
        ];
    }

    public function guardarPregunta($idExterno, $cadenaP, $next, $idUsuario){
        $tb_avpreg_legal=new Tb_avances_legal();
        $tb_avpreg_legal->idExterno=$idExterno;
        $tb_avpreg_legal->cadena=$cadenaP;
        $tb_avpreg_legal->pregunta=1;
        $tb_avpreg_legal->enunciado=0;
        $tb_avpreg_legal->enlace=0;
        $tb_avpreg_legal->next=$next;
        $tb_avpreg_legal->idUsuario=$idUsuario;
        $tb_avpreg_legal->estado=1;
        $tb_avpreg_legal->save();
    }

    public function guardarEnunciado($idExterno, $cadenaE, $next, $idUsuario){
        $tb_avenun_legal=new Tb_avances_legal();
        $tb_avenun_legal->idExterno=$idExterno;
        $tb_avenun_legal->cadena=$cadenaE;
        $tb_avenun_legal->pregunta=0;
        $tb_avenun_legal->enunciado=1;
        $tb_avenun_legal->enlace=0;
        $tb_avenun_legal->next=$next;
        $tb_avenun_legal->idUsuario=$idUsuario;
        $tb_avenun_legal->estado=1;
        $tb_avenun_legal->save();
    }

    public function guardarEnlace($idExterno, $cadenaEn, $next, $idUsuario){
        $tb_avenla_legal=new Tb_avances_legal();
        $tb_avenla_legal->idExterno=$idExterno;
        $tb_avenla_legal->cadena=$cadenaEn;
        $tb_avenla_legal->pregunta=0;
        $tb_avenla_legal->enunciado=0;
        $tb_avenla_legal->enlace=1;
        $tb_avenla_legal->next=$next;
        $tb_avenla_legal->idUsuario=$idUsuario;
        $tb_avenla_legal->estado=1;
        $tb_avenla_legal->save();
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
                            $next_question=2;
                            $this->guardarPregunta(1, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si  si pregunta es 1 y entra por no'
                        try {
                            $next_question=2;
                            $this->guardarPregunta(1, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',1)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(1, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        // Código a ejecutar si pregunta es 2 y entra por si'
                        try {
                            $next_question=3;
                            $this->guardarPregunta(2, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si pregunta es 2 y entra por no'
                        try {
                            $next_question=3;
                            $this->guardarPregunta(2, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',2)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(2, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        // Código a ejecutar si pregunta es 3 y entra por si'
                        try {
                            $next_question=5;
                            $this->guardarPregunta(3, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',3)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(3, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',6)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(6, $cadenaE, $next_question, $idUsuario);

                            $enlace_simulacion=Tb_enlaces_legal::where('tb_enlaces_legal.id','=',1)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }

                            $this->guardarEnlace(1, $cadenaEn, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si pregunta es 3 y entra por no'
                        try {
                            $next_question=4;
                            $this->guardarPregunta(3, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=5;
                            $this->guardarPregunta(4, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',4)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(4, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',6)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(6, $cadenaE, $next_question, $idUsuario);

                            $enlace_simulacion=Tb_enlaces_legal::where('tb_enlaces_legal.id','=',1)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }

                            $this->guardarEnlace(5, $cadenaEn, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=5;
                            $this->guardarPregunta(4, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',5)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(5, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',6)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarPregunta(6, $cadenaE, $next_question, $idUsuario);

                            $enlace_simulacion=Tb_enlaces_legal::where('tb_enlaces_legal.id','=',1)->get();

                            foreach($enlace_simulacion as $vueltaEn){
                                $cadenaEn = $vueltaEn->enlace;
                                }
                            $this->guardarEnlace(1, $cadenaEn, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                            $next_question=6;
                            $this->guardarPregunta(5, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=6;
                            $this->guardarPregunta(5, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',7)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(7, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                            $next_question=9;
                            $this->guardarPregunta(6, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=7;
                            $this->guardarPregunta(6, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                            $next_question=8;
                            $this->guardarPregunta(7, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=16;
                            $this->guardarPregunta(7, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',8)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(8, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=17;
                            $this->guardarPregunta(8, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',9)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(9, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=17;
                            $this->guardarPregunta(8, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',10)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(10, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=11;
                            $this->guardarPregunta(9, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',12)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(12, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=10;
                            $this->guardarPregunta(9, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',11)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                            $this->guardarEnunciado(11, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=17;
                            $this->guardarPregunta(10, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',15)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(15, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=12;
                            $this->guardarPregunta(10, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                            $next_question=13;
                            $this->guardarPregunta(11, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=17;
                            $this->guardarPregunta(11, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',17)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(17, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=17;
                            $this->guardarPregunta(12, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',13)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(13, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=17;
                            $this->guardarPregunta(12, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',14)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(14, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                            $next_question=14;
                            $this->guardarPregunta(13, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=17;
                            $this->guardarPregunta(13, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',16)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(16, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=17;
                            $this->guardarPregunta(14, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',16)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(16, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=15;
                            $this->guardarPregunta(14, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=17;
                            $this->guardarPregunta(15, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',18)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(18, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=17;
                            $this->guardarPregunta(15, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',16)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(16, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=20;
                            $this->guardarPregunta(16, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',21)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(21, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=18;
                            $this->guardarPregunta(16, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',19)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(19, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=21;
                            $this->guardarPregunta(17, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',22)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(22, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=19;
                            $this->guardarPregunta(17, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',20)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(20, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=20;
                            $this->guardarPregunta(18, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',25)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(25, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=20;
                            $this->guardarPregunta(18, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',23)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(23, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=21;
                            $this->guardarPregunta(19, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',26)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(26, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=21;
                            $this->guardarPregunta(19, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',24)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(24, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                            $next_question=22;
                            $this->guardarPregunta(20, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=22;
                            $this->guardarPregunta(20, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',27)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(27, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                            $next_question=23;
                            $this->guardarPregunta(21, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=23;
                            $this->guardarPregunta(21, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',28)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(28, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=32;
                            $this->guardarPregunta(22, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',29)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(29, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=24;
                            $this->guardarPregunta(22, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=26;
                            $this->guardarPregunta(23, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',30)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(30, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',35)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(35, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',36)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(36, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=25;
                            $this->guardarPregunta(23, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=32;
                            $this->guardarPregunta(24, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',33)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(33, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=32;
                            $this->guardarPregunta(24, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',31)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(31, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=26;
                            $this->guardarPregunta(25, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',34)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(34, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',35)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(35, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',36)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(36, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=26;
                            $this->guardarPregunta(25, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',32)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(32, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',35)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(35, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',36)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(36, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                            $next_question=27;
                            $this->guardarPregunta(26, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=28;
                            $this->guardarPregunta(26, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',38)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(38, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',39)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(39, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',40)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(40, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=28;
                            $this->guardarPregunta(27, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',38)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(38, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',39)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(39, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',40)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(40, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=28;
                            $this->guardarPregunta(27, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',37)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(37, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',38)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(38, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',39)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(39, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',40)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(40, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=32;
                            $this->guardarPregunta(28, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',41)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(41, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',42)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(42, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=29;
                            $this->guardarPregunta(28, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=32;
                            $this->guardarPregunta(29, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',41)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(41, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',42)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(42, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=30;
                            $this->guardarPregunta(29, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                        try {
                            $next_question=32;
                            $this->guardarPregunta(30, $cadenaP, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',41)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(41, $cadenaE, $next_question, $idUsuario);

                            $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',42)->get();

                            foreach($enunciado_simulacion as $vueltaE){
                            $cadenaE = $vueltaE->enunciado;
                            }

                            $this->guardarEnunciado(42, $cadenaE, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                        }
                        break;
                    case '2':
                        // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                        try {
                            $next_question=31;
                            $this->guardarPregunta(30, $cadenaP, $next_question, $idUsuario);

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => $next_question
                               ]);
                        } catch (\Exception $e) {
                            return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                            try {
                                $next_question=32;
                                $this->guardarPregunta(31, $cadenaP, $next_question, $idUsuario);

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',41)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $this->guardarEnunciado(41, $cadenaE, $next_question, $idUsuario);

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',42)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $this->guardarEnunciado(42, $cadenaE, $next_question, $idUsuario);

                                return response()->json([
                                    'estado' => 'Ok',
                                    'message' => $next_question
                                   ]);
                            } catch (\Exception $e) {
                                return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                            }
                            break;
                        case '2':
                            // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                            try {
                                $next_question=32;
                                $this->guardarPregunta(31, $cadenaP, $next_question, $idUsuario);

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',43)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $this->guardarEnunciado(43, $cadenaE, $next_question, $idUsuario);

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',44)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $this->guardarEnunciado(44, $cadenaE, $next_question, $idUsuario);

                                return response()->json([
                                    'estado' => 'Ok',
                                    'message' => $next_question
                                   ]);
                            } catch (\Exception $e) {
                                return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
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
                            try {
                                $next_question=99;
                                $this->guardarPregunta(32, $cadenaP, $next_question, $idUsuario);

                                $enunciado_simulacion=Tb_enunciados_legal::where('tb_enunciados_legal.id','=',45)->get();

                                foreach($enunciado_simulacion as $vueltaE){
                                $cadenaE = $vueltaE->enunciado;
                                }

                                $this->guardarEnunciado(45, $cadenaE, $next_question, $idUsuario);

                                return response()->json([
                                    'estado' => 'Ok',
                                    'message' => $next_question
                                   ]);
                            } catch (\Exception $e) {
                                return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                            }
                            break;
                        case '2':
                            // Código a ejecutar si $variable1 es 'valor1' y $variable2 es 'valorB'
                                try {
                                    $next_question=99;
                                    $this->guardarPregunta(32, $cadenaP, $next_question, $idUsuario);

                                    return response()->json([
                                        'estado' => 'Ok',
                                        'message' => $next_question
                                       ]);
                                } catch (\Exception $e) {
                                    return response()->json(['error' => 'Ocurrió un error interno'.$e], 500);
                                }
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
