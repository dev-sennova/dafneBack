<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $pin;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pin,$name)
    {
        $this->pin = $pin;
        $this->name=$name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.registro')
                    ->with([
                        'pin' => $this->pin,
                    ]);
    }
}
