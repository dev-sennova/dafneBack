<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingModeration extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $description;
    public $createdAt;
    public $expiresAt;
    public $nombre;

    /**
     * Create a new message instance.
     *
     * @param string $type
     * @param string $description
     * @param \Carbon\Carbon $createdAt
     * @param \Carbon\Carbon $expiresAt
     * @return void
     */
    public function __construct($type, $description, $createdAt, $expiresAt, $nombre)
    {
        $this->type = $type;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->expiresAt = $expiresAt;
        $this->nombre = $nombre;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.pending_moderation')
                    ->subject('' . $this->type . ' pendiente de moderación')
                    ->with([
                        'type' => $this->type,
                        'description' => $this->description,
                        'createdAt' => $this->createdAt,
                        'expiresAt' => $this->expiresAt,
                        'nombre'=>$this->nombre

                    ]);
    }
}
