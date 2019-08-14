<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'fk_user', 'fk_point',
    ];
    protected $hidden = [
        'fk_user', 'fk_point',
    ];
    public function point(){
       return $this->belongsTo('App\Point', 'fk_point');
    }
    public function author(){
        return $this->belongsTo('App\User', 'fk_user');
    }
}
