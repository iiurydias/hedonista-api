<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'fk_point', 'fk_user', 'comment'
    ];
    public function author(){
        return $this->belongsTo('App\User', 'fk_user');
    }
}
