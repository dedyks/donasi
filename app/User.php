<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use DesignMyNight\Mongodb\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Cmgmyr\Messenger\Traits\Messagable;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use Messagable;

    protected $connection = 'mongodb';
    protected $collection = 'users_donasi';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'is_activated',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function donasi()
    {
        return $this->hasMany('App\Donasi','kampanye_id');
    }
    public function assessor(){
      return $this->belongsTo('App\User', 'assessor_id');
    }
}
