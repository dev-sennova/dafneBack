<?php

use App\Models\Tb_codigo_ciiu;
use Illuminate\Database\Seeder;

class Tb_codigo_ciiuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_codigo_ciiu.json'));
        foreach ($data as $item){
            Tb_codigo_ciiu::create(array(
                'id' => $item->id,
                'descripcion' => $item->descripcion,
                'codigo' => $item->codigo,
                'idriesgo' => $item->idriesgo,
                'estado' => $item->estado,
            ));
            }
    }
}
