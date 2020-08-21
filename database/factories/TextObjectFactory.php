<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comic;
use App\TextObject;
use Faker\Generator as Faker;

$factory->define(TextObject::class, function (Faker $faker) {

    $types = [
        "issue_solicit_text", "issue_preview_text", "70th_winner_desc",  
    ];

    return [
        "type" => $faker->randomElement($types),
        "language" => "en-us",
        "text" => $faker->text(),
        "comic_id" => function() {
            return factory(Comic::class)->create()->id;
        },
    ];
});
