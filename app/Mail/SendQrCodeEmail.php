<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendQrCodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticketId;
    public $user;
    public $race;
    public $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticketId, $user, $race, $event)
    {
        $this->user = $user;
        $this->ticketId = $ticketId;
        $this->race = $race;
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('The TriFactory - Ticket information')
            ->view('emails.send-qr-code', [
                'ticketId' => $this->ticketId,
                'user' => $this->user,
                'race' => $this->race,
                'event' => $this->event
            ]);
    }
}
