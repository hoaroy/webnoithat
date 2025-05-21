<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = "product";

    protected $primaryKey = 'product_id';
    protected $guarded = [];

    public function cate_product()
    {
        return $this->belongsTo('App\Category','category_id');
    }

}
