<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'operator_id',
        'status',
        'service_id',
        'key'
    ];

    const STATUS_WAITING = 0;
    const STATUS_IN_PROGRESS =1;
    const STATUS_ARCHIVED = 2;

    public function operator(){
        return $this->hasOne(User::class,'id','operator_id');
    }

    public function service(){
        return $this->hasOne(Service::class,'id','service_id');
    }

    public static function boot()
    {
        parent::boot();

        static::updating(function (Ticket $item) {

            if ($item->operator_id == null){
                $item->attributes['operator_id'] = auth()->user()->id;
                dd($item);
                return true;
            }
            return false;
        });
    }
}
