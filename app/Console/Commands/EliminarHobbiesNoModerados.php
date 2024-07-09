<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tb_hobbies;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EliminarHobbiesNoModerados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hobbies:eliminar-no-moderados';
    protected $description = 'Eliminar hobbies que no han sido moderados y cuya visibilidad no ha cambiado en las últimas 12 horas';


    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $hobbies = Tb_hobbies::where('visibilidad', 2)
                              ->where('moderacion', 0)
                              ->where('created_at', '<=', Carbon::now()->subHours(12))
                              ->get();

        foreach ($hobbies as $hobby) {
            DB::table('tb_usuario_hobbies')->where('idHobby', $hobby->id)->where('estado',0)->delete();

            $hobby->delete();
        }

        $this->info('Hobbies no moderados y sin cambio de visibilidad eliminados exitosamente.');
    }
}
