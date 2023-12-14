<?php

namespace App\Http\Controllers;

use App\Models\Tb_formalizacion_persona;
use Illuminate\Http\Request;

class Tb_formalizacion_personaController extends Controller
{
    public function index(Request $request)
    {
        $formalizacion_persona = Tb_formalizacion_persona::orderBy('tb_formalizacion_persona.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'formalizacion_persona' => $formalizacion_persona
        ];
    }

    public function indexOne(Request $request)
    {
        $formalizacion_persona = Tb_formalizacion_persona::orderBy('tb_formalizacion_persona.id','desc')
        ->where('tb_formalizacion_persona.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'formalizacion_persona' => $formalizacion_persona
        ];
    }

    public function indexPropio(Request $request)
    {
        $formalizacion_persona = Tb_formalizacion_persona::orderBy('tb_formalizacion_persona.id','asc')
        ->where('tb_formalizacion_persona.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'formalizacion_persona' => $formalizacion_persona
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_formalizacion_persona=new Tb_formalizacion_persona();
            $tb_formalizacion_persona->idUsuario=$request->idUsuario;
            $tb_formalizacion_persona->estado=1;
            /*
            $tb_formalizacion_persona=new Tb_formalizacion_persona();
            $tb_formalizacion_persona->nombre=$request->nombre;
            $tb_formalizacion_persona->marca=$request->marca;
            $tb_formalizacion_persona->codigoCiiu=$request->codigoCiiu;
            $tb_formalizacion_persona->usoDeSuelo=$request->usoDeSuelo;
            $tb_formalizacion_persona->direccion=$request->direccion;
            $tb_formalizacion_persona->rut=$request->rut;
            $tb_formalizacion_persona->rues=$request->rues;
            $tb_formalizacion_persona->sayco=$request->sayco;
            $tb_formalizacion_persona->bomberil=$request->bomberil;
            $tb_formalizacion_persona->placa=$request->placa;
            $tb_formalizacion_persona->seguridad=$request->seguridad;
            $tb_formalizacion_persona->afiliacion=$request->afiliacion;
            $tb_formalizacion_persona->idUsuario=$request->idUsuario;
            $tb_formalizacion_persona->estado=1;
            */

            if ($tb_formalizacion_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'formalizacion persona creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'formalizacion persona no pudo ser creada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno: '+$e], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_formalizacion_persona=Tb_formalizacion_persona::findOrFail($request->id);
            $tb_formalizacion_persona->nombre=$request->nombre;
            $tb_formalizacion_persona->marca=$request->marca;
            $tb_formalizacion_persona->codigoCiiu=$request->codigoCiiu;
            $tb_formalizacion_persona->usoDeSuelo=$request->usoDeSuelo;
            $tb_formalizacion_persona->direccion=$request->direccion;
            $tb_formalizacion_persona->rut=$request->rut;
            $tb_formalizacion_persona->rues=$request->rues;
            $tb_formalizacion_persona->sayco=$request->sayco;
            $tb_formalizacion_persona->bomberil=$request->bomberil;
            $tb_formalizacion_persona->placa=$request->placa;
            $tb_formalizacion_persona->seguridad=$request->seguridad;
            $tb_formalizacion_persona->afiliacion=$request->afiliacion;
            $tb_formalizacion_persona->pasosAvance=$request->pasosAvance;
            $tb_formalizacion_persona->idUsuario=$request->idUsuario;
            $tb_formalizacion_persona->estado=1;

            if ($tb_formalizacion_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'formalizacion persona actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'formalizacion persona no pudo ser actualizada'
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
            $tb_formalizacion_persona=Tb_formalizacion_persona::findOrFail($request->id);
            $tb_formalizacion_persona->estado='0';

            if ($tb_formalizacion_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'formalizacion persona desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'formalizacion persona no pudo ser desactivada'
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
            $tb_formalizacion_persona=Tb_formalizacion_persona::findOrFail($request->id);
            $tb_formalizacion_persona->estado='1';

            if ($tb_formalizacion_persona->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'formalizacion persona activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'formalizacion persona no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
