<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ComicPrice;
use Faker\Generator as Faker;

$factory->define(ComicPrice::class, function (Faker $faker) {

    $types = [
        "printPrice", "digitalPurchasePrice"
    ];

    return [
        "type" => $faker->randomElement($types),
        "price" => $faker->randomFloat(2, 0, 200),
        "comic_id" => function() {
            return factory(Comic::class)->create()->id;
        },
    ];
});
