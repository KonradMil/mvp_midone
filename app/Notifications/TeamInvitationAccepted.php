<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamInvitationAccepted extends Notification
{
    use Queueable;
    public $team;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($team)
    {
        $this->team = $team;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','broadcast', 'database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'Użytkownik zaakceptował zaproszenie do Twojego zespołu: ' . $this->team->name .'.',
            'link' => '/teams',
            'params' => '',
            'name' => 'Teams',
            'id' => ''
        ]);
    }

    public function toDatabase($notifable)
    {
        return [
            'message' => 'Użytkownik zaakceptował zaproszenie do Twojego zespołu: ' . $this->team->name .'.',
            'link' => '/teams',
            'params' => '',
            'name' => 'Teams',
            'id' => '',
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
