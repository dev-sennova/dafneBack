<?php

use App\Models\Tb_enunciados_financiera;
use Illuminate\Database\Seeder;

class Tb_enunciados_financieraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_enunciados_financiera.json'));
        foreach ($data as $item){
            Tb_enunciados_financiera::create(array(
                'id' => $item->id,
                'enunciado' => $item->enunciado
            ));
            }
    }
}
