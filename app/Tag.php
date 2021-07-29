<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //relazione fra tags e posts
    public function posts() {
        return $this->belongsToMany('App\Post');
    }
}
