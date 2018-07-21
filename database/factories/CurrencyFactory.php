<?php

use Faker\Generator as Faker;

$factory->define(App\Entity\Currency::class, function (Faker $faker) {
    return [
        'short_name' => $faker->unique()->currencyCode,
        'actual_course' => $faker->randomFloat(2, 0.1, 7000)
    ];
});
