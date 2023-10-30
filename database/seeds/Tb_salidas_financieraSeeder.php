<?php

use App\Models\Tb_salidas_financiera;
use Illuminate\Database\Seeder;

class Tb_salidas_financieraSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_salidas_financiera.json'));
        foreach ($data as $item){
            Tb_salidas_financiera::create(array(
                'id' => $item->id,
                'salida' => $item->salida
            ));
            }
    }
}
