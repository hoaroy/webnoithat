<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";

    protected $primaryKey = 'category_id';
    protected $guarded = [];

    public function categories()
    {
        return $this->hasMany('App\Category','category_id');
    }
    public function childrenCategories()
    {
        return $this->hasMany('App\Category','category_id')->with('categories');
    }
    public function cateParent()
    {
        return $this->belongsTo('App\Category','category_sub');
    }

    public function cateProduct()
    {
        return $this->belongsTo('App\Products','category_id');
    }
}
