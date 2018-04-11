<?php

use Faker\Generator as Faker;
use TrainingTracker\Domains\Topics\Topic;

$factory->define(Topic::class, function (Faker $faker) {
    return [
        'number' => $faker->unique()->numberBetween($min = 1, $max = 10)
    ];
});
