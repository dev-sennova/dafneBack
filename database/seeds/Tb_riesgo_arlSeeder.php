<?php

use App\Models\Tb_riesgo_arl;
use Illuminate\Database\Seeder;

class Tb_riesgo_arlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_riesgo_arl.json'));
        foreach ($data as $item){
            Tb_riesgo_arl::create(array(
                'id' => $item->id,
                'riesgo' => $item->riesgo,
                'porcentaje' => $item->porcentaje,
                'estado' => $item->estado,
            ));
            }
    }
}
