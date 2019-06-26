<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Answer::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'color' => $faker->rgbColor,
        'score' => rand(0, 10),
        'negative' => (bool) rand(0,1),
        'uuid' => $faker->uuid
    ];
});

