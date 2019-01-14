<?php

use Faker\Generator as Faker;
use TrainingTracker\Domains\Lessons\Lesson;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'name' => [
            'en' => $faker->sentence(5),
            'fr' => $faker->sentence(5),
        ],
        'p9' => 1,
        'p18' => 1,
        'p30' => 0,
        'p42' => 0,
    ];
});
