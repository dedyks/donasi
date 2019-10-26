<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class RegCoupon extends Eloquent
{
    //
    protected $fillable = [
      'coupon_code',
      'coupon_title',
      'coupon_quota',
      'coupon_used',
      'expired_date',
      'status'
  	];
}
