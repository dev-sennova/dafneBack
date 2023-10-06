<?php

use App\Models\Tb_enunciados;
use Illuminate\Database\Seeder;

class Tb_enunciadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_enunciados.json'));
        foreach ($data as $item){
            Tb_enunciados::create(array(
                'id' => $item->id,
                'enunciado' => $item->enunciado
            ));
            }
    }
}
