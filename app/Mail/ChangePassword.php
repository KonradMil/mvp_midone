<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangePassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;

    /**
     * Create a new message instance.
     *
     * @param $invite
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.change_password')->with(['name' => $this->name]);
    }
}
