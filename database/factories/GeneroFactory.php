<?php

use Faker\Generator as Faker;

$factory->define(App\Genero::class, function (Faker $faker) {
    return [
        'nombre' => $faker->text($maxNbChars = 30),
    ];
});
