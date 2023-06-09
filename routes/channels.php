<?php

use App\Models\OperatorService;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
//
//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});
//Broadcast::channel('tisket.{ticket}', function ($user, $ticket) {
//    $allowServicesIds = OperatorService::where('operator_id',$user->id)->pluck('service_id');
//    return in_array($ticket->services_id,$allowServicesIds);
//});

