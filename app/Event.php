<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    public $timestamps = false;

    public function comics()
    {
        return $this->belongsToMany(Comic::class, 'event_comics');
    }

    public function scopeNext($query)
    {
        return $query->where('start', '>', $this->start)->first();
    }

    public function scopePrevious($query)
    {
        return $query->where('start', '<', $this->start)->first();
    }

    public static function relatedCreators(Collection $comics) 
    {
        $storyIds = Story::whereIn('comic_id', $comics->pluck('id'))->pluck('id');
        $creatorsIds = StoryCreator::whereIn('story_id', $storyIds)->pluck('creator_id');

        return Creator::whereIn('id', $creatorsIds);
    }

    public static function relatedCharacters(Collection $comics) 
    {
        $storyIds = Story::whereIn('comic_id', $comics->pluck('id'))->pluck('id');
        $charactersIds = StoryCharacter::whereIn('story_id', $storyIds)->pluck('character_id');

        return Character::whereIn('id', $charactersIds);
    }

    public static function relatedStories(Collection $comics) 
    {
        $storyIds = Story::whereIn('comic_id', $comics->pluck('id'))->pluck('id');

        return Story::with(['characters', 'creators'])->whereIn('id', $storyIds);
    }

    public static function relatedSeries(Collection $comics) 
    {
        $seriesIds = $comics->pluck('series_id');

        return Series::with('comics')->whereIn('id', $seriesIds);
    }
}
