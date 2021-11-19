<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixUnityData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:unity_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $solutions = DB::select("SELECT id, save_json FROM solutions");

        foreach ($solutions as $s) {

            $data = json_decode($s->save_json);

            if($data) {

                foreach($data->parts as $p){
                    $p->sourceType = "solution";
                }

                DB::update("UPDATE solutions SET save_json = '".json_encode($data, JSON_UNESCAPED_UNICODE)."' WHERE id = ".$s->id);
            }

        }

        return 0;
    }
}
