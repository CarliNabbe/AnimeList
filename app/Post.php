<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'title', 'body', 'user_id', 'cover_image', 'admin_id'
    ];
    

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function likes() {
        return $this->hasMany('App\Like');
    }

    public function tags() {
        
        return $this->belongsToMany(Tag::class);

    }
}
