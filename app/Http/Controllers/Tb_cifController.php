<?php

namespace App\Http\Controllers;

use App\Models\Tb_cif;
use Illuminate\Http\Request;

class Tb_cifController extends Controller
{
    public function index(Request $request)
    {
        $cif = Tb_cif::orderBy('tb_cif.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'cif' => $cif
        ];
    }

    public function indexOne(Request $request)
    {
        $cif = Tb_cif::orderBy('tb_cif.id','desc')
        ->where('tb_cif.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'cif' => $cif
        ];
    }

    public function indexPropio(Request $request)
    {
        $cif = Tb_cif::orderBy('tb_cif.id','asc')
        ->where('tb_cif.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'cif' => $cif
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_cif=new Tb_cif();
            $tb_cif->cif=$request->cif;
            $tb_cif->valor=$request->valor;
            $tb_cif->idUsuario=$request->idUsuario;
            $tb_cif->estado=1;

            if ($tb_cif->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'cif creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'cif no pudo ser creada'
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
            $tb_cif=Tb_cif::findOrFail($request->id);
            $tb_cif->cif=$request->cif;
            $tb_cif->valor=$request->valor;
            $tb_cif->idUsuario=$request->idUsuario;
            $tb_cif->estado=1;

            if ($tb_cif->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'cif actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'cif no pudo ser actualizada'
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
            $tb_cif=Tb_cif::findOrFail($request->id);
            $tb_cif->estado='0';

            if ($tb_cif->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'cif desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'cif no pudo ser desactivada'
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
            $tb_cif=Tb_cif::findOrFail($request->id);
            $tb_cif->estado='1';

            if ($tb_cif->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'cif activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'cif no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
