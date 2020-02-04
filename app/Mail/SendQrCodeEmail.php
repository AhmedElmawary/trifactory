<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendQrCodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $participantTicketId;
    public $user;
    public $ticket;
    public $self;
    public $other;
    public $fromUser;
    public $newAccount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($participantTicketId, $user, $ticket, $self, $other, $fromUser, $newAccount)
    {
        $this->participantTicketId = $participantTicketId;
        $this->user = $user;
        $this->ticket = $ticket;
        $this->self = $self;
        $this->other = $other;
        $this->fromUser = $fromUser;
        $this->newAccount = $newAccount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject((preg_match("/mudder/i", $this->ticket->Event)) ?
                "Tough Mudder - Ticket information" : 'The TriFactory - Ticket information')
            ->view('emails.send-ticket', [
                'ticketId' => $this->participantTicketId,
                'user' => $this->user,
                'ticket' => $this->ticket,
                'self' => $this->self,
                'other' => $this->other,
                'fromUser' => $this->fromUser,
                'newAccount' => $this->newAccount,
            ]);
    }
}
