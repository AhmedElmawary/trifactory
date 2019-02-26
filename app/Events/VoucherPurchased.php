<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VoucherPurchased
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $meta;
    public $user;
    public $order;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $meta, $user)
    {
        $this->meta = $meta;
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
