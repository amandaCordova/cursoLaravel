<?php

namespace App\Http\Controllers;

use App\Pelicula;
use App\Genero;
use App\Actor;
use Illuminate\Http\Request;
use App\Http\Requests\PeliculaRequest;
use App\Notifications\PeliculaNotification;
use Notification;
use Auth;


class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $peliculas = Pelicula::withCount('generos','actores')->orderByDesc('anio')->orderBy('titulo')->paginate(10);
        return view('panel.peliculas.index', compact('peliculas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $generos=Genero::orderBy('nombre')->get(['idGenero','nombre']);
        $actores=Actor::orderBy('nombres')->get(['idActor','nombres','apellidos']);
        return view("panel.peliculas.create",compact('generos','actores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PeliculaRequest $request)
    {
        try{
            $pelicula=Pelicula::create($request->except('idGenero','idActor','imagen'));

            if ($request->hasFile('imagen')) {
                $pelicula->imagen = $request->file('imagen')->store('public/peliculas');
                $pelicula->save();
            }

            $pelicula->generos()->sync($request->idGenero);
            $pelicula->actores()->sync($request->idActor);
            return redirect('peliculas')->with('success','Película registrada');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelicula=Pelicula::with(['generos' => function ($query) {
            $query->select('nombre');
        }],
        ['actores' => function ($query) {
           $query->select('nombres','apellidos');
        }])->findOrFail($id);
        return view("panel.peliculas.show",compact('pelicula'));    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pelicula=Pelicula::with(['generos' => function ($query) {
            $query->select('generos.idGenero');
        }],
        ['actores' => function ($query) {
            $query->select('actores.idActor');
         }])->findOrFail($id);
        $generos=Genero::orderBy('nombre')->get(['idGenero','nombre']);
        $gens=collect($pelicula->generos)->sortBy('idGenero')->toArray();

        $actores=Actor::orderBy('nombres')->get(['idActor','nombres','apellidos']);
        $acts=collect($pelicula->actores)->sortBy('idActor')->toArray();
        return view("panel.peliculas.edit",compact('pelicula','generos','gens','actores','acts'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PeliculaRequest $request, $id)
    {
        try{
            $pelicula=Pelicula::updateOrCreate(['idPelicula'=>$id],$request->except('idGenero','idActor'));
            $pelicula->generos()->sync($request->idGenero);
            $pelicula->actores()->sync($request->idActor);
            return redirect('peliculas')->with('success','Pelicula actualizada');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()])->withInput();
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Pelicula::destroy($id);
            return redirect('peliculas')->with('success','Película eliminada');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }
    }
}
