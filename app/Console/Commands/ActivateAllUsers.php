<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ActivateAllUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:activate_all';

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
        $users = DB::select('SELECT id, email_verified_at FROM users');

        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $strNow = $now->format('Y-m-d H:i:s');

        foreach($users as $u) {

            if(!$u->email_verified_at) {
                DB::update(
                    "UPDATE users SET email_verified_at = '".$strNow."'"
                );
            }

        }

        return 0;
    }
}
