<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'fk_subcategory', 'fk_user', 'name', 'address', 'latitude', 'longitude'
    ];
    
    public function author(){
        return $this->belongsTo('App\User', 'fk_user');
    }
}