<?php

namespace App\Events;

use App\Models\OperatorService;
use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Ticket $ticket;

    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }


    public function broadcastOn()
    {
        return new Channel('public.ticket.created');
      //      new Channel('public.test.1'),
    }

    public function broadcastAs()
    {
        return 'ticketCreated';
    }

    public function broadcastWhen()
    {
        $allowServicesIds = OperatorService::where('operator_id',auth()->user()->id)->pluck('service_id')->toArray();
       // dd($allowServicesIds);
        return in_array($this->ticket->service_id,$allowServicesIds);
    }

//    public function broadcastWith(){
//        return Ticket::where('status',Ticket::STATUS_IN_PROGRESS)->with('operator')->orderBy('updated_at','desc')->get()->toArray();
//    }
}
