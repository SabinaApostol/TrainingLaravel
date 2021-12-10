<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendEmailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $products = [];
    public $name, $email, $comments;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($products, $name, $email, $comments)
    {
        $this->products = $products;
        $this->name = $name;
        $this->email = $email;
        $this->comments = $comments;
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
