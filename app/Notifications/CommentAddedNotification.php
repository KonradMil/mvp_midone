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

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($object)
    {
        $this->object = $object;
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
            'message' => 'Masz nowy komentarz!: ' . $this->object->name .'.',
            'link' => '/challenges/card/' . $this->object->id,
            'author' => $this->object->author,
        ]);
    }

    public function toDatabase($notifable)
    {
        return [
            'message' => 'Masz nowy komentarz!>: ' . $this->object->name .'.',
            'link' => '/challenges/card/' . $this->object->id,
            'author' => $this->object->author,
        ];
    }
}
