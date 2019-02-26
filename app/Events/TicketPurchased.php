<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketPurchased
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticketId;
    public $ticket;
    public $user;
    public $order;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $ticketId, $ticket, $user)
    {
        $this->ticketId = $ticketId;
        $this->ticket = $ticket;
        $this->user = $user;
        $this->order = $order;
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
