<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RaceTicketQrCode
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $participantTicketId;
    public $user;
    public $ticket;
    public $self;
    public $other;
    public $fromUser;
    public $newAccount;

    /**
     * Create a new event instance.
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
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
