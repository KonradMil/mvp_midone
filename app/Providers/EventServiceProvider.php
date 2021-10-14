<?php

namespace App\Providers;

use App\Events\ChallengeAdded;
use App\Events\ChallengeFollowed;
use App\Events\ChallengeLiked;
use App\Events\CommentAdded;
use App\Events\OfferAccepted;
use App\Events\OfferAdded;
use App\Events\OfferPublished;
use App\Events\OfferRejected;
use App\Events\SolutionAdded;
use App\Events\SolutionDisliked;
use App\Events\SolutionLiked;
use App\Events\SolutionRejected;
use App\Events\TeamMemberInvited;
use App\Events\TeamMemberAccepted;
use App\Events\TeamAdded;
use App\Events\QuestionAdded;
use App\Events\QuestionAnswered;
use App\Events\SolutionAccepted;
use App\Events\ChallengePublished;
use App\Events\SolutionPublished;
use App\Listeners\AddActivityLog;
use App\Listeners\SendChallengeFollowedNotification;
use App\Listeners\SendChallengeLikedNotification;
use App\Listeners\SendChallengeNotification;
use App\Listeners\SendCommentAddedNotification;
use App\Listeners\SendOfferAcceptedNotification;
use App\Listeners\SendOfferAddedNotification;
use App\Listeners\SendOfferPublishedNotification;
use App\Listeners\SendOfferRejectedNotification;
use App\Listeners\SendSolutionAddedNotification;
use App\Listeners\SendSolutionDislikedNotification;
use App\Listeners\SendSolutionLikedNotification;
use App\Listeners\SendSolutionRejectedNotification;
use App\Listeners\SendTeamMemberAcceptedNotification;
use App\Listeners\SendQuestionAddedNotification;
use App\Listeners\SendQuestionAnsweredNotification;
use App\Listeners\SendSolutionAcceptedNotification;
use App\Listeners\SendSolutionPublishedNotification;
use App\Listeners\SendChallengePublishedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UserRegisteredEvent;
use App\Listeners\UserRegisteredListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ChallengeAdded::class => [
            AddActivityLog::class,
            SendChallengeNotification::class
        ],
        TeamMemberInvited::class => [
            AddActivityLog::class,
        ],
        TeamMemberAccepted::class => [
            AddActivityLog::class,
            SendTeamMemberAcceptedNotification::class
        ],
        TeamAdded::class => [
            AddActivityLog::class
        ],
        QuestionAdded::class => [
            AddActivityLog::class,
            SendQuestionAddedNotification::class,
        ],
        QuestionAnswered::class => [
            AddActivityLog::class,
            SendQuestionAnsweredNotification::class
        ],
        SolutionAccepted::class => [
            AddActivityLog::class,
            SendSolutionAcceptedNotification::class
        ],
        SolutionRejected::class => [
            AddActivityLog::class,
            SendSolutionRejectedNotification::class
        ],
        ChallengePublished::class => [
            AddActivityLog::class,
            SendChallengePublishedNotification::class
        ],
        SolutionPublished::class => [
            AddActivityLog::class,
            SendSolutionPublishedNotification::class
        ],
        SolutionAdded::class => [
            AddActivityLog::class,
            SendSolutionAddedNotification::class
        ],
        SolutionLiked::class => [
            AddActivityLog::class,
            SendSolutionLikedNotification::class
        ],
        SolutionDisliked::class => [
            AddActivityLog::class,
            SendSolutionDislikedNotification::class
        ],
        OfferPublished::class => [
            AddActivityLog::class,
            SendOfferPublishedNotification::class
        ],
        OfferAdded::class => [
            AddActivityLog::class,
            SendOfferAddedNotification::class
        ],
        OfferAccepted::class => [
            AddActivityLog::class,
            SendOfferAcceptedNotification::class
        ],
        OfferRejected::class => [
            AddActivityLog::class,
            SendOfferRejectedNotification::class
        ],
        CommentAdded::class => [
            AddActivityLog::class,
            SendCommentAddedNotification::class
        ],
        ChallengeFollowed::class => [
            AddActivityLog::class,
            SendChallengeFollowedNotification::class
        ],
        ChallengeLiked::class => [
            AddActivityLog::class,
            SendChallengeLikedNotification::class
        ],
        UserRegisteredEvent::class => [
            UserRegisteredListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
