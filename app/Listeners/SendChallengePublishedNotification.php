<?php

namespace App\Listeners;

use App\Events\ChallengePublished;
use App\Models\User;
use App\Notifications\ChallengePublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SendChallengePublishedNotification
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
     * @param  ChallengePublished  $event
     * @return void
     */
    public function handle(ChallengePublished $event)
    {
        $user = Auth::user();
        $challenge = $event -> subject;
        $integrators = User::where('type', '=', 'integrator')->get();
        foreach ($integrators as $integrator) {
            $integrator->notify(new ChallengePublishedNotification($event->subject));
        }
        foreach($challenge->teams as $team){
             foreach($team->users as $user){
                 $user->notify(new ChallengePublishedNotification($event->subject));
             }
        }
    }
}
