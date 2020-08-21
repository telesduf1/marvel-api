<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{

    public $timestamps = false;

    public function stories()
    {
        return $this->belongsToMany(Story::class, 'story_creators');
    }
}
