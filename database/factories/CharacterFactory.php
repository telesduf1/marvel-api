<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Character;
use Faker\Generator as Faker;

$factory->define(Character::class, function (Faker $faker) {
    return [
        "name" => $faker->name(),
        "description" => $faker->text(),
        "thumbnail" => $faker->imageUrl(),
        "modified" => $faker->dateTime()
    ];
});
