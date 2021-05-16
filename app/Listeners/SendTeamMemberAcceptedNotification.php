<?php

namespace App\Listeners;

use App\Events\TeamMemberAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTeamMemberAcceptedNotification
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
     * @param  TeamMemberAccepted  $event
     * @return void
     */
    public function handle(TeamMemberAccepted $event)
    {
        //
    }
}
