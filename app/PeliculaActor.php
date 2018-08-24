<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeliculaActor extends Model
{
    protected $primaryKey="idPelAct";
    protected $table="peliculas_actores";
    public $timestamps=false;
}
