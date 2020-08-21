<?php

use App\Comic;
use App\ComicDate;
use App\ComicPrice;
use App\Story;
use App\TextObject;
use Illuminate\Database\Seeder;

class ComicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Comic::class, 2)->create()->each(function ($comic) {

            $comic->dates()->save(factory(ComicDate::class)->make(['comic_id' => null]));
            $comic->prices()->save(factory(ComicPrice::class)->make(['comic_id' => null]));
            $comic->textObjects()->save(factory(TextObject::class)->make(['comic_id' => null]));
            $comic->stories()->save(factory(Story::class)->make(['comic_id' => null]));

        });
    }
}
