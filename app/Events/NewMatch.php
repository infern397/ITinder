<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMatch implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $receiver;
    public int $matchesCount;

    /**
     * Create a new event instance.
     */
    public function __construct(User $receiver)
    {
        $this->receiver = $receiver;
        $this->matchesCount = $receiver->newMatchesReceivedCount();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('matches.' . $this->receiver->id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'matchesCount' => $this->matchesCount,
        ];
    }
}
