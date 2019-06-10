<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Question::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 4),
        'tag_category_id' => $faker->numberBetween(1, 4),
        'title' => $faker->text,
        'content' => $faker->text,
    ];
});
