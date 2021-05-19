<?php

namespace App\Listeners;

use App\Events\SolutionAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddActivityLog
{



    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  SolutionAccepted  $event
     * @return void
     */
    public function handle($event)
    {
        activity()
            ->performedOn($event->subject)
            ->causedBy($event->causer)
            ->withProperties($event->props)
            ->log($event->message);
    }
}
