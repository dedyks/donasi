<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Modul extends Eloquent
{
    //
    protected $fillable = [
      'aspect',
      'grade',
      'level',
      'title',
      'description',
      'notes',
      'video',
      'document',
      'image',
      'task',
      'reward'
  	];
}
