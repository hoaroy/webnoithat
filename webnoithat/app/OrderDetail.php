<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "orderdetail";

    protected $primaryKey = 'orderdetail_id';
    protected $guarded = [];
}
