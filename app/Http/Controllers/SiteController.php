<?php


namespace App\Http\Controllers;


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

        return redirect()->route('ticket', ['key'=>$ticket->key]);
    }

    public function ticket(Request $request, string $key){

        if ($request->id){
            $ticket = Ticket::where('key',$key)->delete();
           // $ticket->delete();
            return redirect()->back();
        }

        return view('site.ticket',compact('key'));
    }

    public function display(){

        $test = Ticket::where('status',Ticket::STATUS_IN_PROGRESS)->with('operator')->orderBy('updated_at','desc')->limit(10)->get()->toArray();

      //  dd($test);
//        User::create([
//            'name' => 'Bob',
//            'email' => 'bob@test.test',
//            'password' => bcrypt('testtest'),
//            'number' => 3
//        ]);

      //  dd(User::find(1)->hasRole('Admin'));

        $tickets = Ticket::where('status',Ticket::STATUS_IN_PROGRESS)->with('operator')->orderBy('updated_at','desc')->get()->toArray();

        return view('site.display',compact('tickets'));
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
