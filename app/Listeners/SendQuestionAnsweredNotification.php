<?php

namespace App\Listeners;

use App\Events\QuestionAnswered;
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
        //
    }
}
