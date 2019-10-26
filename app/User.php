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


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'attendedWorkshop',
        'detail',
        'school',
        'role',
        'schoolgsm_id',
        'request',
        'level',
        'assessor_id',
        'assessor_kuota_max',
        'assessor_kuota_now',
        'photo_profile',
        'invited_by',
        'kupon',
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

    public function schoolgsm(){
        return $this->belongsTo('App\SchoolGsm','schoolgsm_id');
    }

    public function assessor(){
      return $this->belongsTo('App\User', 'assessor_id');
    }
}
