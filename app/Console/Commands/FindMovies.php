<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Pelicula;

class FindMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:movie {id : ID de la película}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca películas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id=$this->argument('id');
        $pelicula=Pelicula::findOrFail($id);
        echo "Película encontrada, ".$pelicula->titulo;
    }
}
