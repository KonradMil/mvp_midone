<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixUserCompanies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:user_companies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fommand fixes user_companies data';

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
        $companies = DB::select('SELECT id, author_id FROM companies');

        foreach($companies as $c) {

            $userCompanies = DB::select('SELECT id FROM user_companies WHERE company_id = '.$c->author_id);

            foreach($userCompanies as $uc) {
                DB::update('UPDATE user_companies SET user_id = '.$c->author_id.', company_id = '.$c->id .' WHERE id = '.$uc->id);
            }
        }

        return 0;
    }
}
