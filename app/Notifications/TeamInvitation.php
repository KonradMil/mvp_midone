<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamInvitation extends Notification
{
    use Queueable;

    protected $invitation;
    protected $team_name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invitation, $team)
    {
        $this->invitation = $invitation;
        $this->team_name = $team;
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
            'message' => 'Zostałeś zaproszony do zespołu: ' . $this->team_name,
            'link' => '/teams',
            'author' => $this->invitation->inviter,
            'name' => 'Teams',
        ]);
    }

    public function toDatabase($notifable)
    {
        return [
            'message' => 'Zostałeś zaproszony do zespołu: ' . $this->team_name,
            'link' => '/teams',
            'author' => $this->invitation->inviter,
            'name' => 'Teams',
        ];
    }
}
