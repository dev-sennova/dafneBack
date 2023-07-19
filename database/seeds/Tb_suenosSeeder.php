<?php

use App\Models\Tb_suenos;
use Illuminate\Database\Seeder;

class Tb_suenosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_suenos.json'));
        foreach ($data as $item){
            Tb_suenos::create(array(
                'id' => $item->id,
                'sueno' => $item->sueno,
                'visibilidad' => $item->visibilidad,
                'moderacion' => $item->moderacion,
                'estado' => $item->estado,
            ));
            }
    }
}
