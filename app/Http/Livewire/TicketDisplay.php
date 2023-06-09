<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use Livewire\Component;

class TicketDisplay extends Component
{
    public Ticket|null $ticket = null;

    public $count = 0;
    public $ticket_key = null;

    public function mount(){

        if ($this->ticket_key){
            $this->ticket = Ticket::where('key',$this->ticket_key)->first();
        }

    }

    public function render()
    {
        if ($this->ticket){
            $this->count = Ticket::where(['service_id'=>$this->ticket->service_id,'status'=>Ticket::STATUS_WAITING])->where('number','<',$this->ticket->number)->count();
        }

        return view('livewire.ticket-display');
    }
}
