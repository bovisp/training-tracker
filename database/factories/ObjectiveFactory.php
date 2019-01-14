<?php

use Faker\Generator as Faker;
use TrainingTracker\Domains\Objectives\Objective;

$factory->define(Objective::class, function (Faker $faker) {
    return [
        'number' => strtoupper($faker->randomLetter) . $faker->numberBetween(1, 100),
        'name' => [
            'en' => $faker->sentence(20),
            'fr' => $faker->sentence(20)
        ],
        'notebook_required' => 1
    ];
});
