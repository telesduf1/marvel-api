<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{

    protected $table = 'series';
    public $timestamps = false;

    public function comics()
    {
        return $this->hasMany(Comic::class);
    }

    public function scopeNext($query)
    {
        return $query->where('start_year', '>', $this->start_year)->first();
    }

    public function scopePrevious($query)
    {
        return $query->where('start_year', '<', $this->start_year)->first();
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

    public static function relatedEvents(Collection $comics) 
    {
        $eventsIds = EventComic::whereIn('comic_id', $comics->pluck('id'))->pluck('event_id');

        return Event::with('comics')->whereIn('id', $eventsIds);
    }
}
