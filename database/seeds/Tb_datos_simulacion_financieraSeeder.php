<?php

use App\Models\Tb_datos_simulacion_financiera;
use Illuminate\Database\Seeder;

class Tb_datos_simulacion_financieraSeeder extends Seeder
{
    /**
      * Run the database seeds.
      *
      * @return void
      */
     public function run()
     {
         $data = json_decode(file_get_contents(__DIR__ . '/json/tb_datos_simulacion_financiera.json'));
         foreach ($data as $item){
             Tb_datos_simulacion_financiera::create(array(
                 'id' => $item->id,
                 'dato' => $item->dato
             ));
             }
     }
 }
