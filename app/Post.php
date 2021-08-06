<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'cover'
    ];

    //relazione fra posts e categories
    public function category() {
        return $this->belongsTo('App\Category');
    }
    
    //relazione fra posts e tags
    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
