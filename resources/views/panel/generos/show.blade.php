@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Información del género <a class="btn btn-primary" href="{{url('generos')}}" title="Regresar al listado" role="button">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                    </a></div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><b>Nombre:</b> {{$genero->nombre}}</li>                            
                        </ul>
                        <h4>Películas</h4>
                        @if (count($genero->peliculas) > 0)
                            <ul class="list-group">
                                @foreach ($genero->peliculas as $pel)
                                    <li class="list-group-item">{{$pel->titulo}}</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>El género no tiene películas registradas</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
