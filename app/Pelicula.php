<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Storage;
use Auth;
use App\Notifications\PeliculaNotification;

class Pelicula extends Model
{    
    protected $primaryKey="idPelicula";
    protected $table="peliculas";
    public $timestamps=true;

    //public $guarded = []; si no tiene fillable debe tener un guarded
    public $fillable = ['titulo','duracion','anio','imagen'];

    protected $hidden = ['pivot']; //campos no disponibles para insertar


    //CONST CREATED_AT="fecha_registro";
    //CONST UPDATED_AT="ultima_actualizacion";

    public function scopeCortas($query){
        return $query->where('duracion','<','120');
    }
    
    public function scopeActuales($query){
        return $query->where('anio',date('Y'));
    }

    public function scopeAgrupar($query){
        //return $query->select('anio')->groupBy('anio');
        return $query->select('anio',DB::raw('count(*) as registros'))->groupBy('anio');
        //return $query->select('anio','duracion',DB::raw('count(*) as registros'))->groupBy('anio','duracion');
    }

    public function generos(){
        return $this->belongsToMany('\App\Genero','peliculas_generos','idPelicula','idGenero');
    }

    public function actores(){
        return $this->belongsToMany('\App\Actor','peliculas_actores','idPelicula','idActor');
    }

    public static function findGenero($array, $idGenero)
    {
        foreach ($array as $item) {
            foreach ($item as $value) {
                if ($value == $idGenero) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function findActor($array, $idActor)
    {
        foreach ($array as $item) {
            foreach ($item as $value) {
                if ($value == $idActor) {
                    return true;
                }
            }
        }
        return false;
    }

    /*protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pelicula) { // before delete() method call this
            $pelicula->generos()->detach();
            $pelicula->actores()->detach();
        });
    }*/

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pelicula) { // before delete() method call this
            $pelicula->generos()->detach();
            if ($pelicula->imagen != null) {
                Storage::delete($pelicula->imagen);
            }
        });

        // static::creating(function ($pelicula) {
        //     if (Input::hasFile('imagen') && $pelicula->imagen != null) {
        //         $image = Input::file('imagen');
        //         $pelicula->imagen = $image->store('public/peliculas');
        //     }
        // });


        static::created(function ($pelicula) { // before delete() method call this
            $user = Auth::user();
            $user->notify(new PeliculaNotification($pelicula));           
        });

        static::updated(function ($pelicula) { // before delete() method call this
            $user = Auth::user();
            $user->notify(new PeliculaNotification($pelicula, true));           
        });
    }

}
