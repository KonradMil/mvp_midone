<?php

namespace App\Listeners;

use App\Events\QuestionAdded;
use App\Models\Challenge;
use App\Models\User;
use App\Notifications\ChallengePublishedNotification;
use App\Notifications\QuestionAddedNotidiaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendQuestionAddedNotification
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
     * @param  QuestionAdded  $event
     * @return void
     */
    public function handle(QuestionAdded $event)
    {
        $challenge = Challenge::find($event->subject->challege_id);

        $investor= User::find($challenge->author_id);
        $investor->notify(new QuestionAddedNotidiaction($event));
    }
}
