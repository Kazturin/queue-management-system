<?php

namespace App\Filament\Pages;

use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;

class MyTickets extends Page
{

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    protected $tickets;

    protected static function shouldRegisterNavigation(): bool
    {
        $user = User::find(auth()->user()->id);
        if ($user && $user->hasRole('Operator')){
            return true;
        };
        return false;
    }

    protected static string $view = 'filament.pages.my-tickets';

   // protected static ?string $title = __('Accepted coupons');

    protected static function getNavigationLabel(): string
    {
        return __('Accepted coupons');
    }

    protected function getHeading(): string
    {
        return __('Accepted coupons');
    }

    public function getQueryString()
    {
        return [];
    }

    public function mount(){

        $this->tickets = Ticket::with('service')
            ->where(['status'=>Ticket::STATUS_IN_PROGRESS,'operator_id'=>auth()->user()->id])
            ->whereDate('created_at',Carbon::today())
            ->orderBy('id')
            ->get();
    }

}
