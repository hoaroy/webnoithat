<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = "coupon";

    protected $primaryKey = 'coupon_id';
    protected $guarded = [];
}
