<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use Carbon\Carbon;
use Livewire\Component;

class TicketsDisplay extends Component
{
    public $tickets = null;

    public $connection = false;
    //protected $listeners = ['echo:public.test.updated,.updated' => 'test'];

    protected $listeners = [
        'recordUpdated',
        'connected',
        'disconnected',
        'refreshComponent' => '$refresh'
    ];

    public function mount(){

        $this->tickets = $this->getTickets();

      // dd(array_splice($this->tickets, 1 ));
    }

    public function render()
    {
        return view('livewire.tickets-display');
    }

    public function recordUpdated(){
        //$this->test = $event;
        $this->tickets = $this->getTickets();
    }

    public function getTickets(){
        return Ticket::where('status',Ticket::STATUS_IN_PROGRESS)
            ->whereDate('created_at',Carbon::today())
            ->with('operator')
            ->orderBy('updated_at','desc')
            ->limit(11)
            ->get()
            ->toArray();
    }

    public function connected(){
        $this->connection = true;
        $this->emitSelf('refreshComponent');
    }

    public function disconnected(){
        $this->connection = false;
        $this->emitSelf('refreshComponent');
    }
}
