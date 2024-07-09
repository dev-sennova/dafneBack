<?php

namespace App\Http\Controllers;

use App\Models\Tb_suenos;
use App\Models\Tb_usuario_suenos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Tb_usuario;
use App\Mail\PendingModeration;
use Illuminate\Support\Facades\Mail;


class Tb_suenosController extends Controller
{
    public function index(Request $request)
    {
        $suenos = Tb_suenos::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'suenos' => $suenos
        ];
    }

    public function indexGeneral(Request $request)
    {
        $suenos = Tb_suenos::orderBy('id','asc')
        ->where('tb_suenos.visibilidad','=','1')
        ->where('tb_suenos.moderacion','<','2')
        ->select('tb_suenos.id','tb_suenos.sueno','tb_suenos.moderacion')
        ->get();

        return [
            'estado' => 'Ok',
            'suenos' => $suenos
        ];
    }

    public function indexPropio(Request $request)
    {
        //Modelo::join('tablaqueseune',basicamente un on)
        $suenos = Tb_suenos::join('tb_usuario_suenos','tb_suenos.id','=','tb_usuario_suenos.idSueno')
        ->where('tb_suenos.visibilidad','=','2')
        ->where('tb_suenos.moderacion','<','2')
        ->where('tb_usuario_suenos.idUsuario','=',$request->id)
        ->select('tb_suenos.id','tb_suenos.sueno','tb_suenos.moderacion')
        ->orderBy('tb_suenos.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'suenos' => $suenos
        ];
    }

    public function indexOne(Request $request)
    {
        $suenos = Tb_suenos::orderBy('id','desc')
        ->where('tb_suenos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'suenos' => $suenos
        ];
    }

    public function store(Request $request)
    {
        try {
            $tb_suenos = new Tb_suenos();
            $tb_suenos->sueno = $request->sueno;
            $tb_suenos->visibilidad = 2;
            $tb_suenos->moderacion = 0;
            $tb_suenos->estado = 1;
            $tb_suenos->created_at = Carbon::now();

            if ($tb_suenos->save()) {
                $idSuenoRecienGuardado = $tb_suenos->id;

                $tb_usuario_suenos = new Tb_usuario_suenos();
                $tb_usuario_suenos->prioridad = 0;
                $tb_usuario_suenos->idUsuario = $request->idUsuario;
                $tb_usuario_suenos->idSueno = $idSuenoRecienGuardado;
                $tb_usuario_suenos->save();

                // Obtener el usuario que envía el sueño
                $usuario = User::find($request->idUsuario);
                $usuarioNombre = Tb_usuario::find($request->idUsuario);

                if ($usuario) {
                    $nombre = $usuarioNombre->nombre;
                    $gestor = User::find($usuario->gestor);
                    if ($gestor) {
                        $email = $gestor->email;

                        // Enviar correo al orientador (gestor)
                        $type = 'Nuevo sueño';
                        $description = $tb_suenos->sueno;
                        $createdAt = $tb_suenos->created_at;
                        $expiresAt = $createdAt->copy()->addHours(12);

                        Mail::to($email)->send(new PendingModeration($type, $description, $createdAt, $expiresAt, $nombre));

                        return response()->json([
                            'estado' => 'Ok',
                            'message' => 'Sueño creado con éxito'
                        ]);
                    } else {
                        // Manejar el caso donde el gestor no se encuentra
                        return response()->json(['error' => 'Gestor no encontrado'], 500);
                    }
                } else {
                    // Manejar el caso donde el usuario no se encuentra
                    return response()->json(['error' => 'Usuario no encontrado'], 500);
                }
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sueño no pudo ser creado'
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
            $tb_suenos=Tb_suenos::findOrFail($request->id);
            $tb_suenos->sueno=$request->sueno;
            $tb_suenos->visibilidad=$request->visibilidad;
            $tb_suenos->moderacion=$request->moderacion;
            $tb_suenos->estado='1';

            if ($tb_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sueños actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sueños no pudo ser actualizado'
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
            $tb_suenos=Tb_suenos::findOrFail($request->id);
            $tb_suenos->estado='0';

            if ($tb_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sueños desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sueños no pudo ser desactivado'
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
            $tb_suenos=Tb_suenos::findOrFail($request->id);
            $tb_suenos->estado='1';

            if ($tb_suenos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sueños activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sueños no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
