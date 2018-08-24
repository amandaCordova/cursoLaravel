<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;
use App\Http\Requests\ActorRequest;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actores = Actor::withCount('peliculas')->orderBy('nombres')->paginate(10);
        return view('panel.actores.index', compact('actores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("panel.actores.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActorRequest $request)
    {
        try{
            $actor=Actor::create($request->all());           //ask

            if ($request->hasFile('imagen')) {
                $actor->imagen = $request->file('imagen')->store('public/actores');
                $actor->save();
            }

            return redirect('actores')->with('success','Actor registrado');
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
        $actor=Actor::with(['peliculas' => function ($query) {
            $query->select('titulo');
        }])->findOrFail($id);
        return view("panel.actores.show",compact('actor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actor=Actor::with(['peliculas' => function ($query) {
            $query->select('peliculas.idPelicula');
        }])->findOrFail($id);        
        return view("panel.actores.edit",compact('actor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActorRequest $request, $id)
    {
        try{
            $actor=Actor::updateOrCreate(['idActor'=>$id],$request->all());            
            return redirect('actores')->with('success','Actor actualizado');
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
            Actor::destroy($id);
            return redirect('actores')->with('success','Actor eliminado');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }
    }
}
