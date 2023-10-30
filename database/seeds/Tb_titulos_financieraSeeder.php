<?php

use App\Models\Tb_titulos_financiera;
use Illuminate\Database\Seeder;

class Tb_titulos_financieraSeeder extends Seeder
{
    /**
      * Run the database seeds.
      *
      * @return void
      */
     public function run()
     {
         $data = json_decode(file_get_contents(__DIR__ . '/json/tb_titulos_financiera.json'));
         foreach ($data as $item){
             Tb_titulos_financiera::create(array(
                 'id' => $item->id,
                 'titulo' => $item->titulo
             ));
             }
     }
 }
