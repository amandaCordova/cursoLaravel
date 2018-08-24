<?php

use Faker\Generator as Faker;

$factory->define(\App\Pelicula::class, function (Faker $faker) {
    return [
        'titulo' => $faker->text($maxNbChars = 30),
        'duracion' => $faker->numberBetween($min = 80, $max = 200),
        'anio' => $faker->numberBetween($min = 2000, $max = 2018),         
    ];
});
