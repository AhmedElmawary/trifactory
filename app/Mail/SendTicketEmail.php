<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicketEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ticketId;
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
    public function __construct($ticketId, $user, $ticket, $self, $other, $fromUser, $newAccount)
    {
        $this->user = $user;
        $this->ticketId = $ticketId;
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
                ->subject('The Trifactory - Ticket information')
                ->view('emails.send-ticket', [
                    'ticketId' => $this->ticketId,
                    'user' => $this->user,
                    'ticket' => $this->ticket,
                    'self' => $this->self,
                    'other' => $this->other,
                    'fromUser' => $this->fromUser,
                    'newAccount' => $this->newAccount,
                ]);
    }
}
