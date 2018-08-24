<?php

namespace App;

use Auth;
use App\Notifications\GeneroNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genero extends Model
{
    use SoftDeletes;

    protected $primaryKey="idGenero";
    protected $table="generos";
    public $timestamps=true;

    //public $guarded = [];

    protected $fillable = ['nombre'];
    protected $dates = ['deleted_at'];

    protected $hidden = ['pivot'];//relacion de muchos a muchos

    public function peliculas(){
        return $this->belongsToMany('\App\Pelicula','peliculas_generos','idGenero','idPelicula');
    }

    /*protected static function boot()
    {
        parent::boot();

        static::deleting(function ($genero) { // before delete() method call this
            $genero->peliculas()->detach();
        });
    }*/

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($genero) { // before delete() method call this
            $user = Auth::user();
            $user->notify(new GeneroNotification($genero));           
        });

        static::restored(function ($genero) { // before delete() method call this
            $user = Auth::user();
            $user->notify(new GeneroNotification($genero, true));           
        });
    }

}
