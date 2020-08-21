<?php

use App\Comic;
use App\Series;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Series::class, 2)->create()->create()->each(function ($series) {

            $series->comics()->save(factory(Comic::class)->make(['series_id' => NULL]));

        });
    }
}
