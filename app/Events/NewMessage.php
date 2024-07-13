<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receiver;

    public $messageCount;

    public function __construct(User $receiver)
    {
        $this->receiver = $receiver;
        $this->messageCount = $receiver->unreadMessagesCountGropedByUsers();
    }

    public function broadcastOn()
    {
        return new Channel('messages.' . $this->receiver->id);
    }

    public function broadcastWith()
    {
        return [
            'messageCount' => $this->messageCount,
        ];
    }
}
