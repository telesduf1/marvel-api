<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comic;
use App\ComicDate;
use Faker\Generator as Faker;

$factory->define(ComicDate::class, function (Faker $faker) {

    $types = [
        "focDate", "onsaleDate"
    ];

    return [
        "type" => $faker->randomElement($types),
        "date" => $faker->dateTime(),
        "comic_id" => function() {
            return factory(Comic::class)->create()->id;
        },
    ];
});
