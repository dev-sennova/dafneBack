<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tb_ideas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EliminarIdeasNoModerados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ideas:eliminar-no-moderados';
    protected $description = 'Eliminar ideas que no han sido moderados y cuya visibilidad no ha cambiado en las últimas 12 horas';
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
        $ideas = Tb_ideas::where('visibilidad', 2)
                              ->where('moderacion', 0)
                              ->where('created_at', '<=', Carbon::now()->subHours(12))
                              ->get();

        foreach ($ideas as $idea) {
            DB::table('tb_usuario_ideas')->where('idideas', $idea->id)->where('estado',0)->delete();

            $idea->delete();
        }

        $this->info('Ideas no moderadas y sin cambio de visibilidad eliminadas exitosamente.');
    }
}
