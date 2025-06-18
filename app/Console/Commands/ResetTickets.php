<?php

namespace App\Console\Commands;

use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ResetTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $abbreviations = Service::select('id','abbreviation')->get()->toArray();

        foreach ($abbreviations as $item){
           Ticket::create([
                'number' => $item['abbreviation'].'0',
                'operator_id' => null,
                'status' => \App\Models\Ticket::STATUS_ARCHIVED,
                'service_id' => $item['id'],
                'key' => Str::random(20)
            ]);
        }
    //    DB::table('tickets')->delete();

        $this->info('Reset tickets successfully');

        return Command::SUCCESS;
    }
}
