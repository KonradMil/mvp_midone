<?php

namespace App\Listeners;

use App\Events\QuestionAnswered;
use App\Models\Challenge;
use App\Models\User;
use App\Notifications\QuestionAddedNotidiaction;
use App\Notifications\QuestionAnsweredNotidiaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendQuestionAnsweredNotification
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
     * @param  QuestionAnswered  $event
     * @return void
     */
    public function handle(QuestionAnswered $event)
    {
        $challenge = Challenge::find($event->subject->challege_id);

        $investor= User::find($challenge->author_id);
        $investor->notify(new QuestionAnsweredNotidiaction($event));
    }
}
