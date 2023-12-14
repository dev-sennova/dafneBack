<?php

namespace App\Http\Controllers;

use App\Models\Tb_formalizacion_empresa;
use Illuminate\Http\Request;

class Tb_formalizacion_empresaController extends Controller
{
    public function index(Request $request)
    {
        $formalizacion_empresa = Tb_formalizacion_empresa::orderBy('tb_formalizacion_empresa.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'formalizacion_empresa' => $formalizacion_empresa
        ];
    }

    public function indexOne(Request $request)
    {
        $formalizacion_empresa = Tb_formalizacion_empresa::orderBy('tb_formalizacion_empresa.id','desc')
        ->where('tb_formalizacion_empresa.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'formalizacion_empresa' => $formalizacion_empresa
        ];
    }

    public function indexPropio(Request $request)
    {
        $formalizacion_empresa = Tb_formalizacion_empresa::orderBy('tb_formalizacion_empresa.id','asc')
        ->where('tb_formalizacion_empresa.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'formalizacion_empresa' => $formalizacion_empresa
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_formalizacion_empresa=new Tb_formalizacion_empresa();
            $tb_formalizacion_empresa->idUsuario=$request->idUsuario;
            $tb_formalizacion_empresa->estado=1;
            /*
            $tb_formalizacion_empresa=new Tb_formalizacion_empresa();
            $tb_formalizacion_empresa->razonSocial=$request->razonSocial;
            $tb_formalizacion_empresa->marca=$request->marca;
            $tb_formalizacion_empresa->ciiu=$request->ciiu;
            $tb_formalizacion_empresa->usoDeSuelo=$request->usoDeSuelo;
            $tb_formalizacion_empresa->rut=$request->rut;
            $tb_formalizacion_empresa->estatutos=$request->estatutos;
            $tb_formalizacion_empresa->acta=$request->acta;
            $tb_formalizacion_empresa->sociedad=$request->sociedad;
            $tb_formalizacion_empresa->impuestoRegistro=$request->impuestoRegistro;
            $tb_formalizacion_empresa->rues=$request->rues;
            $tb_formalizacion_empresa->libros=$request->libros;
            $tb_formalizacion_empresa->sayco=$request->sayco;
            $tb_formalizacion_empresa->bomberil=$request->bomberil;
            $tb_formalizacion_empresa->placa=$request->placa;
            $tb_formalizacion_empresa->seguridad=$request->seguridad;
            $tb_formalizacion_empresa->salud=$request->salud;
            $tb_formalizacion_empresa->idUsuario=$request->idUsuario;
            $tb_formalizacion_empresa->estado=1;
            */

            if ($tb_formalizacion_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'formalizacion empresa creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'formalizacion empresa no pudo ser creada'
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
            $tb_formalizacion_empresa=Tb_formalizacion_empresa::findOrFail($request->id);
            $tb_formalizacion_empresa->razonSocial=$request->razonSocial;
            $tb_formalizacion_empresa->marca=$request->marca;
            $tb_formalizacion_empresa->ciiu=$request->ciiu;
            $tb_formalizacion_empresa->direccion=$request->direccion;
            $tb_formalizacion_empresa->usoDeSuelo=$request->usoDeSuelo;
            $tb_formalizacion_empresa->rut=$request->rut;
            $tb_formalizacion_empresa->rutEmpresa=$request->rutEmpresa;
            $tb_formalizacion_empresa->estatutos=$request->estatutos;
            $tb_formalizacion_empresa->acta=$request->acta;
            $tb_formalizacion_empresa->sociedad=$request->sociedad;
            $tb_formalizacion_empresa->impuestoRegistro=$request->impuestoRegistro;
            $tb_formalizacion_empresa->rues=$request->rues;
            $tb_formalizacion_empresa->libros=$request->libros;
            $tb_formalizacion_empresa->sayco=$request->sayco;
            $tb_formalizacion_empresa->bomberil=$request->bomberil;
            $tb_formalizacion_empresa->placa=$request->placa;
            $tb_formalizacion_empresa->seguridad=$request->seguridad;
            $tb_formalizacion_empresa->salud=$request->salud;
            $tb_formalizacion_empresa->pasosAvance=$request->pasosAvance;
            $tb_formalizacion_empresa->idUsuario=$request->idUsuario;
            $tb_formalizacion_empresa->estado=1;

            if ($tb_formalizacion_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'formalizacion empresa actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'formalizacion empresa no pudo ser actualizada'
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
            $tb_formalizacion_empresa=Tb_formalizacion_empresa::findOrFail($request->id);
            $tb_formalizacion_empresa->estado='0';

            if ($tb_formalizacion_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'formalizacion empresa desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'formalizacion empresa no pudo ser desactivada'
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
            $tb_formalizacion_empresa=Tb_formalizacion_empresa::findOrFail($request->id);
            $tb_formalizacion_empresa->estado='1';

            if ($tb_formalizacion_empresa->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'formalizacion empresa activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'formalizacion empresa no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
