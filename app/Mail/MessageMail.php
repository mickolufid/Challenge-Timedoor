<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $name;
    protected $activationCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $activationCode)
    {
        $this->name = $name;
        $this->activationCode = $activationCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("admin@chalenge.com")
                    ->view("auth.emailAktivasi")
                    ->with(
                        [
                            'name' => $this->name,
                            'activationCode' => $this->activationCode
                        ]
                    );
    }
}
