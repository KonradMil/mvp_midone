<?php

namespace App\Listeners;

use App\Events\SolutionAdded;
use App\Events\SolutionPublished;
use App\Models\Challenge;
use App\Models\Solution;
use App\Models\User;
use App\Notifications\ChallengePublishedNotification;
use App\Notifications\OfferPublishedNotification;
use App\Notifications\SolutionAddedNotification;
use App\Notifications\SolutionPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSolutionAddedNotification
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
    public function handle(SolutionAdded $event)
    {
        $user = $event->subject->author;
        $challenge = Challenge::find($event->subject->challenge_id);
        $user->notify(new SolutionAddedNotification($challenge, $event->subject));
    }
}
