<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamInvitation extends Mailable
{
    use Queueable, SerializesModels;

    protected $invite;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @param $invite
     * @param $name
     */
    public function __construct($invite, $name)
    {
        $this->invite = $invite;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): TeamInvitation
    {
        return $this->view('emails.team_invitation')->with([ 'invite' => $this->invite, 'name' => $this->name]);
    }
}
