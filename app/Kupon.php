<?php

namespace App;
use DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Kupon extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'kupon';

    protected $fillable = [
       'image',
       'kode_kupon',
       'deskripsi_kupon',
       'nama_training',
        ];

    protected $dates = [
        'deleted_at',
    ];

    public $timestamps = true;
}
