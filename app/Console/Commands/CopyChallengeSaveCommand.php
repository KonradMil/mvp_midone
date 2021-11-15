<?php

namespace App\Console\Commands;

use App\Models\Challenge;
use Illuminate\Console\Command;

class CopyChallengeSaveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'challenge:copy_save {challenge_from} {challenge_to} ';

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
        $challengeFromId = $this->argument('challenge_from');
        $challengeToId = $this->argument('challenge_to');

        $challengeFrom = Challenge::find($challengeFromId);
        $challengeTo = Challenge::find($challengeToId);

        if($challengeFrom && $challengeTo) {
            $challengeTo->save_json = json_encode($challengeFrom->save_json);
            $challengeTo->screenshot_path = json_encode($challengeFrom->screenshot_path);
            $challengeTo->save();
        }

        return 0;
    }
}
