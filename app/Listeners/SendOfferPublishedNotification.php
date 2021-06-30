<?php

namespace App\Listeners;

use App\Events\OfferPublished;
use App\Events\SolutionPublished;
use App\Models\Challenges\Challenge;
use App\Models\User;
use App\Notifications\ChallengePublishedNotification;
use App\Notifications\OfferPublishedNotification;
use App\Notifications\SolutionAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOfferPublishedNotification
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
    public function handle(OfferPublished $event)
    {
        $user = $event->subject->installer;
        $challenge = Challenge::find($event->subject->challenge_id);
        $user->notify(new OfferPublishedNotification($challenge, $event->subject));
    }
}
