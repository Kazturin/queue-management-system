<?php

namespace App\Http\Livewire;

use App\Events\TestEvent;
use App\Events\TicketCreated;
use App\Events\TicketCreatedEvent;
use Livewire\Component;

class Ticket extends Component
{
    public $service_id;
    public $name;
    public $abbr;

    public function mount($service)
    {
        $this->service_id = $service->id;
        $this->name = $service->name;
        $this->abbr = $service->abbreviation;
    }

    public function save(){
      //  dd($this->getTicketNumber());
        $ticket = \App\Models\Ticket::create([
            'number' => $this->getTicketNumber(),
            'operator_id' => null,
            'status' => \App\Models\Ticket::STATUS_WAITING,
            'service_id' => $this->service_id
        ]);

      //  TicketCreatedEvent::dispatch($ticket);
        return redirect()->route('display');
      //  event(new TicketCreatedEvent($ticket));
     //   session()->flash('success', 'Success!');
    }

    public function getTicketNumber(){
        $ticket = \App\Models\Ticket::where('service_id',$this->service_id)->orderByDesc('id')->first();

        if ($ticket){
            $number = preg_replace('/[^0-9]/', '', $ticket->number);
            return $this->abbr.strval($number+1);
        }
       // dd($this->abbr);
        return $this->abbr.'1';
    }

    public function render()
    {
        return view('livewire.ticket');
    }
}
