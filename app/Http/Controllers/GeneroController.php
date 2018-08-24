<?php

namespace App\Http\Controllers;

use App\Genero;
use Illuminate\Http\Request;
use App\Http\Requests\GeneroRequest;
use Illuminate\Database\QueryException;

use App\Notifications\GeneroNotification;
use Notification;
use Auth;
use Lang;

use App\Jobs\ProcessEmail;


class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$generos = Genero::withCount('peliculas')->orderBy('nombre')->paginate(10);
        //return view('panel.generos.index', compact('generos'));

        $query=Genero::query();
        $query=$query->withCount('peliculas')->orderBy('nombre');  
        if($request->display == "all"){
            $query =$query->withTrashed();
        }else if($request->display == "trash"){
            $query =$query->onlyTrashed();
        }
        $generos = $query->paginate(10);
        return view('panel.generos.index', compact('generos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view("panel.generos.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneroRequest $request)
    {
        try{
            $genero=Genero::create($request->except('idPelicula'));           //ask
            return redirect('generos')->with('success','Género registrado');
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
        return Genero::withTrashed()->where('idGenero', $id)
        ->firstOrFail()->toJson();
        // $genero=Genero::with(['peliculas' => function ($query) {
        //     $query->select('titulo');
        // }])->findOrFail($id);
        // return view("panel.generos.show",compact('genero'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $genero=Genero::with(['peliculas' => function ($query) {
            $query->select('peliculas.idPelicula');
        }])->findOrFail($id);        
        return view("panel.generos.edit",compact('genero'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GeneroRequest $request, $id)
    {
        try{
            $genero=Genero::updateOrCreate(['idGenero'=>$id],$request->all());            
            return redirect('generos')->with('success','Género actualizado');
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
        /*try{
            Genero::destroy($id);
            return redirect('generos')->with('success','Género eliminado');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }*/

        try{
            Genero::withTrashed()->where('idGenero',$id)->forceDelete();
            return redirect('generos')->with('success','Género eliminado permanentemente');
        }catch(Exception | QueryException $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }

    }

    public function restore($id)
    {
        try{
            Genero::withTrashed()->where('idGenero',$id)->restore();
            //info($id);
            return redirect('generos')->with('success','Género restaurado');
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }
    }

    public function trash($id)
    {
        try{
            Genero::destroy($id);      
            ProcessEmail::dispatch()->delay(now()->addMinutes(1))->onQueue('high');      
            //$gen = Genero::withTrashed()->where('idGenero', $id)->first();            
            //$user = Auth::user();
            //$user->notify(new GeneroNotification($gen));            
            
            //Mail::to($user)->send(new GeneroTrash());
            // Notification::route('mail', $email)
            // ->notify(new GeneroNotification());
            $gen=Genero::withTrashed()->where('idGenero',$id)->first();
            return redirect('generos')->with('success', Lang::get("messages.gender_trash",['name'=>$gen->nombre]));
            //message es el nombr del archivo sin la extencion
            //gander_tras me ha retorna lo que contiene con estos me accede al idioma en el que estoy trabajando, porque obtiene el valor de la clave que le pasamos
        }catch(Exception $e){
            return back()->withErrors(['exception'=>$e->getMessage()]);
        }
        
    }

}
