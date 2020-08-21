<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Creator;
use Faker\Generator as Faker;

$factory->define(Creator::class, function (Faker $faker) {
    return [
        "first_name" => $faker->firstName(),
        "middle_name" => $faker->name(),
        "last_name" => $faker->name(),
        "suffix" => $faker->name(),
        "thumbnail" => $faker->imageUrl(),
        "modified" => $faker->dateTime()
    ];
});
