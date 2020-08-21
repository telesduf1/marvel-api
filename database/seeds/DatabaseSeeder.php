<?php

use App\Character;
use App\Comic;
use App\ComicDate;
use App\ComicPrice;
use App\Creator;
use App\Event;
use App\Story;
use App\TextObject;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        factory(Character::class, 100)->create();
        factory(Creator::class, 10)->create();

        factory(Comic::class, 50)->create()->each(function ($comic) {

            $comic->dates()->saveMany(factory(ComicDate::class, rand(0, 2))->make(['comic_id' => null]));
            $comic->prices()->saveMany(factory(ComicPrice::class, rand(0, 2))->make(['comic_id' => null]));
            $comic->textObjects()->saveMany(factory(TextObject::class, rand(0, 3))->make(['comic_id' => null]));
            $comic->stories()->saveMany(factory(Story::class, rand(1, 10))->make(['comic_id' => null]));

        });

        $characters = Character::all();
        $creators = Creator::all();

        Story::all()->each(function ($story) use ($characters, $creators) {

            $story->characters()->attach(
                $characters->random(rand(1, 10))->pluck('id')->toArray()
            );

            $story->creators()->attach(
                $creators->random(rand(1, 3))->pluck('id')->toArray()
            );

        });

        factory(Event::class, 50)->create();

        $comics = Comic::all();

        Event::all()->each(function ($event) use ($comics) {

            $event->comics()->attach(
                $comics->random(rand(1, 10))->pluck('id')->toArray()
            );

        });
    }
}
