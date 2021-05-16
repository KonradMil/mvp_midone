<?php

namespace App\Listeners;

use App\Events\ChallengeAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChallengeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ChallengeAdded  $event
     * @return void
     */
    public function handle(ChallengeAdded $event)
    {
        //
    }
}
