<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function likes() {
        return $this->belongsTo('App\Like');
    }

    public function tags() {
        
        return $this->belongsToMany(Tag::class);

    }
}
