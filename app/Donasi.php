<?php

namespace App;
use DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Donasi extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'donasi';

    protected $fillable = [
        'user_id',
        'kampanye_id',
        'comment',
        'donation_amount',
        'status'
        ];

    protected $dates = [
        'deleted_at'
    ];

    public  $rules = [
        'user_id' => 'required',
        'kampanye_id' => 'required',
        'donation_amount'=>'required|numeric|min:10000'

    ];

    public function kampanye(){
        return $this->belongsTo('App\Kampanye','kampanye_id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
