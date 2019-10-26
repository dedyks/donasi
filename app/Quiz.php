<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Eloquent {

    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'quiz';

    protected $fillable = [
        'modul_id',
        'image',
        'deskripsi',
        'user_id',
        'assessor_id',
        'penilaian',
        'status',
        'flag'
    	];

    public static $rules = [
		
	];

    protected $dates = [
        
        'deleted_at'
    ];

    public function user(){
        return $this->belongsTo('App\Users','user_id');
    }
    public function modul(){
        return $this->belongsTo('App\Modul','modul_id');
    }
    // public function assessor(){
    //     return $this->belongsTo('App\Users','assessor_id');
    // }

  
    }
