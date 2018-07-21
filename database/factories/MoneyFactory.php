<?php

use Faker\Generator as Faker;

$factory->define(App\Entity\Money::class, function (Faker $faker, array $attr) {
    return [
        'amount' => $faker->randomFloat(2, 0, 1000),
        'currency_id' => function() { return factory(App\Entity\Currency::class)->create()->id; },
        'wallet_id' => function() { return factory(App\Entity\Wallet::class)->create()->id; }
    ];
});
