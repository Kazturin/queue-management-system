<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
   // use HasApiTokens, HasFactory, Notifiable;

    use Notifiable, HasRoles, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'login',
        'password',
        'number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
     //   'email_verified_at' => 'datetime',
       // 'password' => 'hashed',
    ];

//    public static function boot()
//    {
//        parent::boot();
//
//        static::creating(function (User $item) {
//       //     if ($item->type == 'db') {
//   //             $item->password = bcrypt($item->password);
//     //           $item->creation_token = Uuid::uuid4()->toString();
////                if (!auth()->user()->hasRole('Admin')){
////                    Role::create(['user_']);
////                }
//       //     }
//        });
//
//    }

    public function services(){
        return $this->belongsToMany(Service::class,'operator_services','operator_id','service_id');
    }

    public function canAccessFilament(): bool
    {
        return $this->hasRole(['Admin','Manager','Operator']);
    }

}
