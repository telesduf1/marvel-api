<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{

    protected $table = 'stories';
    public $timestamps = false;

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'story_characters');
    }

    public function creators()
    {
        return $this->belongsToMany(Creator::class, 'story_creators');
    }

}
