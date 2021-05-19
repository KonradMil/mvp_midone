<?php

namespace App\Listeners;

use App\Events\ChallengePublished;
use App\Models\User;
use App\Notifications\ChallengePublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $integrators = User::where('type', '=', 'integrator')->get();
        foreach ($integrators as $integrator) {
            $integrator->notify(new ChallengePublishedNotification($event->subject));

        }
    }
}
