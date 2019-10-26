<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Rapor extends Eloquent
{
    //
    protected $fillable = [
      'tipe',
      'assessor_id',
      'kerangka',
      'user_id',
      'laporan',
      'judul',
      'image'
  	];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function assessor(){
      return $this->belongsTo('App\User', 'assessor_id');
    }
}
