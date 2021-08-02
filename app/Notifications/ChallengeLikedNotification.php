<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChallengeLikedNotification extends Notification
{
    use Queueable;
    public $challenge;
    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($challenge, $user)
    {
        $this->challenge = $challenge;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'Użytkownik ' . $this->user->name . ' ' . $this->user->lastname .' polubił wyzwanie: ' . $this->challenge->name .'.',
            'link' => '/challenges/card/' . $this->challenge->id,
            'author' => $this->challenge->author,
            'params' => '',
            'name' => 'internalChallenegeCard',
            'id' => $this->challenge->id,
        ]);
    }

    public function toDatabase($notifable)
    {
        return [
            'message' => 'Użytkownik ' . $this->user->name . ' ' . $this->user->lastname .' polubił wyzwanie: ' . $this->challenge->name .'.',
            'link' => '/challenges/card/' . $this->challenge->id,
            'author' => $this->challenge->author,
            'params' => '',
            'name' => 'internalChallenegeCard',
            'id' => $this->challenge->id,
        ];
    }
}
