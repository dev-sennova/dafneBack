<?php

use App\Models\Tb_secciones;
use Illuminate\Database\Seeder;

class Tb_seccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_secciones.json'));
        foreach ($data as $item){
            Tb_secciones::create(array(
                'id' => $item->id,
                'seccion' => $item->seccion,
                'idModulo' => $item->idModulo
            ));
            }
    }
}
