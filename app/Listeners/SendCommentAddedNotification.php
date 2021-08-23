<?php

namespace App\Listeners;

use App\Events\CommentAdded;
use App\Events\OfferPublished;
use App\Events\SolutionPublished;
use App\Models\Challenge;
use App\Models\Solution;
use App\Models\User;
use App\Notifications\ChallengePublishedNotification;
use App\Notifications\CommentAddedNotification;
use App\Notifications\CommentChallengeAddedNotification;
use App\Notifications\CommentSolutionAddedNotification;
use App\Notifications\OfferPublishedNotification;
use App\Notifications\SolutionAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

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
     * @param  CommentAdded  $event
     * @return void
     */
    public function handle(CommentAdded $event)
    {
        $user = $event->subject->author;
        $member = User::find(Auth::user()->id);

//        $object = $event -> subject;
        $challenge = Challenge::find($event->subject->challenge_id);
        if($challenge===NULL){
            $challenge_new = Challenge::find($event->subject->id);
            $user->notify(new CommentChallengeAddedNotification($challenge_new, $member));
        } else {
            $solution = Solution::find($event->subject->id);
            $challenge = Challenge::find($solution->challenge_id);
            $user->notify(new CommentSolutionAddedNotification($challenge, $solution, $member));
        }
    }
}
