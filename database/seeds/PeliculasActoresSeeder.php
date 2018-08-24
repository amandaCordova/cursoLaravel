<?php

use Illuminate\Database\Seeder;

class PeliculasActoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Pelicula::class, 20)->create()->each(function ($p) {
            $p->actores()->attach(factory(App\Actor::class, 3)->create());
        });
    }
}
