<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use DB;

use Response;

class SchoolGsm extends Eloquent {


    protected $connection = 'mongodb';
    protected $collection = 'schoolGsm';

    protected $fillable = [
        "id",
        'propinsi',
        'kode_kab_kota',
        'kabupaten_kota',
        'kode_kec',
        'data_id',
        'kecamatan',
        'npsn',
        'sekolah',
        'bentuk',
        'status',
        'user_id',
        'sekolah',
        'lokasi',
        'alamat_jalan',
        'model_gsm',
        'lintang',
        'bujur'
        
    	];

    protected $dates = [
        
        'deleted_at'
    ];


    public function user()
    {
        return $this->hasMany('App\User','schoolgsm_id');
    }

    public function article()
    {
        return $this->hasMany('App\Article','schoolgsm_id');
    }

    }
