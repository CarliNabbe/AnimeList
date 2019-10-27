<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;

class Post extends Model implements ReactableContract
{

    use Reactable;

    public function user() {
        return $this->belongsTo('App\User');
    }
}
