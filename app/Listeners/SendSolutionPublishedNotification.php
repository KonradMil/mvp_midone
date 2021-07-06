<?php

namespace App\Listeners;

use App\Events\SolutionPublished;
use App\Models\Challenges\Challenge;
use App\Models\Solutions\Solution;
use App\Models\User;
use App\Notifications\ChallengePublishedNotification;
use App\Notifications\OfferPublishedNotification;
use App\Notifications\SolutionPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSolutionPublishedNotification
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
    public function handle(SolutionPublished $event)
    {
//            $user = User::find($event->subject->author_id);
        $user = $event->subject->author;
        $challenge = Challenge::find($event->subject->challenge_id);
        $client = User::find($challenge->author_id);
        $user->notify(new SolutionPublishedNotification($challenge, $event->subject));
        $client->notify(new SolutionPublishedNotification($challenge, $event->subject));
    }
}
