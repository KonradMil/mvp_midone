<?php

namespace App\Listeners;

use App\Events\ChallengeLiked;
use App\Events\SolutionAccepted;
use App\Events\SolutionLiked;
use App\Models\Challenge;
use App\Models\User;
use App\Notifications\ChallengeLikedNotification;
use App\Notifications\SolutionAcceptedNotification;
use App\Notifications\SolutionLikedNotification;
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
        $member = User::find($event->causer->id);
        $challenge = Challenge::find($event->subject->id);
        $user->notify(new ChallengeLikedNotification($challenge, $member));
    }
}
