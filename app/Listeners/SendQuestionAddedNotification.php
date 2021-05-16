<?php

namespace App\Listeners;

use App\Events\QuestionAdded;
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
        //
    }
}
