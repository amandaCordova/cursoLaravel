@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Información de la película <a class="btn btn-primary" href="{{url('peliculas')}}" title="Regresar al listado" role="button">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                    </a></div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><b>Título:</b> {{$pelicula->titulo}}</li>
                            <li class="list-group-item"><b>Duración:</b> {{$pelicula->duracion}} minutos</li>
                            <li class="list-group-item"><b>Año:</b> {{$pelicula->anio}}</li>
                            <li class="list-group-item"><b>Imagen:</b> 
                                @if($pelicula->imagen == null)
                                    -
                                @else
                                    <img src="{{\Storage::url($pelicula->imagen)}}" style="max-height:300px;">
                                @endif
                            </li>
                        </ul>                        
                        <br>
                        <h4>Géneros</h4>
                        @if (count($pelicula->generos) > 0)
                            <ul class="list-group">
                                @foreach ($pelicula->generos as $gen)
                                    <li class="list-group-item">{{$gen->nombre}}</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>La película no tiene géneros registrados</strong>
                            </div>
                        @endif
                        <br>
                        <h4>Actores</h4>
                        @if (count($pelicula->actores) > 0)
                            <ul class="list-group">
                                @foreach ($pelicula->actores as $act)
                                    <li class="list-group-item">{{$act->nombres}}&nbsp;{{$act->apellidos}}</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>La película no tiene actores registrados</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
