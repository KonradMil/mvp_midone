<?php

namespace App\Listeners;

use App\Events\ChallengeFollowed;
use App\Events\OfferAccepted;
use App\Events\SolutionAccepted;
use App\Models\Challenge;
use App\Models\Solution;
use App\Models\User;
use App\Notifications\ChallengeFollowedNotification;
use App\Notifications\OfferAcceptedNotification;
use App\Notifications\SolutionAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChallengeFollowedNotification
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
    public function handle(ChallengeFollowed $event)
    {
        $user = $event->subject->author_id;
        $challenge = Challenge::find($event->subject->id);
        $user->notify(new ChallengeFollowedNotification($challenge));
    }
}
