<?php

namespace App\Providers;

use App\Events\ChallengeAdded;
use App\Events\SolutionAdded;
use App\Events\TeamMemberInvited;
use App\Events\TeamMemberAccepted;
use App\Events\TeamAdded;
use App\Events\QuestionAdded;
use App\Events\QuestionAnswered;
use App\Events\SolutionAccepted;
use App\Listeners\AddActivityLog;
use App\Listeners\SendChallengeNotification;
use App\Listeners\SendSolutionNotification;
use App\Listeners\SendTeamMemberAcceptedNotification;
use App\Listeners\SendQuestionAddedNotification;
use App\Listeners\SendQuestionAnsweredNotification;
use App\Listeners\SendSolutionAcceptedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        SolutionAdded::class => [
            AddActivityLog::class,
            SendSolutionNotification::class
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
