<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Mail\MailConfirmation;
use Illuminate\Support\Facades\Mail;

class UserRegisteredListener
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
     * @param UserRegisteredEvent $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
        Mail::to($event->user->email)->send(new MailConfirmation($event->user->confirmation_token));
    }
}
