<?php

namespace App;
use DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Activation extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'activation_donasi';

    protected $fillable = [
        'email',
        'token'
        ];

    protected $dates = [
        'deleted_at',
    ];

  
}
