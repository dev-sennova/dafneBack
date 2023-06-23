<?php

use App\Models\Tb_usuario;
use Illuminate\Database\Seeder;

class Tb_usuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_usuario.json'));
        foreach ($data as $item){
            Tb_usuario::create(array(
                'id' => $item->id,
                'nombre' => $item->nombre,
                'tipodocumento' => $item->tipodocumento,
                'documento' => $item->documento,
                'direccion' => $item->direccion,
                'telefono' => $item->telefono,
                'ciudad' => $item->ciudad,
                'email' => $item->email,
                'sexo' => $item->sexo,
                'estado' => $item->estado,
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
