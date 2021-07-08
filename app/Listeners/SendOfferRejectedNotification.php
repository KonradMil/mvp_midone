<?php

namespace App\Listeners;

use App\Events\OfferAccepted;
use App\Events\OfferRejected;
use App\Events\SolutionAccepted;
use App\Models\Challenges\Challenge;
use App\Models\Solutions\Solution;
use App\Models\User;
use App\Notifications\OfferAcceptedNotification;
use App\Notifications\OfferRejectedNotification;
use App\Notifications\SolutionAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOfferRejectedNotification
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
    public function handle(OfferRejected $event)
    {
        $user = $event->subject->installer;
        $challenge = Challenge::find($event->subject->challenge_id);
        $solution = Solution::find($event->subject->solution_id);
        $client = User::find($challenge->author_id);
        $user->notify(new OfferRejectedNotification($challenge, $solution));
        $client->notify(new OfferRejectedNotification($challenge, $solution));
    }
}
