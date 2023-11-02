<?php

use App\Models\Tb_usuario_rol;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_rol'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_rolSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'users'
        ]);

        //funcion principal que llama cada seeder
        $this->call(UsersSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_usuario'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_usuarioSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_usuario_rol'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_usuario_rolSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_ciudad'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_ciudadSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_hobbies'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_hobbiesSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_suenos'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_suenosSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_ideas'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_ideasSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_criterios'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_criteriosSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_preguntas_legal'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_preguntas_legalSeeder::class);
//-------------------------------------------------------------------//

//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_enunciados_legal'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_enunciados_legalSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_enlaces_legal'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_enlaces_legalSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_preguntas_tributario'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_preguntas_tributarioSeeder::class);
//-------------------------------------------------------------------//

//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_enunciados_tributario'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_enunciados_tributarioSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_enlaces_tributario'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_enlaces_tributarioSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_preguntas_tributario_persona'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_preguntas_tributario_personaSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_enunciados_tributario_persona'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_enunciados_tributario_personaSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_enlaces_tributario_persona'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_enlaces_tributario_personaSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_modulo'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_moduloSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_secciones'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_seccionesSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_variables_globales'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_variables_globalesSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_riesgo_arl'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_riesgo_arlSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_codigo_ciiu'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_codigo_ciiuSeeder::class);
//-------------------------------------------------------------------//

//--Tener cuidado con este cierre--//
    }
//--Tener cuidado con este cierre--//

    //funcion que deshabilita revision de claves foraneas para borrar tablas y luego la habilita nuevamente
    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
