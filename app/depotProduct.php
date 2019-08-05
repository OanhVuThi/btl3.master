<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class depotProduct extends Model
{
    protected $table = 'depot_product';
    protected $fillable = [
        'depot_id',
        'product_id',
      
    ];
    public function product()
    {
        return $this->belongsToMany('App\Product');
    }
    public function depot()
    {
        return $this->belongsToMany('App\Depot');
    }
}
