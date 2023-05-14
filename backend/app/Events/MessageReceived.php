<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Chat;
use Illuminate\Http\Request;

class MessageReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $message;
    public $sender;
    public $receiver;
    public function __construct($data)
    {
        $this->message = $data['message'];
        $this->sender = $data['sender'];
        $this->receiver = $data['receiver'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastWith(){
        return [
            'message' => $this->message,
            'sender' => $this->sender,
            'receiver' => $this->receiver,
        ];
    }

    public function broadcastAs()
    {
        return 'chat_event';
    }
}
