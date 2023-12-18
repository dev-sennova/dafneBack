<?php

namespace App\Http\Controllers;

use App\Models\Tb_avances_legal;
use App\Models\Tb_cif;
use App\Models\Tb_consolidado_simulacion_financiera;
use App\Models\Tb_empleados_empresa;
use App\Models\Tb_hoja_costos_simula;
use App\Models\Tb_maquinaria;
use App\Models\Tb_nomina_empleados_simula;
use App\Models\Tb_variables_globales;
use Illuminate\Http\Request;

class Tb_hoja_costos_simulaController extends Controller
{
    public function index(Request $request)
    {
        $hoja_costos_simula = Tb_hoja_costos_simula::orderBy('tb_hoja_costos_simula.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'hoja_costos_simula' => $hoja_costos_simula
        ];
    }

    public function indexOne(Request $request)
    {
        $hoja_costos_simula = Tb_hoja_costos_simula::orderBy('tb_hoja_costos_simula.id','desc')
        ->where('tb_hoja_costos_simula.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'hoja_costos_simula' => $hoja_costos_simula
        ];
    }

    public function indexPropio(Request $request)
    {
        $hoja_costos_simula = Tb_hoja_costos_simula::orderBy('tb_hoja_costos_simula.id','asc')
        ->where('tb_hoja_costos_simula.idUsuario','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'hoja_costos_simula' => $hoja_costos_simula
        ];
    }

    public function consolidado(Request $request)
    {
        $hoja_costos_simula = Tb_hoja_costos_simula::orderBy('tb_hoja_costos_simula.id','asc')
        ->where('tb_hoja_costos_simula.idUsuario','=',$request->id)
        ->get();

        $consolidado=0;

        foreach($hoja_costos_simula as $vueltaG){
                $valorP= $vueltaG->monto;

                $consolidado=$consolidado+$valorP;
        }

        return [
            'estado' => 'Ok',
            'consolidado' => $consolidado
        ];
    }

    public function consolidadoUnidad(Request $request)
    {
        $hoja_costos_simula = Tb_hoja_costos_simula::orderBy('tb_hoja_costos_simula.id','asc')
        ->where('tb_hoja_costos_simula.idUsuario','=',$request->id)
        ->get();

        $consolidado=0;

        foreach($hoja_costos_simula as $vueltaG){
                $valorP= $vueltaG->montounidad;

                $consolidado=$consolidado+$valorP;
                $consolidadof=round($consolidado, 2);
        }

        return [
            'estado' => 'Ok',
            'consolidado' => $consolidadof
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {

            $persona_natural = Tb_avances_legal::where('tb_avances_legal.idUsuario','=',$request->idUsuario)
            ->where('tb_avances_legal.enunciado','=',1)
            ->where('tb_avances_legal.idExterno','=',8)
            ->count();

            $cantidad_empleados = Tb_empleados_empresa::where('tb_empleados_empresa.idUsuario','=',$request->idUsuario)
            ->count();

            $variables_globales=Tb_variables_globales::where('tb_variables_globales.estado','=','1')
            ->get();

            foreach($variables_globales as $vueltaG){
                    if($vueltaG->id==1){
                        $auxilioT= floatval($vueltaG->valor);
                    }else if($vueltaG->id==3){
                        $minimo= floatval($vueltaG->valor);
                    }
                }

            $tope_sueldo=$minimo*10;
            $tope_auxilio=$minimo*2;

            $capacidad_global=Tb_consolidado_simulacion_financiera::where('tb_consolidado_simulacion_financiera.idUsuario','=',$request->idUsuario)
            ->get();

            foreach($capacidad_global as $vueltaCG){
                    $capacidad_producto= floatval($vueltaCG->cantidadProducto);
                    $costo_materiales= floatval($vueltaCG->costoMateriales);
                    $costo_compra= floatval($vueltaCG->costoCompra);
                }

            $consolidado_simulacion_financiera = Tb_consolidado_simulacion_financiera::orderBy('tb_consolidado_simulacion_financiera.id','asc')
            ->where('tb_consolidado_simulacion_financiera.idUsuario','=',$request->idUsuario)
            ->get();

            foreach($consolidado_simulacion_financiera as $vueltaCSF){
                $idConsolidado = $vueltaCSF->id;
                }

            if($persona_natural==1 && $cantidad_empleados==1){
                //Si cumple las dos condiciones, debe calcularse full
                $lista_empleados = Tb_empleados_empresa::join('tb_perfiles_empresa','tb_empleados_empresa.idPerfil','=','tb_perfiles_empresa.id')
                ->join('tb_riesgo_arl','tb_empleados_empresa.idRiesgo','=','tb_riesgo_arl.id')
                ->where('tb_empleados_empresa.idUsuario','=',$request->idUsuario)
                ->select('tb_empleados_empresa.empleado','tb_empleados_empresa.produccion','tb_perfiles_empresa.perfil',
                'tb_perfiles_empresa.precio','tb_riesgo_arl.riesgo','tb_riesgo_arl.porcentaje')
                ->get();

                foreach($lista_empleados as $vueltaP){
                    $nombre_empleado= $vueltaP->empleado;
                    $es_produccion= $vueltaP->produccion;
                    $nombre_perfil= $vueltaP->perfil;
                    $costo_perfil= floatval($vueltaP->precio);
                    $riesgo_arl= $vueltaP->riesgo;
                    $porcentaje_riesgo= floatval($vueltaP->porcentaje);
                    $porcentaje_arl=$porcentaje_riesgo/100;
                    }

                    if($costo_perfil>$tope_auxilio){
                        $auxilio=0;
                    }else{
                        $auxilio=$auxilioT;
                    }

                    $salud=$costo_perfil*0.085;
                    $pension=$costo_perfil*0.12;
                    $arl=$costo_perfil*$porcentaje_arl;
                    $caja=$costo_perfil*0.04;
                    $sena=$costo_perfil*0.02;
                    $icbf=$costo_perfil*0.03;
                    $prima=($costo_perfil+$auxilio)*0.0833;
                    $cesantias=($costo_perfil+$auxilio)*0.0833;
                    $vacaciones=$costo_perfil*0.0417;
                    $intereses=($costo_perfil+$auxilio)*0.01;

                    $costomes=$costo_perfil+$auxilio+$salud+$pension+$arl+$caja+$sena+$icbf+$prima+$cesantias+$vacaciones+$intereses;

                    $nomina_empleados_simula=new Tb_nomina_empleados_simula();
                    $nomina_empleados_simula->perfil=$nombre_perfil;
                    $nomina_empleados_simula->valor=$costo_perfil;
                    $nomina_empleados_simula->auxilio=$auxilio;
                    $nomina_empleados_simula->salud=$salud;
                    $nomina_empleados_simula->pension=$pension;
                    $nomina_empleados_simula->arl=$arl;
                    $nomina_empleados_simula->caja=$caja;
                    $nomina_empleados_simula->sena=$sena;
                    $nomina_empleados_simula->icbf=$icbf;
                    $nomina_empleados_simula->prima=$prima;
                    $nomina_empleados_simula->cesantias=$cesantias;
                    $nomina_empleados_simula->vacaciones=$vacaciones;
                    $nomina_empleados_simula->intereses=$intereses;
                    $nomina_empleados_simula->costomensual=$costomes;
                    $nomina_empleados_simula->productiva=$es_produccion;
                    $nomina_empleados_simula->idUsuario=$request->idUsuario;
                    $nomina_empleados_simula->estado=1;
                    $nomina_empleados_simula->save();

                    if($es_produccion==1){
                        $hoja_costos_simula=new Tb_hoja_costos_simula();
                        $hoja_costos_simula->detalle=$nombre_perfil;
                        $hoja_costos_simula->monto=$costomes;
                        $hoja_costos_simula->capacidad=$capacidad_producto;
                        $hoja_costos_simula->montounidad=($costomes/$capacidad_producto);
                        $hoja_costos_simula->producto=0;
                        $hoja_costos_simula->talento=1;
                        $hoja_costos_simula->cif=0;
                        $hoja_costos_simula->idUsuario=$request->idUsuario;
                        $hoja_costos_simula->estado=1;
                        $hoja_costos_simula->save();
                    }

            $tb_consolidado_simulacion_financiera=Tb_consolidado_simulacion_financiera::findOrFail($idConsolidado);
            $tb_consolidado_simulacion_financiera->talentoHumano=$costomes;
            $tb_consolidado_simulacion_financiera->save();

            }else{
                //Si no, debe validarse en cada vuelta si el valor es superior al tope
                $lista_empleados = Tb_empleados_empresa::join('tb_perfiles_empresa','tb_empleados_empresa.idPerfil','=','tb_perfiles_empresa.id')
                ->join('tb_riesgo_arl','tb_empleados_empresa.idRiesgo','=','tb_riesgo_arl.id')
                ->where('tb_empleados_empresa.idUsuario','=',$request->idUsuario)
                ->select('tb_empleados_empresa.empleado','tb_empleados_empresa.produccion','tb_perfiles_empresa.perfil',
                'tb_perfiles_empresa.precio','tb_riesgo_arl.riesgo','tb_riesgo_arl.porcentaje')
                ->get();

                foreach($lista_empleados as $vueltaP){
                    $nombre_empleado= $vueltaP->empleado;
                    $es_produccion= $vueltaP->produccion;
                    $nombre_perfil= $vueltaP->perfil;
                    $costo_perfil= floatval($vueltaP->precio);
                    $riesgo_arl= $vueltaP->riesgo;
                    $porcentaje_riesgo= floatval($vueltaP->porcentaje);
                    $porcentaje_arl=$porcentaje_riesgo/100;

                        if($costo_perfil>$tope_sueldo){ //mas de 10 minimos
                            if($costo_perfil>$tope_auxilio){//mas de dos minimos
                                $auxilio=0;
                            }else{
                                $auxilio=$auxilioT;
                            }

                            $salud=$costo_perfil*0.085;
                            $pension=$costo_perfil*0.12;
                            $arl=$costo_perfil*$porcentaje_arl;
                            $caja=$costo_perfil*0.04;
                            $sena=$costo_perfil*0.02;
                            $icbf=$costo_perfil*0.03;
                            $prima=($costo_perfil+$auxilio)*0.0833;
                            $cesantias=($costo_perfil+$auxilio)*0.0833;
                            $vacaciones=$costo_perfil*0.0417;
                            $intereses=($costo_perfil+$auxilio)*0.01;
                        }else{//menos de 10 minimos
                            if($costo_perfil>$tope_auxilio){//mas de dos minimos
                                $auxilio=0;
                            }else{
                                $auxilio=$auxilioT;
                            }

                            $salud=0;
                            $pension=$costo_perfil*0.12;
                            $arl=$costo_perfil*$porcentaje_arl;
                            $caja=$costo_perfil*0.04;
                            $sena=0;
                            $icbf=0;
                            $prima=($costo_perfil+$auxilio)*0.0833;
                            $cesantias=($costo_perfil+$auxilio)*0.0833;
                            $vacaciones=$costo_perfil*0.0417;
                            $intereses=($costo_perfil+$auxilio)*0.01;
                        }
                        $costomes=$costo_perfil+$auxilio+$salud+$pension+$arl+$caja+$sena+$icbf+$prima+$cesantias+$vacaciones+$intereses;

                        $nomina_empleados_simula=new Tb_nomina_empleados_simula();
                        $nomina_empleados_simula->perfil=$nombre_perfil;
                        $nomina_empleados_simula->valor=$costo_perfil;
                        $nomina_empleados_simula->auxilio=$auxilio;
                        $nomina_empleados_simula->salud=$salud;
                        $nomina_empleados_simula->pension=$pension;
                        $nomina_empleados_simula->arl=$arl;
                        $nomina_empleados_simula->caja=$caja;
                        $nomina_empleados_simula->sena=$sena;
                        $nomina_empleados_simula->icbf=$icbf;
                        $nomina_empleados_simula->prima=$prima;
                        $nomina_empleados_simula->cesantias=$cesantias;
                        $nomina_empleados_simula->vacaciones=$vacaciones;
                        $nomina_empleados_simula->intereses=$intereses;
                        $nomina_empleados_simula->costomensual=$costomes;
                        $nomina_empleados_simula->productiva=$es_produccion;
                        $nomina_empleados_simula->idUsuario=$request->idUsuario;
                        $nomina_empleados_simula->estado=1;
                        $nomina_empleados_simula->save();

                        if($es_produccion==1){
                            $hoja_costos_simula=new Tb_hoja_costos_simula();
                            $hoja_costos_simula->detalle=$nombre_perfil;
                            $hoja_costos_simula->monto=$costomes;
                            $hoja_costos_simula->capacidad=$capacidad_producto;
                            $hoja_costos_simula->montounidad=($costomes/$capacidad_producto);
                            $hoja_costos_simula->producto=0;
                            $hoja_costos_simula->talento=1;
                            $hoja_costos_simula->cif=0;
                            $hoja_costos_simula->idUsuario=$request->idUsuario;
                            $hoja_costos_simula->estado=1;
                            $hoja_costos_simula->save();
                        }
                    }

                    $acumulado_talento=0;

                    $lista_talento = Tb_hoja_costos_simula::where('tb_hoja_costos_simula.idUsuario','=',$request->idUsuario)
                    ->where('tb_hoja_costos_simula.talento','=',1)
                    ->get();

                    foreach($lista_talento as $vueltaPT){
                        $monto_empleado= floatval($vueltaPT->monto);
                        $acumulado_talento=$acumulado_talento+$monto_empleado;
                        }

                    $tb_consolidado_simulacion_financiera=Tb_consolidado_simulacion_financiera::findOrFail($idConsolidado);
                    $tb_consolidado_simulacion_financiera->talentoHumano=$acumulado_talento;
                    $tb_consolidado_simulacion_financiera->save();
            }

            if($costo_materiales>0){
                $hoja_costos_simula=new Tb_hoja_costos_simula();
                $hoja_costos_simula->detalle="Materia prima";
                $hoja_costos_simula->monto=$costo_materiales;
                $hoja_costos_simula->capacidad=$capacidad_producto;
                $hoja_costos_simula->montounidad=($costo_materiales/$capacidad_producto);
                $hoja_costos_simula->producto=1;
                $hoja_costos_simula->talento=0;
                $hoja_costos_simula->cif=0;
                $hoja_costos_simula->idUsuario=$request->idUsuario;
                $hoja_costos_simula->estado=1;
                $hoja_costos_simula->save();
            }

            if($costo_compra>0){
                $hoja_costos_simula=new Tb_hoja_costos_simula();
                $hoja_costos_simula->detalle="Producto compra";
                $hoja_costos_simula->monto=$costo_compra;
                $hoja_costos_simula->capacidad=$capacidad_producto;
                $hoja_costos_simula->montounidad=($costo_compra/$capacidad_producto);
                $hoja_costos_simula->producto=1;
                $hoja_costos_simula->talento=0;
                $hoja_costos_simula->cif=0;
                $hoja_costos_simula->idUsuario=$request->idUsuario;
                $hoja_costos_simula->estado=1;
                $hoja_costos_simula->save();
            }

            $tb_maquinaria = Tb_maquinaria::where('tb_maquinaria.idUsuario','=',$request->idUsuario)
            ->get();

            $acummulado_depreciacion=0;

            foreach($tb_maquinaria as $vueltaMaq){
                $nombre_maquinaria= $vueltaMaq->maquinaria;
                $depreciacion= $vueltaMaq->depreciacion;
                $acummulado_depreciacion=$acummulado_depreciacion+$depreciacion;
                }

                $tb_cif=new Tb_cif();
                $tb_cif->cif="Depreciación";
                $tb_cif->valor=$acummulado_depreciacion;
                $tb_cif->idUsuario=$request->idUsuario;
                $tb_cif->estado=1;
                $tb_cif->save();

            $tb_cif = Tb_cif::where('tb_cif.idUsuario','=',$request->idUsuario)
            ->get();

            foreach($tb_cif as $vueltaCif){
                $nombre_cif= $vueltaCif->cif;
                $valor_cif= $vueltaCif->valor;

                $hoja_costos_simula=new Tb_hoja_costos_simula();
                $hoja_costos_simula->detalle=$nombre_cif;
                $hoja_costos_simula->monto=$valor_cif;
                $hoja_costos_simula->capacidad=$capacidad_producto;
                $hoja_costos_simula->montounidad=($valor_cif/$capacidad_producto);
                $hoja_costos_simula->producto=0;
                $hoja_costos_simula->talento=0;
                $hoja_costos_simula->cif=1;
                $hoja_costos_simula->idUsuario=$request->idUsuario;
                $hoja_costos_simula->estado=1;
                $hoja_costos_simula->save();
                }

                $acumulado_cif=0;

                $tb_hoja_costos_simula_cif = Tb_hoja_costos_simula::where('tb_hoja_costos_simula.idUsuario','=',$request->idUsuario)
                ->where('tb_hoja_costos_simula.cif','=',1)
                ->get();

                foreach($tb_hoja_costos_simula_cif as $vueltaCIF){
                    $valor_cif = floatval($vueltaCIF->monto);
                    $acumulado_cif=$acumulado_cif+$valor_cif;
                    }

                $tb_consolidado_simulacion_financieraCIF=Tb_consolidado_simulacion_financiera::findOrFail($idConsolidado);
                $tb_consolidado_simulacion_financieraCIF->costosIndirectos=$acumulado_cif;
                $tb_consolidado_simulacion_financieraCIF->save();

                return response()->json([
                    'acumulado_talento' => $acumulado_talento,
                    'acumulado_cif' => $acumulado_cif,
                    'idConsolidado' => $idConsolidado
                ],200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno: '.$e], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $hoja_costos_simula=Tb_hoja_costos_simula::findOrFail($request->id);
            $hoja_costos_simula->detalle=$request->detalle;
            $hoja_costos_simula->monto=$request->monto;
            $hoja_costos_simula->capacidad=$request->capacidad;
            $hoja_costos_simula->montounidad=$request->montounidad;
            $hoja_costos_simula->producto=$request->producto;
            $hoja_costos_simula->talento=$request->talento;
            $hoja_costos_simula->cif=$request->cif;
            $hoja_costos_simula->idUsuario=$request->idUsuario;
            $hoja_costos_simula->estado=1;

            if ($hoja_costos_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'hoja costos actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'hoja costos no pudo ser actualizada'
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
            $hoja_costos_simula=Tb_hoja_costos_simula::findOrFail($request->id);
            $hoja_costos_simula->estado='0';

            if ($hoja_costos_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'hoja costos desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'hoja costos no pudo ser desactivada'
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
            $hoja_costos_simula=Tb_hoja_costos_simula::findOrFail($request->id);
            $hoja_costos_simula->estado='1';

            if ($hoja_costos_simula->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'hoja costos activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'hoja costos no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
