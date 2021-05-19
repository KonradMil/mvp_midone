<?php

namespace App\Listeners;

use App\Events\SolutionPublished;
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
        //
    }
}