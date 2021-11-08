<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferAcceptedNotification extends Notification
{
    use Queueable;
    public $solution;
    public $challenge;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($challenge, $solution)
    {
        $this->challenge = $challenge;
        $this->solution = $solution;
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
            ->subject('DBR77: Oferta zaakceptowana')
            ->line('Zaakceptowano ofertę dla wyzwania: ' . $this->challenge->name .'.')
            ->action('Sprawdź', url(env('APP_PATH') . '/projects/card/' . $this->challenge->id))
            ->line('Dziękujemy za korzystanie z platformy DBR77!');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'Oferta została zaakceptowana do wyzwania: ' . $this->challenge->name .'.',
            'link' => '/projects/card/' . $this->challenge->id,
            'author' => $this->challenge->author,
            'params' => 'all-offers',
            'name' => 'projectCard',
            'id' => $this->challenge->id,
        ]);
    }

    public function toDatabase($notifable)
    {
        return [
            'message' => 'Oferta została zaakceptowana do wyzwania: ' . $this->challenge->name .'.',
            'link' => '/projects/card/' . $this->challenge->id,
            'author' => $this->challenge->author,
            'params' => 'all-offers',
            'name' => 'projectCard',
            'id' => $this->challenge->id,
        ];
    }
}
