<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use DB;

use Response;

class RequestAssessor extends Eloquent {


    protected $connection = 'mongodb';
    protected $collection = 'requestAssessor';

    protected $fillable = [
        'user_id'

    	];

    public $timestamps = true;
    protected $dates = [
        
        'deleted_at'
    ];


    }
