<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Series;
use Faker\Generator as Faker;

$factory->define(Series::class, function (Faker $faker) {

    $ratings = [
        "G", "PG", "PG-13", "R", "NC-17"
    ];

    $startDate = $faker->dateTime();
    $endDate = $faker->dateTimeBetween($startDate, "+2 years");

    return [
        "title" => $faker->text(100),
        "description" => $faker->text(),
        "start_year" => $startDate->format('Y'),
        "end_year" => $endDate->format('Y'),
        "rating" => $faker->randomElement($ratings),
        "thumbnail" => $faker->imageUrl(),
        "modified" => $faker->dateTime()
    ];
});
