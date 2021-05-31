<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChallengePublishedNotification extends Notification
{
    use Queueable;
    public $challenge;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($challenge)
    {
        $this->challenge = $challenge;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Nowe wyzwanie zostało opublikowane.')
                    ->action('Sprawdź', url('https://two.appworks-dev.pl/challenges/card/' . $this->challenge->id))
                    ->line('Dziękujemy za korzystanie z platformy DBR77!');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'Nowe wyzwanie zostało opublikowane: ' . $this->challenge->name,
            'link' => '/challenges/card/' . $this->challenge->id,
            'author' => $this->challenge->author,
        ]);
    }

    public function toDatabase($notifable)
    {
        return [
            'message' => 'Nowe wyzwanie zostało opublikowane: ' . $this->challenge->name,
            'link' => '/challenges/card/' . $this->challenge->id,
            'author' => $this->challenge->author,
        ];
    }
}
