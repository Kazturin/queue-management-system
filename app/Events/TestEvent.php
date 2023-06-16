<?php

namespace App\Events;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
//    public function __construct()
//    {
//        //
//    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            //new PrivateChannel('channel-name'),
            new Channel('public.test.updated'),
        ];
    }

    public function broadcastAs()
    {
        return 'updated';
    }

    public function broadcastWith(){
        return Ticket::where('status',Ticket::STATUS_IN_PROGRESS)
            ->whereDate('created_at',Carbon::today())
            ->with('operator')
            ->orderBy('updated_at','desc')
            ->limit(11)
            ->get()
            ->toArray();
    }
}
