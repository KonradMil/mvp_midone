<?php

namespace App\Listeners;

use App\Events\SolutionAccepted;
use App\Models\Challenge;
use App\Models\User;
use App\Notifications\SolutionAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSolutionAcceptedNotification
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
     * @param  SolutionAccepted  $event
     * @return void
     */
    public function handle(SolutionAccepted $event)
    {
        $user = $event->subject->author;
        $challenge = Challenge::find($event->subject->challenge_id);
        $client = User::find($challenge->author_id);
        $user->notify(new SolutionAcceptedNotification($challenge, $event->subject));
        $client->notify(new SolutionAcceptedNotification($challenge, $event->subject));
    }
}
