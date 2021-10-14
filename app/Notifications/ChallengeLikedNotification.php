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
    public $member;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($challenge, $member)
    {
        $this->challenge = $challenge;
        $this->member = $member;
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
            'message' => $this->member->name . ' ' . $this->member->lastname .' lubi Twoje wyzwanie: ' . $this->challenge->name .'.',
            'link' => '/challenges/card/' . $this->challenge->id,
            'author' => $this->challenge->author,
            'params' => 'likeChallenge',
            'name' => 'internalChallenegeCard',
            'id' => $this->challenge->id,
        ]);
    }

    public function toDatabase($notifable)
    {
        return [
            'message' => $this->member->name . ' ' . $this->member->lastname .' lubi Twoje wyzwanie: ' . $this->challenge->name .'.',
            'link' => '/challenges/card/' . $this->challenge->id,
            'author' => $this->challenge->author,
            'params' => 'likeChallenge',
            'name' => 'internalChallenegeCard',
            'id' => $this->challenge->id,
        ];
    }
}
