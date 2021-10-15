<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoboHakatonReportMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    private $users = [];

    public function __construct(User $user, $users){

        $this->user = $user;
        $this->users = $users;

    }

    /**
     * Build the message
     */
    public function build(): RoboHakatonReportMail
    {
        return $this
            ->subject("ROBOHAKATON: Nowe zgłoszenie do konkursu")
            ->view('emails.robo_hakaton_report', [
                'user' => $this->user,
                'users' => $this->users
            ]);
    }
}
