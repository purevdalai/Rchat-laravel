<?php

use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraphs(rand(3, 10), true),
        'image' => $faker->imageUrl($width = 640, $height = 480)
    ];
});
