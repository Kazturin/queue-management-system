<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'abbreviation'
    ];

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

}
