<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Tb_usuario;
use App\Models\Tb_hobbies;
use App\Models\Tb_suenos;
use App\Models\Tb_ideas;
use App\Models\Tb_criterios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrientadorController extends Controller
{

    public function getGestorByUserId(Request $request)
    {
        try {
            $IdGestor = Auth::user()->gestor;

            $gestor = Tb_usuario::findOrFail($IdGestor);

            if ($gestor) {
                $ciudad = DB::table('Tb_ciudad')->where('id', $gestor->ciudad)->first();

                $response = [
                    'id' => $gestor->id,
                    'nombre' => $gestor->nombre,
                    'tipodocumento' => $gestor->tipodocumento,
                    'documento' => $gestor->documento,
                    'direccion' => $gestor->direccion,
                    'telefono' => $gestor->telefono,
                    'ciudad' => $ciudad ? $ciudad->ciudad : null,
                    'email' => $gestor->email,
                    'sexo' => $gestor->sexo,
                    'estado' => $gestor->estado
                ];

                return response()->json([
                    'estado' => 'Ok',
                    'gestor' => $response
                ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Gestor no encontrado'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error al obtener el gestor: ' . $e->getMessage());

            return response()->json([
                'estado' => 'Error',
                'message' => 'Ocurrió un error interno. Detalles en los logs del servidor.'
            ], 500);
        }
    }



    public function indexUsuarioGestor(Request $request)
    {
        $orientadorId = Auth::user()->id;
        
        // Obtener los emprendedores asociados al orientador logueado
        $users = User::where('rol', 3)  
                     ->where('gestor', $orientadorId)
                     ->orderBy('id', 'asc')
                     ->get();
        
        return response()->json([
            'estado' => 'Ok',
            'emprendedores' => $users
        ]);
    }

    public function getHobbiesDeUsuariosGestionados()
    {
        $gestor = Auth::user();
    
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }
    
        $usuariosGestionadosIds = User::where('gestor', $gestor->id)->pluck('id');
    
        $hobbiesIniciales = Tb_hobbies::where('moderacion', 1)->get();
    
        $usuarioHobbies = DB::table('tb_usuario_hobbies')
            ->whereIn('idUsuario', $usuariosGestionadosIds)
            ->where('tb_usuario_hobbies.estado', 0) // Calificar la columna estado con el nombre de la tabla
            ->join('tb_hobbies', 'tb_usuario_hobbies.idHobby', '=', 'tb_hobbies.id')
            ->select('tb_usuario_hobbies.*', 'tb_hobbies.*')
            ->get();
    
        return response()->json([
            'gestor' => $gestor->name,
            'hobbiesIniciales' => $hobbiesIniciales,
            'usuarioHobbies' => $usuarioHobbies
        ], 200);
    }

    public function actualizarEstadoHobby(Request $request, $idHobby)
    {
        $gestor = Auth::user();
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }
    
        $hobby = Tb_hobbies::find($idHobby);
        if (!$hobby) {
            return response()->json(['message' => 'No se encontró el hobby'], 404);
        }
    
        $hobby->update([
            'visibilidad' => 1,
            'moderacion' => 1
        ]);
    
        DB::table('tb_usuario_hobbies')->where('idHobby', $idHobby)->where('estado',0)->delete();
    
        return response()->json(['message' => 'Hobby actualizado y registros de usuario hobby eliminados correctamente'], 200);
    }

    public function eliminarHobby(Request $request, $idHobby)
    {
        $gestor = Auth::user();
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $hobby = Tb_hobbies::find($idHobby);
        if (!$hobby) {
            return response()->json(['message' => 'No se encontró el hobbie'], 404);
        }

        DB::table('tb_usuario_hobbies')->where('idHobby', $idHobby)->delete();

        $hobby->delete();

        return response()->json(['message' => 'Hobbie y registros de usuario hobby eliminados correctamente'], 200);
    }

    public function getSuenosDeUsuariosGestionados()
    {
        $gestor = Auth::user();
    
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }
    
        $usuariosGestionadosIds = User::where('gestor', $gestor->id)->pluck('id');
    
        $suenosIniciales = Tb_suenos::where('moderacion', 1)->get();
    
        $usuarioSuenos = DB::table('tb_usuario_suenos')
            ->whereIn('idUsuario', $usuariosGestionadosIds)
            ->where('tb_usuario_suenos.estado', 0) // Calificar la columna estado con el nombre de la tabla
            ->join('tb_suenos', 'tb_usuario_suenos.idSueno', '=', 'tb_suenos.id')
            ->select('tb_usuario_suenos.*', 'tb_suenos.*')
            ->get();
    
        return response()->json([
            'gestor' => $gestor->name,
            'suenosIniciales' => $suenosIniciales,
            'usuarioSuenos' => $usuarioSuenos
        ], 200);
    }

    public function actualizarEstadoSueno(Request $request, $idSueno)
    {
        $gestor = Auth::user();
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }
    
        $sueno = Tb_suenos::find($idSueno);
        if (!$sueno) {
            return response()->json(['message' => 'No se encontró el sueño'], 404);
        }
    
        $sueno->update([
            'visibilidad' => 1,
            'moderacion' => 1
        ]);
    
        DB::table('tb_usuario_suenos')->where('idSueno', $idSueno)->where('estado',0)->delete();
    
        return response()->json(['message' => 'Sueño actualizado y registros de usuario Sueño eliminados correctamente'], 200);
    }

    public function eliminarSueno(Request $request, $idSueno)
    {
        $gestor = Auth::user();
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $sueno = Tb_suenos::find($idSueno);
        if (!$sueno) {
            return response()->json(['message' => 'No se encontró el sueño'], 404);
        }

        DB::table('tb_usuario_suenos')->where('idSueno', $idSueno)->delete();

        $sueno->delete();

        return response()->json(['message' => 'Sueño y registros de usuario sueño eliminados correctamente'], 200);
    }

    public function getIdeasDeUsuariosGestionados()
    {
        $gestor = Auth::user();
    
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }
    
        $usuariosGestionadosIds = User::where('gestor', $gestor->id)->pluck('id');
    
        $ideasIniciales = Tb_ideas::where('moderacion', 1)->get();
    
        $usuarioIdeas = DB::table('tb_usuario_ideas')
            ->whereIn('idUsuario', $usuariosGestionadosIds)
            ->where('tb_usuario_ideas.estado', 0) // Calificar la columna estado con el nombre de la tabla
            ->join('tb_ideas', 'tb_usuario_ideas.idideas', '=', 'tb_ideas.id')
            ->select('tb_usuario_ideas.*', 'tb_ideas.*')
            ->get();
    
        return response()->json([
            'gestor' => $gestor->name,
            'ideasIniciales' => $ideasIniciales,
            'usuarioIdeas' => $usuarioIdeas
        ], 200);
    }

    public function actualizarEstadoIdea(Request $request, $idIdea)
    {
        $gestor = Auth::user();
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }
    
        $idea = Tb_ideas::find($idIdea);
        if (!$idea) {
            return response()->json(['message' => 'No se encontró la idea'], 404);
        }
    
        $idea->update([
            'visibilidad' => 1,
            'moderacion' => 1
        ]);
    
        DB::table('tb_usuario_ideas')->where('idideas', $idIdea)->where('estado',0)->delete();
    
        return response()->json(['message' => 'Idea actualizada y registros de usuario Idea eliminados correctamente'], 200);
    }

    public function eliminarIdea(Request $request, $idIdea)
    {
        $gestor = Auth::user();
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $idea = Tb_ideas::find($idIdea);
        if (!$idea) {
            return response()->json(['message' => 'No se encontró la idea'], 404);
        }

        DB::table('tb_usuario_ideas')->where('idideas', $idIdea)->delete();

        $idea->delete();

        return response()->json(['message' => 'Idea y registros de usuario sueño eliminados correctamente'], 200);
    }

    public function getCriteriosDeUsuariosGestionados()
    {
        $gestor = Auth::user();
    
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }
    
        $usuariosGestionadosIds = User::where('gestor', $gestor->id)->pluck('id');
    
        $criteriosIniciales = Tb_criterios::where('moderacion', 1)->get();
    
        $usuarioCriterios = DB::table('tb_usuario_criterios')
            ->whereIn('idUsuario', $usuariosGestionadosIds)
            ->where('tb_usuario_criterios.estado', 0) // Calificar la columna estado con el nombre de la tabla
            ->join('tb_criterios', 'tb_usuario_criterios.idCriterio', '=', 'tb_criterios.id')
            ->select('tb_usuario_criterios.*', 'tb_criterios.*')
            ->get();
    
        return response()->json([
            'gestor' => $gestor->name,
            'criteriosIniciales' => $criteriosIniciales,
            'usuarioCriterios' => $usuarioCriterios
        ], 200);
    }

    public function actualizarEstadoCriterio(Request $request, $idCriterio)
    {
        $gestor = Auth::user();
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }
    
        $criterio = Tb_criterios::find($idCriterio);
        if (!$criterio) {
            return response()->json(['message' => 'No se encontró el criterio'], 404);
        }
    
        $criterio->update([
            'visibilidad' => 1,
            'moderacion' => 1
        ]);
    
        DB::table('tb_usuario_criterios')->where('idCriterio', $idCriterio)->where('estado',0)->delete();
    
        return response()->json(['message' => 'Criterio actualizado y registros de usuario Criterio eliminados correctamente'], 200);
    }

    public function eliminarCriterio(Request $request, $idCriterio)
    {
        $gestor = Auth::user();
        if (!$gestor) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $criterio = Tb_criterios::find($idCriterio);
        if (!$criterio) {
            return response()->json(['message' => 'No se encontró el criterio'], 404);
        }

        DB::table('tb_usuario_criterios')->where('idCriterio', $idCriterio)->delete();

        $criterio->delete();

        return response()->json(['message' => 'Criterio y registros de usuario criterio eliminados correctamente'], 200);
    }

}
