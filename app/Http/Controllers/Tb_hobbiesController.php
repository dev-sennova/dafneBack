<?php

namespace App\Http\Controllers;

use App\Models\Tb_hobbies;
use App\Models\Tb_usuario_hobbies;
use App\Models\Tb_usuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\PendingModeration;
use Illuminate\Support\Facades\Mail;


class Tb_hobbiesController extends Controller
{
    public function index(Request $request)
    {
        $hobbies = Tb_hobbies::orderBy('id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'hobbies' => $hobbies
        ];
    }

    public function indexGeneral(Request $request)
    {
        $hobbies = Tb_hobbies::orderBy('id','asc')
        ->where('tb_hobbies.visibilidad','=','1')
        ->where('tb_hobbies.moderacion','<','2')
        ->select('tb_hobbies.id','tb_hobbies.hobby','tb_hobbies.moderacion')
        ->get();

        return [
            'estado' => 'Ok',
            'hobbies' => $hobbies
        ];
    }

    public function indexPropio(Request $request)
    {
        //Modelo::join('tablaqueseune',basicamente un on)
        $hobbies = Tb_hobbies::join('tb_usuario_hobbies','tb_hobbies.id','=','tb_usuario_hobbies.idHobby')
        ->where('tb_hobbies.visibilidad','=','2')
        ->where('tb_hobbies.moderacion','<','2')
        ->where('tb_usuario_hobbies.idUsuario','=',$request->id)
        ->select('tb_hobbies.id','tb_hobbies.hobby','tb_hobbies.moderacion')
        ->orderBy('tb_hobbies.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'hobbies' => $hobbies
        ];
    }

    public function indexOne(Request $request)
    {
        $hobbies = Tb_hobbies::orderBy('id','desc')
        ->where('tb_hobbies.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'hobbies' => $hobbies
        ];
    }

    public function store(Request $request)
    {
        try {
            $tb_hobbies = new Tb_hobbies();
            $tb_hobbies->hobby = $request->hobby;
            $tb_hobbies->visibilidad = 2;
            $tb_hobbies->moderacion = 0;
            $tb_hobbies->estado = 1;
            $tb_hobbies->created_at = Carbon::now();

            if ($tb_hobbies->save()) {

                $idHobbyRecienGuardado = $tb_hobbies->id;

                $tb_usuario_hobbies = new Tb_usuario_hobbies();
                $tb_usuario_hobbies->idUsuario = $request->idUsuario;
                $tb_usuario_hobbies->idHobby = $idHobbyRecienGuardado;

                if ($tb_usuario_hobbies->save()) {
                    $usuario = User::find($request->idUsuario);
                    $usuarioNombre = Tb_usuario::find($request->idUsuario);

                    if ($usuario) {
                        $nombre = $usuarioNombre ? $usuarioNombre->nombre : 'Usuario desconocido';
                        $gestor = User::find($usuario->gestor);
                        if ($gestor) {
                            $email = $gestor->email;

                            // Enviar correo al orientador (gestor)
                            $type = 'Nuevo hobbie';
                            $description = $tb_hobbies->hobby;
                            $createdAt = $tb_hobbies->created_at;
                            $expiresAt = $createdAt->copy()->addHours(12);

                            Mail::to($email)->send(new PendingModeration($type, $description, $createdAt, $expiresAt, $nombre));

                            return response()->json([
                                'estado' => 'Ok',
                                'message' => 'Hobbie creado con éxito'
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
                        'message' => 'Usuario_hobbies no pudo ser creado'
                    ]);
                }
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hobbie no pudo ser creado'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_hobbies=Tb_hobbies::findOrFail($request->id);
            $tb_hobbies->hobby=$request->hobby;
            $tb_hobbies->visibilidad=$request->visibilidad;
            $tb_hobbies->moderacion=$request->moderacion;
            $tb_hobbies->estado='1';

            if ($tb_hobbies->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Hobbies actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hobbies no pudo ser actualizado'
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
            $tb_hobbies=Tb_hobbies::findOrFail($request->id);
            $tb_hobbies->estado='0';

            if ($tb_hobbies->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Hobbies desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hobbies no pudo ser desactivado'
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
            $tb_hobbies=Tb_hobbies::findOrFail($request->id);
            $tb_hobbies->estado='1';

            if ($tb_hobbies->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Hobbies activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hobbies no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
