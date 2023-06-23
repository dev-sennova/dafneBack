<?php

use App\Models\Tb_usuario_rol;
use Illuminate\Database\Seeder;

class Tb_usuario_rolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_usuario_rol.json'));
        foreach ($data as $item){
            Tb_usuario_rol::create(array(
                'id' => $item->id,
                'idUsuario' => $item->idUsuario,
                'idRol' => $item->idRol,
            ));
            }
        /*
        DB::table('tb_rol')->insert([
            'rol' => 'SuperAdministrador',
        ]);

        DB::table('tb_rol')->insert([
            'rol' => 'Empresario',
        ]
        );
        */
    }
}
