<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tb_criterios;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EliminarCriteriosNoModerados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'criterios:eliminar-no-moderados';
    protected $description = 'Eliminar criterios que no han sido moderados y cuya visibilidad no ha cambiado en las últimas 12 horas';

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
        $criterios = Tb_criterios::where('visibilidad', 2)
                              ->where('moderacion', 0)
                              ->where('created_at', '<=', Carbon::now()->subHours(12))
                              ->get();

        foreach ($criterios as $criterio) {
            DB::table('tb_usuario_criterios')->where('idCriterio', $criterio->id)->where('estado',0)->delete();

            $criterio->delete();
        }

        $this->info('Criterios no moderados y sin cambio de visibilidad eliminados exitosamente.');
    }
}
