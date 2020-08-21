<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comic;
use App\Series;
use Faker\Generator as Faker;

$factory->define(Comic::class, function (Faker $faker) {

    $formats = [
        "comic", "magazine", "trade paperback", 
        "hardcover", "digest", "graphic novel",
        "digital comic", "infinite comic"
    ];

    return [
        "digital_id" => $faker->randomNumber(4),
        "title" => $faker->text(150),
        "issue_number" => $faker->randomNumber(2),
        "variant_description" => $faker->text(),
        "description" => $faker->text(),
        "isbn" => $faker->text(13),
        "upc" => $faker->text(13),
        "diamond_code" => "",
        "ean" => "",
        "issn" => "",
        "format" => $faker->randomElement($formats),
        "page_count" => $faker->randomNumber(2),
        "thumbnail" => $faker->imageUrl(),
        "modified" => $faker->dateTime(),
        "series_id" => function() {
            return factory(Series::class)->create()->id;
        }
    ];
});
