<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content'
    ];

    //relazione fra posts e categories
    public function category() {
        return $this->belongsTo('App\Category');
    }
}
