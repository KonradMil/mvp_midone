<?php

namespace App\Listeners;

use App\Events\SolutionAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSolutionNotification
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
     * @param  SolutionAdded  $event
     * @return void
     */
    public function handle(SolutionAdded $event)
    {
        //
    }
}
