<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 4),
        'question_id' => $faker->numberBetween(1, 10),
        'comment' => $faker->text,
    ];
});
