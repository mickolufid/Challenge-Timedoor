<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Challenge30Mail extends Mailable
{
    use Queueable, SerializesModels;
    protected $name;
    protected $kodeAktifasi;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $kodeAktifasi)
    {
        $this->name = $name;
        $this->kodeAktifasi = $kodeAktifasi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("Challenge30@gmail.com")
                    ->view("emailAktivasi")
                    ->with(
                        [
                            'name' => $this->name,
                            'kodeAktifasi' => $this->kodeAktifasi
                        ]
                    );
    }
}
