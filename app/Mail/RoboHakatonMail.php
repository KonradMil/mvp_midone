<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoboHakatonMail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Build the message
     */
    public function build(): RoboHakatonMail
    {
        return $this
            ->subject("DBR77: Dziękujemy za zgłoszenie do RoboHakaton")
            ->view('emails.robo_hakaton');
    }
}
