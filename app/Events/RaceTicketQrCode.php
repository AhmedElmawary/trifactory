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
    public $race;
    public $event;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($participantTicketId, $user, $race, $event)
    {
        $this->participantTicketId = $participantTicketId;
        $this->user = $user;
        $this->race = $race;
        $this->event = $event;
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
