<?php

use Faker\Generator as Faker;
use TrainingTracker\Domains\Levels\Level;

$factory->define(Level::class, function (Faker $faker) {
    return [
        'name' => [
            'en' => $faker->sentence(5),
            'fr' => 'f ' . $faker->sentence(5)
        ]
    ];
});
