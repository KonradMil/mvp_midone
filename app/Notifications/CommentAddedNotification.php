<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentAddedNotification extends Notification
{
    use Queueable;
    public $object;
    public $member;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($object, $member)
    {
        $this->object = $object;
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
            'message' => $this->member->name . $this->member->lastname . 'skomentował: ' . $this->object->name .'.',
            'link' => '/challenges/card/' . $this->object->id,
            'author' => $this->object->author,
            'params' => 'rozwiazania',
            'name' => 'internalChallenegeCard',
            'id' => $this->challenge->id,
        ]);
    }

    public function toDatabase($notifable)
    {
        return [
            'message' => $this->member->name . $this->member->lastname . 'skomentował: ' . $this->object->name .'.',
            'link' => '/challenges/card/' . $this->object->id,
            'author' => $this->object->author,
        ];
    }
}
