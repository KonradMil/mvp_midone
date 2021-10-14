<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {

            return (new MailMessage)
                ->subject(__('emails.email_confirmation.subject'))
                ->greeting(__('emails.email_confirmation.greeting'))
                ->line(__('emails.email_confirmation.line1'))
                ->action(__('emails.email_confirmation.action'), $url)
                ->line(__('emails.email_confirmation.line2'));

        });
    }
}
