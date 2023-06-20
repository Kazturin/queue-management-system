<?php


namespace App\Http\Controllers;


use App\Events\TestEvent;
use App\Events\TicketCreatedEvent;
use App\Helpers\ArrayHelper;
use App\Models\OperatorService;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Echo_;
use Ratchet\Server\EchoServer;

class SiteController extends Controller
{
    public function services(){

//        $user = User::find(11);
//
//        dd($user->services->pluck('id')->contains(6));

        $services = Service::all();

        return view('site.services',compact('services'));

    }

    public function ticketCreate(Service $service){

        $ticket = \App\Models\Ticket::create([
            'number' => $this->getTicketNumber($service),
            'operator_id' => null,
            'status' => \App\Models\Ticket::STATUS_WAITING,
            'service_id' => $service->id,
            'key' => Str::random(20)
        ]);

        TicketCreatedEvent::dispatch($ticket);

     //   event(new TicketCreatedEvent($ticket));

        return redirect()->route('ticket', ['key'=>$ticket->key]);
    }

    public function ticket(Request $request, string $key){

        if ($request->id){
            $ticket = Ticket::where('key',$key)->first();
           // $ticket->delete();
            TestEvent::dispatch($ticket);
            $ticket->delete();
            return redirect()->back();
        }

        return view('site.ticket',compact('key'));
    }

    public function display(){

        $data = Ticket::where('status',Ticket::STATUS_IN_PROGRESS)->with('operator')->orderBy('updated_at','desc')->limit(10)->get()->toArray();

        return view('site.display',compact('data'));
    }
    private function getTicketNumber(Service $service){
        $ticket = \App\Models\Ticket::where('service_id',$service->id)->orderByDesc('id')->first();

        if ($ticket){
            $number = preg_replace('/[^0-9]/', '', $ticket->number);
            return $service->abbreviation.strval($number+1);
        }
        // dd($this->abbr);
        return $service->abbreviation.'1';
    }

}
