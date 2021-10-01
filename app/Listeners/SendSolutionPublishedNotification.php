<?php

namespace App\Listeners;

use App\Events\SolutionPublished;
use App\Models\Challenge;
use App\Models\Solution;
use App\Models\User;
use App\Notifications\ChallengePublishedNotification;
use App\Notifications\OfferPublishedNotification;
use App\Notifications\SolutionPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Password;

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
        $user = $event->subject->author;
        $challenge = Challenge::find($event->subject->challenge_id);
        $client = User::find($challenge->author_id);
        $solution = Solution::find($event->subject->id);
        foreach($solution->teams as $team){
            foreach($user->teams as $t){
                if($team->id == $t->id){
                    foreach($t->users as $member){
                        $member->notify(new SolutionPublishedNotification($challenge, $event->subject));
                    }
                }
            }
        }
//        $user->notify(new SolutionPublishedNotification($challenge, $event->subject));
        $client->notify(new SolutionPublishedNotification($challenge, $event->subject));
    }
}
