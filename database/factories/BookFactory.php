<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->paragraph(),
        'author' => $faker->name,
        'isbn' => $faker->isbn13,
        'year' => $faker->year(),
        'pages_count' => $faker->randomDigitNotNull,
        'price' => $faker->randomDigitNotNull
    ];
});
