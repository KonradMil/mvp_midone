<?php

namespace App\Listeners;

use App\Events\SolutionAccepted;
use App\Events\SolutionRejected;
use App\Models\Challenge;
use App\Notifications\SolutionAcceptedNotification;
use App\Notifications\SolutionRejectedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSolutionRejectedNotification
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
     * @param  SolutionRejected  $event
     * @return void
     */
    public function handle(SolutionRejected $event)
    {
        $user = $event->subject->author;
        $challenge = Challenge::find($event->subject->challenge_id);
        $user->notify(new SolutionRejectedNotification($challenge, $event->subject));
    }
}
