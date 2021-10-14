<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChallengeLiked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $subject;
    public $causer;
    public $message;
    public $props;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subject, $causer, $message, $props = [])
    {
        $this->subject = $subject;
        $this->causer = $causer;
        $this->message = $message;
        $this->props = $props;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
