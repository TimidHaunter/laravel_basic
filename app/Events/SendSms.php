<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendSms
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $phone;
    public $userId;
//    public $product;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($phone, $userId)
    {
        $this->phone = $phone;
        $this->userId = $userId;
//        $this->product = $product;
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
