<?php

namespace App\Filament\Pages;

use App\Events\TestEvent;
use App\Events\TicketCreatedEvent;
use App\Models\OperatorService;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Pages\Page;
// use Livewire\WithPagination;

class TakeTickets extends Page
{

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-copy';
    //  use WithPagination;
 //   protected static ?string $title = 'Талондарды шақыру';

    public Ticket|null $ticket = null;

    public $tickets;

    public $ticketsCount = 0;

    protected static function getNavigationLabel(): string
    {
        return __('Acceptance of coupons');
    }

    public $allowServicesIds = [];

    public bool $invitation = false;

    protected static string $view = 'filament.pages.take-tickets';

    protected $listeners = [
        'recordUpdated',
    ];
    //  public bool $testBool;

    protected static function shouldRegisterNavigation(): bool
    {
        $user = User::find(auth()->user()->id);
        if ($user && $user->hasRole('Operator')){
            return true;
        };
        return false;
    }


    protected function getHeading(): string
    {
        return __('Acceptance of coupons');
    }

    public function mount(){
        //     $this->testBool = in_array(auth()->user()->id,[5,2]);
        $this->allowServicesIds = auth()->user()->services->pluck('id');
        $this->tickets = Ticket::with('service')
            ->whereIn('service_id',$this->allowServicesIds)
            ->where('status',Ticket::STATUS_WAITING)
            ->whereDate('created_at',Carbon::today())
            ->orderBy('id')
            ->limit(20)
            ->get();
        $this->ticketsCount = Ticket::where('operator_id',auth()->user()->id)->whereDate('created_at',Carbon::today())->count();
    }

    public function getTicket(){

        // dd($this->test);
        // dd($this->tickets);

        $ticket = $this->getFirstTicket();
        if ($ticket){
            $ticket->status = Ticket::STATUS_IN_PROGRESS;
            if($ticket->save()){
                TestEvent::dispatch($ticket);
                $this->ticket = $ticket;
                $this->ticketsCount++;
                $this->recordUpdated();
                //  $this->ticketsCount = Ticket::where('operator_id',auth()->user()->id)->whereDate('created_at',Carbon::today())->count();
                $this->invitation = true;
            }
            else{
                $this->getTicket();
            }
        } else {
            Filament::notify('warning', 'Кезек бос');
        }
        return null;
    }

    public function closeTicket(){
        $this->ticket = null;
        $this->invitation = false;
        // $this->emit('refreshComponent');
        //   $this->tickets = Ticket::whereIn('service_id',$this->allowServicesIds)->where('status',Ticket::STATUS_WAITING)->orderBy('id')->get();
    }

    public function recordUpdated(){
        $this->tickets = Ticket::with('service')
            ->whereIn('service_id',$this->allowServicesIds)
            ->where('status',Ticket::STATUS_WAITING)
            ->whereDate('created_at',Carbon::today())
            ->orderBy('id')
            ->limit(20)
            ->get();
    }

    public function getFirstTicket(){
        return Ticket::with('service')
            ->whereIn('service_id',$this->allowServicesIds)
            ->where('status',Ticket::STATUS_WAITING)
            ->whereDate('created_at',Carbon::today())
            ->orderBy('id')
            ->first();
    }

}
