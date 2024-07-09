<?php

namespace App\Http\Controllers;

use App\Models\Tb_criterios;
use App\Models\Tb_usuario_criterios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Tb_usuario;
use App\Mail\PendingModeration;
use Illuminate\Support\Facades\Mail;

class Tb_criteriosController extends Controller
{
    public function index(Request $request)
    {
        $criterios = Tb_criterios::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'criterios' => $criterios
        ];
    }

    public function indexGeneral(Request $request)
    {
        $criterios = Tb_criterios::orderBy('id','asc')
        ->where('tb_criterios.visibilidad','=','1')
        ->where('tb_criterios.moderacion','<','2')
        ->select('tb_criterios.id','tb_criterios.criterio','tb_criterios.moderacion')
        ->get();

        return [
            'estado' => 'Ok',
            'criterios' => $criterios
        ];
    }

    public function indexOne(Request $request)
    {
        $criterios = Tb_criterios::orderBy('id','desc')
        ->where('tb_criterios.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'criterios' => $criterios
        ];
    }

    public function indexPropio(Request $request)
    {
        //Modelo::join('tablaqueseune',basicamente un on)
        $criterios = Tb_criterios::join('tb_usuario_criterios','tb_criterios.id','=','tb_usuario_criterios.idCriterio')
        ->where('tb_criterios.visibilidad','=','2')
        ->where('tb_criterios.moderacion','<','2')
        ->where('tb_usuario_criterios.idUsuario','=',$request->id)
        ->select('tb_criterios.id','tb_criterios.criterio','tb_criterios.moderacion')
        ->orderBy('tb_criterios.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'criterios' => $criterios
        ];
    }

    public function store(Request $request)
    {
        try {
            $tb_criterios = new Tb_criterios();
            $tb_criterios->criterio = $request->criterio;
            $tb_criterios->pregunta = $request->pregunta;
            $tb_criterios->visibilidad = 2;
            $tb_criterios->moderacion = 0;
            $tb_criterios->estado = 1;
            $tb_criterios->created_at = Carbon::now();

            if ($tb_criterios->save()) {
                $idCriterioRecienGuardado = $tb_criterios->id;

                $tb_usuario_criterios = new Tb_usuario_criterios();
                $tb_usuario_criterios->idUsuario = $request->idUsuario;
                $tb_usuario_criterios->idCriterio = $idCriterioRecienGuardado;
                $tb_usuario_criterios->save();

                $usuario = User::find($request->idUsuario);
                $usuarioNombre = Tb_usuario::find($request->idUsuario);

                if ($usuario) {
                    $nombre = $usuarioNombre->nombre;
                    $gestor = User::find($usuario->gestor);
                    if ($gestor) {
                        $email = $gestor->email;

                        $type = 'Nuevo criterio';
                        $description = $tb_criterios->criterio;
                        $createdAt = $tb_criterios->created_at;
                        $expiresAt = $createdAt->copy()->addHours(12);

                        Mail::to($email)->send(new PendingModeration($type, $description, $createdAt, $expiresAt, $nombre));

                        return response()->json([
                            'estado' => 'Ok',
                            'message' => 'Criterio creado con éxito'
                        ]);
                    } else {
                        return response()->json(['error' => 'Gestor no encontrado'], 500);
                    }
                } else {
                    return response()->json(['error' => 'Usuario no encontrado'], 500);
                }
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Criterio no pudo ser creado'
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
            $tb_criterios=Tb_criterios::findOrFail($request->id);
            $tb_criterios->criterios=$request->criterio;
            $tb_criterios->pregunta=$request->pregunta;
            $tb_criterios->visibilidad=$request->visibilidad;
            $tb_criterios->moderacion=$request->moderacion;
            $tb_criterios->estado='1';

            if ($tb_criterios->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Criterio actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Criterio no pudo ser actualizado'
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
            $tb_criterios=Tb_criterios::findOrFail($request->id);
            $tb_criterios->estado='0';

            if ($tb_criterios->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Criterio desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Criterio no pudo ser desactivado'
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
            $tb_criterios=Tb_criterios::findOrFail($request->id);
            $tb_criterios->estado='1';

            if ($tb_criterios->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Criterio activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Criterio no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
