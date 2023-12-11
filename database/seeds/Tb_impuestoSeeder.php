<?php

use App\Models\Tb_impuesto;
use Illuminate\Database\Seeder;

class Tb_impuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_impuesto.json'));
        foreach ($data as $item){
            Tb_impuesto::create(array(
                'id' => $item->id,
                'impuesto' => $item->impuesto,
                'porcentaje' => $item->porcentaje,
                'estado' => $item->estado,
            ));
            }
    }
}
