<?php

namespace App\Listeners;

use App\Events\CommentAdded;
use App\Events\OfferPublished;
use App\Events\SolutionPublished;
use App\Models\Challenges\Challenge;
use App\Models\Solutions\Solution;
use App\Models\User;
use App\Notifications\ChallengePublishedNotification;
use App\Notifications\CommentAddedNotification;
use App\Notifications\OfferPublishedNotification;
use App\Notifications\SolutionAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentAddedNotification
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
    public function handle(CommentAdded $event)
    {
        $user = $event->subject->author_id;
        $object = $event -> subject;
        $user->notify(new CommentAddedNotification($object));
    }
}
