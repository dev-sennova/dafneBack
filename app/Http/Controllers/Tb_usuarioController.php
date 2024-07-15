<?php

namespace App\Http\Controllers;

use App\Models\Tb_usuario;
use App\Models\Tb_ciudad;
use App\Models\Tb_departamento;
use App\Models\Tb_usuario_rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Tb_usuarioController extends Controller
{
    public function index(Request $request)
    {
        $users = Tb_usuario::orderBy('id','desc')
        ->get();

        return [
            'estado' => 'Ok',
            'users' => $users
        ];
    }

    public function indexOne(Request $request)
    {
        $user = Tb_usuario::find($request->id);
    
        if ($user) {
            $ciudad = null;
            $departamento = null;
    
            if ($user->ciudad) {
                $ciudad = Tb_ciudad::find($user->ciudad);
                if ($ciudad) {
                    $departamento = Tb_departamento::find($ciudad->departamento_id);
                }
            }
    
            return [
                'estado' => 'Ok',
                'user' => $user,
                'ciudad' => $ciudad,
                'departamento' => $departamento
            ];
        }
    
        return [
            'estado' => 'Error',
            'message' => 'Usuario no encontrado'
        ];
    }
    


    public function indexUser(Request $request)
    {
        $users = Tb_usuario::orderBy('id','desc')
        ->where('tb_usuario.email','=',$request->id)
        ->select('tb_usuario.id')
        ->get();

        return [
            'estado' => 'Ok',
            'users' => $users
        ];
    }

    public function indexIdUser(Request $request)
    {
        $cadenaE=0;

        $users = Tb_usuario::orderBy('id','desc')
        ->where('tb_usuario.email','=',$request->id)
        ->select('tb_usuario.id')
        ->get();

        foreach($users as $vueltaE){
            $cadenaE = $vueltaE->id;
            }

        return [
            'idUsuario' => $cadenaE
        ];
    }

    public function store(Request $request)
    {
        try {
            $tb_usuario = new Tb_usuario();
            $tb_usuario->id = $request->id;
            $tb_usuario->nombre = $request->nombre;
            $tb_usuario->tipodocumento = $request->tipodocumento;
            $tb_usuario->documento = $request->documento;
            $tb_usuario->direccion = $request->direccion;
            $tb_usuario->telefono = $request->telefono;
            $tb_usuario->email = $request->email;
            $tb_usuario->ciudad = $request->ciudad;
            $tb_usuario->sexo = $request->sexo;
            $tb_usuario->estado = 1;
    
            if ($tb_usuario->save()) {
                $tb_usuario_rol = new Tb_usuario_rol();
                $tb_usuario_rol->idUsuario = $request->id;
                $tb_usuario_rol->idRol = $request->idRol;
                $tb_usuario_rol->save();
    
                return response()->json([
                    'estado' => 'Ok',
                    'idUsuario' => $tb_usuario->id, // Utilizar $tb_usuario->id directamente
                    'message' => 'Usuario creado con éxito'
                ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario no pudo ser creado'
                ]);
            }
        } catch (\Exception $e) {
            // Loguear el mensaje de error para debugging
            \Log::error('Error en store(): ' . $e->getMessage());
    
            return response()->json([
                'error' => 'Ocurrió un error interno. Detalles en los logs del servidor.'
            ], 500);
        }
    }
    

    public function update(Request $request)
    {
        try {
            $tb_usuario = Tb_usuario::findOrFail($request->id);
            $tb_usuario->nombre = $request->nombre;
            $tb_usuario->tipodocumento = $request->tipodocumento;
            $tb_usuario->documento = $request->documento;
            $tb_usuario->direccion = $request->direccion;
            $tb_usuario->telefono = $request->telefono;
            $tb_usuario->email = $request->email;
            $tb_usuario->ciudad = $request->ciudad;
            $tb_usuario->sexo = $request->sexo;

            if ($tb_usuario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario actualizado con éxito'
                ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario no pudo ser actualizado'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }


    public function deactivate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_usuario=Tb_usuario::findOrFail($request->id);
            $tb_usuario->estado='0';

            if ($tb_usuario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario no pudo ser desactivado'
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
            $tb_usuario=Tb_usuario::findOrFail($request->id);
            $tb_usuario->estado='1';

            if ($tb_usuario->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Usuario activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Usuario no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function indexGestor(Request $request)
    {
        $users = User::whereNotIn('rol', [1]) 
                     ->orderBy('id', 'asc')
                     ->get();
    
        return [
            'estado' => 'Ok',
            'users' => $users
        ];
    }
    

    public function indexPendientes(Request $request)
    {
        $users = Tb_usuario::orderBy('id','asc')
        ->where('id','=',$request->idUsuario)
        ->get();

        return [
            'estado' => 'Ok',
            'users' => $users
        ];
    }

    public function countUsuario(Request $request)
    {
        $users = Tb_usuario::orderBy('id','asc')
        ->where('id','=',$request->idUsuario)
        ->count();

        return [
            'estado' => 'Ok',
            'users' => $users
        ];
    }

    public function indexOrientadores(Request $request)
    {
        $users = User::where('rol', 2)->orderBy('id', 'desc')->get();

        return response()->json([
            'estado' => 'Ok',
            'users' => $users
        ]);
    }

    public function cambiarGestor(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'gestorId' => 'required|exists:users,id'
        ]);

        // Buscar el usuario por ID
        $user = User::findOrFail($id);

        // Actualizar el campo gestorId
        $user->gestor = $request->input('gestorId');
        $user->save();

        return response()->json([
            'message' => 'Gestor cambiado correctamente'
        ]);
    }

    public function indexUsuarioGestor(Request $request){
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

}
