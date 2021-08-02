<?php

namespace App\Listeners;

use App\Events\ChallengeLiked;
use App\Events\SolutionAdded;
use App\Events\SolutionPublished;
use App\Models\Challenges\Challenge;
use App\Models\Solutions\Solution;
use App\Models\User;
use App\Notifications\ChallengeLikedNotification;
use App\Notifications\ChallengePublishedNotification;
use App\Notifications\OfferPublishedNotification;
use App\Notifications\SolutionAddedNotification;
use App\Notifications\SolutionPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChallengeLikedNotification
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
     * @param  ChallengeLiked  $event
     * @return void
     */
    public function handle(ChallengeLiked $event)
    {
        $user = $event->subject->author;
        $challenge = Challenge::find($event->subject->challenge_id);
        $user->notify(new ChallengeLikedNotification($challenge));
    }
}
