<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $primaryKey="idActor";
    protected $table="actores";
    public $timestamps=true;

    public $guarded = [];

    public function peliculas(){
        return $this->belongsToMany('\App\Pelicula','peliculas_actores','idActor','idPelicula');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($actor) { // before delete() method call this
            $actor->peliculas()->detach();
        });
    }

}
