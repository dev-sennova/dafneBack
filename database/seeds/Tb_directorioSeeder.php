<?php

use App\Models\Tb_directorio;
use Illuminate\Database\Seeder;

class Tb_directorioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_directorio.json'));
        foreach ($data as $item){
            Tb_directorio::create(array(
                'id' => $item->id,
                'entidad' => $item->entidad,
                'municipio' => $item->municipio,
                'direccion' => $item->direccion,
                'web' => $item->web,
                'telefonos' => $item->telefonos,
                'chat' => $item->chat,
                'correo' => $item->correo,
                'tipo' => $item->tipo,
                'estado' => $item->estado
            ));
            }
    }
}
