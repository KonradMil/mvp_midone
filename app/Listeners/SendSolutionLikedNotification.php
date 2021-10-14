<?php

namespace App\Listeners;

use App\Events\SolutionAccepted;
use App\Events\SolutionLiked;
use App\Models\Challenge;
use App\Models\Solution;
use App\Models\User;
use App\Notifications\SolutionAcceptedNotification;
use App\Notifications\SolutionLikedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSolutionLikedNotification
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
     * @param  SolutionLiked  $event
     * @return void
     */
    public function handle(SolutionLiked $event)
    {
        $user = $event->subject->author;
        $member = User::find($event->causer->id);
        $solution = Solution::find($event->subject->id);
        $challenge = Challenge::find($event->subject->challenge_id);

        $user->notify(new SolutionLikedNotification($challenge, $solution, $member));
    }
}
