<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comic;
use App\Story;
use Faker\Generator as Faker;

$factory->define(Story::class, function (Faker $faker) {

    $types = [
        "cover", "interiorStory"
    ];

    return [
        "title" => $faker->text(100),
        "description" => $faker->text(),
        "type" => $faker->randomElement($types),
        "thumbnail" => $faker->imageUrl(),
        "modified" => $faker->dateTime(),
        "comic_id" => function() {
            return factory(Comic::class)->create()->id;
        },
        "originalissue" => function() {
            return factory(Comic::class)->create()->id;
        }
    ];
});