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
        DB::delete('DELETE FROM user_companies WHERE id > 0');

        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $strNow = $now->format('Y-m-d H:i:s');

        foreach($companies as $c) {

            DB::insert("
                INSERT INTO user_companies (user_id, company_id, created_at, updated_at)
                VALUES('$c->author_id', '$c->id', '$strNow', '$strNow')
            ");

        }

        return 0;
    }
}
