<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Event::class, function (Faker $faker) {

    $startDate = $faker->dateTime();
    $endDate = $faker->dateTimeBetween($startDate, "+2 years");

    return [
        "title" => $faker->text(100),
        "description" => $faker->text(),
        "start" => $startDate,
        "end" => $endDate,
        "thumbnail" => $faker->imageUrl(),
        "modified" => $faker->dateTime()
    ];
});
