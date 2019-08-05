<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'count'
    ];
     public function getUpdate1($id, $name)
    {
        $product = $this->find($id);
        $product->name = $name;
        $product->save();
        return $product;
    }
    public function depot()
    {
        return $this->belongsToMany('App\Depot');
    }
    public function DP()
    {
        return $this->belongsToMany('App\DP');
    }
     public function history()
    {
        return $this->belongsToMany('App\History');
    }
}
