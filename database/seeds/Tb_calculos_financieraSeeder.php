<?php

use App\Models\Tb_calculos_financiera;
use Illuminate\Database\Seeder;

class Tb_calculos_financieraSeeder extends Seeder
{
    /**
      * Run the database seeds.
      *
      * @return void
      */
     public function run()
     {
         $data = json_decode(file_get_contents(__DIR__ . '/json/tb_calculos_financiera.json'));
         foreach ($data as $item){
             Tb_calculos_financiera::create(array(
                 'id' => $item->id,
                 'calculo' => $item->calculo
             ));
             }
     }
 }
