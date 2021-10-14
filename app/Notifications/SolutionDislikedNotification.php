<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolutionDislikedNotification extends Notification
{
    use Queueable;
    public $challenge;
    public $solution;
    public $member;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($challenge, $solution, $member)
    {
        $this->challenge = $challenge;
        $this->solution = $solution;
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
        return ['database'];
    }

    public function toDatabase($notifable)
    {
        return [
            'message' => $this->member->name . ' ' . $this->member->lastname .' nie lubi Twojego rozwiązania: ' . $this->solution->name .'.',
            'link' => '/challenges/card/' . $this->challenge->id,
            'author' => $this->challenge->author,
            'params' => 'rozwiazania',
            'name' => 'internalChallenegeCard',
            'id' => $this->challenge->id,
        ];
    }
}
