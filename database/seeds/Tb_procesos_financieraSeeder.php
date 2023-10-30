<?php

use App\Models\Tb_procesos_financiera;
use Illuminate\Database\Seeder;

class Tb_procesos_financieraSeeder extends Seeder
{
    /**
      * Run the database seeds.
      *
      * @return void
      */
     public function run()
     {
         $data = json_decode(file_get_contents(__DIR__ . '/json/tb_procesos_financiera.json'));
         foreach ($data as $item){
             Tb_procesos_financiera::create(array(
                 'id' => $item->id,
                 'proceso' => $item->proceso
             ));
             }
     }
 }
