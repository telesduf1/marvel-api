<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{

    public $timestamps = false;
 
    public function stories()
    {
        return $this->belongsToMany(Story::class, 'story_characters');
    }

    public static function relatedComics(Collection $stories)
    {
        return Comic::with(['stories', 'textObjects', 'dates', 'prices', 'series', 'events'])->whereIn('id', $stories->pluck('comic_id'));
    }
    
    public static function relatedSeries(Collection $stories) 
    {
        $seriesIds = Character::relatedComics($stories)->pluck('series_id');

        return Series::with('comics')->whereIn('id', $seriesIds);
    }

    public static function relatedEvents(Collection $stories) 
    {
        $eventsIds = EventComic::whereIn('comic_id', $stories->pluck('comic_id'))->pluck('event_id');

        return Event::with('comics')->whereIn('id', $eventsIds);
    }
}
