<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{

    public $timestamps = false;


    public function textObjects()
    {
        return $this->hasMany(TextObject::class);
    }

    public function dates()
    {
        return $this->hasMany(ComicDate::class);
    }

    public function prices()
    {
        return $this->hasMany(ComicPrice::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }
    
    public function series() 
    {
        return $this->belongsTo(Series::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_comics');
    }

    public static function relatedCreators(Collection $stories)
    {
        $creatorsIds = StoryCreator::whereIn('story_id', $stories->pluck('id'))->pluck('creator_id');

        return Creator::whereIn('id', $creatorsIds);
    }

    public static function relatedCharacters(Collection $stories)
    {
        $charactersIds = StoryCharacter::whereIn('story_id', $stories->pluck('id'))->pluck('character_id');

        return Character::whereIn('id', $charactersIds);
    }

}
