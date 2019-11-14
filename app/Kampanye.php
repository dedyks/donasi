<?php

namespace App;
use DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Kampanye extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'kampanye';

    protected $fillable = [
        'title',
        'content',
        'donation_goal',
        'donation_collected',
        'end_date',
        'total_donatur',
        'schoolGsm_id'
        ];

    protected $dates = [
        'deleted_at'
    ];

    public  $rules = [
        'title' => 'required',
        'donation_goal' => 'required|numeric',
        'end_date' => 'required|date'
    ];

    public function donasi()
    {
        return $this->hasMany('App\Donasi','kampanye_id');
    }
}
