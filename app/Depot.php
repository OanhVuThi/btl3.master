<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{

    protected $fillable = [
        'name',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function product()
    {
        return $this->belongsToMany('App\Product');
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
