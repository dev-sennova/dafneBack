<?php

namespace App\Http\Controllers;

use App\Models\Tb_ideas;
use App\Models\Tb_usuario_ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Tb_usuario;
use App\Mail\PendingModeration;
use Illuminate\Support\Facades\Mail;


class Tb_ideasController extends Controller
{
    public function index(Request $request)
    {
        $ideas = Tb_ideas::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'ideas' => $ideas
        ];
    }

    public function indexGeneral(Request $request)
    {
        $ideas = Tb_ideas::orderBy('id','asc')
        ->where('tb_ideas.visibilidad','=','1')
        ->where('tb_ideas.moderacion','<','2')
        ->select('tb_ideas.id','tb_ideas.idea','tb_ideas.moderacion')
        ->get();

        return [
            'estado' => 'Ok',
            'ideas' => $ideas
        ];
    }

    public function indexOne(Request $request)
    {
        $ideas = Tb_ideas::orderBy('id','desc')
        ->where('tb_ideas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'ideas' => $ideas
        ];
    }

    public function indexPropio(Request $request)
    {
        //Modelo::join('tablaqueseune',basicamente un on)
        $ideas = Tb_ideas::join('tb_usuario_ideas','tb_ideas.id','=','tb_usuario_ideas.idideas')
        ->where('tb_ideas.visibilidad','=','2')
        ->where('tb_ideas.moderacion','<','2')
        ->where('tb_usuario_ideas.idUsuario','=',$request->id)
        ->select('tb_ideas.id','tb_ideas.idea','tb_ideas.moderacion')
        ->orderBy('tb_ideas.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'ideas' => $ideas
        ];
    }

    public function store(Request $request)
    {
        try {
            $tb_ideas = new Tb_ideas();
            $tb_ideas->idea = $request->idea;
            $tb_ideas->visibilidad = 2;
            $tb_ideas->moderacion = 0;
            $tb_ideas->estado = 1;
            $tb_ideas->created_at = Carbon::now();

            if ($tb_ideas->save()) {
                $idIdeaRecienGuardado = $tb_ideas->id;

                $tb_usuario_ideas = new Tb_usuario_ideas();
                $tb_usuario_ideas->idUsuario = $request->idUsuario;
                $tb_usuario_ideas->idideas = $idIdeaRecienGuardado;
                $tb_usuario_ideas->save();

                $usuario = User::find($request->idUsuario);
                $usuarioNombre = Tb_usuario::find($request->idUsuario);

                if ($usuario) {
                    $nombre = $usuarioNombre->nombre;
                    $gestor = User::find($usuario->gestor);
                    if ($gestor) {
                        $email = $gestor->email;

                        $type = 'Nueva idea';
                        $description = $tb_ideas->idea;
                        $createdAt = $tb_ideas->created_at;
                        $expiresAt = $createdAt->copy()->addHours(12);

                        Mail::to($email)->send(new PendingModeration($type, $description, $createdAt, $expiresAt, $nombre));

                        return response()->json([
                            'estado' => 'Ok',
                            'message' => 'Idea creada con éxito'
                        ]);
                    } else {
                        return response()->json(['error' => 'Gestor no encontrado'], 500);
                    }
                } else {
                    // Manejar el caso donde el usuario no se encuentra
                    return response()->json(['error' => 'Usuario no encontrado'], 500);
                }
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Idea no pudo ser creada'
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
            $tb_ideas=Tb_ideas::findOrFail($request->id);
            $tb_ideas->ideas=$request->idea;
            $tb_ideas->visibilidad=$request->visibilidad;
            $tb_ideas->moderacion=$request->moderacion;
            $tb_ideas->estado='1';

            if ($tb_ideas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Idea actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Idea no pudo ser actualizada'
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
            $tb_ideas=Tb_ideas::findOrFail($request->id);
            $tb_ideas->estado='0';

            if ($tb_ideas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Idea desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Idea no pudo ser desactivada'
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
            $tb_ideas=Tb_ideas::findOrFail($request->id);
            $tb_ideas->estado='1';

            if ($tb_ideas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Ideas activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ideas no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
