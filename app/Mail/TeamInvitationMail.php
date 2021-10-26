<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $email;

    protected string $teamName;

    protected string $confirmationToken;

    /**
     * Create a new message instance.
     *
     * @param string $email
     * @param string $teamName
     * @param string $confirmationToken
     */
    public function __construct(string $email, string $teamName, string $confirmationToken)
    {
        $this->email = $email;
        $this->teamName = $teamName;
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * Build the message
     */
    public function build(): TeamInvitationMail
    {
        return $this->view('emails.team_invitation')
            ->subject("DBR77: Zaproszenie do zespołu")
            ->with([
                'teamName' => $this->teamName,
                'confirmationToken' => $this->confirmationToken
            ]);
    }
}
