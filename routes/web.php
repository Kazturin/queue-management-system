<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'services')->name('services');
    Route::get('/print', 'servicesPrint')->name('services-print');
    Route::get('/ticket-create/{service}', 'ticketCreate')->name('ticket-create');
    Route::any('/ticket/{key}', 'ticket')->name('ticket');
    Route::get('/display', 'display')->name('display');
});
