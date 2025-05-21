<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "order";

    protected $primaryKey = 'order_id';
    protected $guarded = [];
}
