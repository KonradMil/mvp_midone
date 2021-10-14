<?php

namespace App\Notifications;

use App\Models\Challenge;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionAddedNotidiaction extends Notification
{
    use Queueable;
    public $event;
    public $challenge;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $challenge = Challenge::find($this->event->subject->challenge_id);
        $this->challenge = $challenge;
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
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
            ->subject('DBR77: pytanie do wyzwania')
            ->line('Nowe pytanie zostało dodane do Twojego wyzwania ' . $this->challenge->name . '.')
            ->action('Sprawdź', url(env('APP_PATH') . '/challenges/card/' . $this->challenge->id))
            ->line('Dziękujemy za korzystanie z platformy DBR77!');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'Nowe pytanie zostało dodane do Twojego wyzwania: ' . $this->challenge->name,
            'link' => url(env('APP_PATH') . '/challenges/card/' . $this->challenge->id),
            'author' => $this->event->causer,
        ]);
    }

    public function toDatabase($notifable)
    {
        return [
            'message' => 'Nowe pytanie zostało dodane do Twojego wyzwania: ' . $this->challenge->name,
            'link' => url(env('APP_PATH') . '/challenges/card/' . $this->challenge->id),
            'author' => $this->event->causer,
        ];
    }
}
