<?php

namespace App\Listeners;

use App\Events\TeamMemberAccepted;
use App\Models\User;
use App\Notifications\TeamInvitationAccepted;
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
        $user = User::find($event->subject->owner_id);
        $user->notify(new TeamInvitationAccepted($event->subject));
    }
}
