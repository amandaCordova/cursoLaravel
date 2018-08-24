@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Información del actor <a class="btn btn-primary" href="{{url('actores')}}" title="Regresar al listado" role="button">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                    </a></div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><b>Nombres:</b> {{$actor->nombres}}</li>                            
                            <li class="list-group-item"><b>Apellidos:</b> {{$actor->apellidos}}</li>
                            <li class="list-group-item"><b>Imagen:</b> 
                                @if($actor->imagen == null)
                                    -
                                @else
                                    <img src="{{\Storage::url($actor->imagen)}}" style="max-height:300px;">
                                @endif
                            </li>
                        </ul>
                        <h4>Películas</h4>
                        @if (count($actor->peliculas) > 0)
                            <ul class="list-group">
                                @foreach ($actor->peliculas as $pel)
                                    <li class="list-group-item">{{$pel->titulo}}</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>El actor no tiene películas registradas</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
