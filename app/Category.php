<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //devo gestire la relazione fra posts e categories, in aggiunta alla migration
    //la categoria ha molti post
    public function posts() {
        return $this->hasMany('App\Post');
    }
}
