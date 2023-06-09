<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorService extends Model
{
    use HasFactory;

    protected $fillable = [
        'operator_id',
        'service_id'
    ];

    public function operator(){
        return $this->belongsTo(User::class,'operator_id','id');
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }

}
