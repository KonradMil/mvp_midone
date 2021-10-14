<?php

namespace App\Listeners;

use App\Events\OfferAdded;
use App\Events\OfferPublished;
use App\Events\SolutionPublished;
use App\Models\Challenge;
use App\Models\Solution;
use App\Models\User;
use App\Notifications\ChallengePublishedNotification;
use App\Notifications\OfferAddedNotification;
use App\Notifications\OfferPublishedNotification;
use App\Notifications\SolutionAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOfferAddedNotification
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
     * @param  SolutionPublished  $event
     * @return void
     */
    public function handle(OfferAdded $event)
    {
        $user = $event->subject->installer;
        $challenge = Challenge::find($event->subject->challenge_id);
        $solution = Solution::find($event->subject->solution_id);
        $user->notify(new OfferAddedNotification($challenge, $solution));
    }
}
