<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Cmgmyr\Messenger\Models\Thread;
use Cmgmyr\Messenger\Traits\Messagable;

class Users extends Eloquent
{
    use Messagable;
    protected $connection = 'mongodb';
    protected $collection = 'users';

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
        'fcm_token',
        'kupon',
        'reg_coupon'
        ];
    protected $rules = [];
    protected $hidden = [
        'password',
    ];
    public function schoolGsm(){
        return $this->belongsTo('App\SchoolGsm','schoolgsm_id');
    }

    // public function SchoolGsm()
    // {
    //     return $this->embedsMany('App\SchoolGsm');
    // }

    public function quiz()
    {
        return $this->hasMany('App\Quiz', 'user_id');
    }

    public function assessor()
    {
        return $this->belongsTo('App\Users', 'assessor_id');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, null, 'user_ids', 'article_ids');
    }

    public function threads()
    {
        return $this->belongsToMany(Thread::class, 'messages', 'user_id', 'thread_id')
            ->withTimestamps()
            ->withPivot(['body'])
            ->groupBy('thread_id')
            ->latest('updated_at');
    }
}
