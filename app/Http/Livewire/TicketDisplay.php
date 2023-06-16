<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use Carbon\Carbon;
use Livewire\Component;
use Throwable;

class TicketDisplay extends Component
{
    public Ticket|null $ticket = null;

    public $connection = true;
    public $count = 0;
    public $ticket_key = null;

    protected $listeners = ['refreshComponent'=>'$refresh'];

    public function mount(){

        if ($this->ticket_key){
            $this->ticket = Ticket::where('key',$this->ticket_key)->first();
        }

    }

    public function render()
    {
        if ($this->ticket){
            $this->count = Ticket::where(['service_id'=>$this->ticket->service_id,'status'=>Ticket::STATUS_WAITING])
                ->where('number','<',$this->ticket->number)
                ->whereDate('created_at',Carbon::today())
                ->count();
        }
        return view('livewire.ticket-display');
    }

    public function disconnected(){
        $this->connection = false;
        $this->emitSelf('refreshComponent');
    }
//    public function failed(Throwable $e)
//    {
//        dd('filed');
//        //event(new ConnectionLost());
//    }
}
