<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tb_suenos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EliminarSuenosNoModerados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suenos:eliminar-no-moderados';
    protected $description = 'Eliminar sueños que no han sido moderados y cuya visibilidad no ha cambiado en las últimas 12 horas';
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
        $suenos = Tb_suenos::where('visibilidad', 2)
                              ->where('moderacion', 0)
                              ->where('created_at', '<=', Carbon::now()->subHours(12))
                              ->get();

        foreach ($suenos as $sueno) {
            DB::table('tb_usuario_suenos')->where('idSueno', $sueno->id)->where('estado',0)->delete();

            $sueno->delete();
        }

        $this->info('Sueños no moderados y sin cambio de visibilidad eliminados exitosamente.');
    }
}
