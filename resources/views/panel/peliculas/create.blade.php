@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Nueva Película <a class="btn btn-primary" href="{{url('peliculas')}}" title="Regresar al listado" role="button">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                    </a></div>
                    <div class="card-body">
                        @include('includes.messages')
                        {!! Form::open(['url' => 'peliculas','files'=>'true']) !!}
                            <div class="form-group row">
                                <label for="titulo" class="col-sm-2 col-form-label">Título</label>
                                <div class="col-sm-10">
                                    <input required type="text" class="form-control" id="titulo" name="titulo" value="{{old('titulo')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="duracion" class="col-sm-2 col-form-label">Duración</label>
                                <div class="col-sm-4">
                                    <input required type="number" min="50" max="500" class="form-control" id="duracion" name="duracion" value="{{old('duracion')}}">
                                </div>
                                <label for="anio" class="col-sm-2 col-form-label">Año</label>
                                <div class="col-sm-4">
                                    <input required type="number" min="1950" max="{{date('Y')}}" class="form-control" id="anio" name="anio" value="{{old('anio')}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="imagen" name="imagen">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="generos">Géneros</label>
                                    <div style="height:300px;overflow-y: scroll;">
                                        @foreach ($generos as $gen)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{$gen->idGenero}}" name="idGenero[]">
                                                <label class="form-check-label">
                                                      {{$gen->nombre}}
                                                  </label>
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="actores">Actores</label>
                                    <div style="height:300px;overflow-y: scroll;">
                                        @foreach ($actores as $act)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{$act->idActor}}" name="idActor[]">
                                                <label class="form-check-label">
                                                      {{$act->nombres}}&nbsp;{{$act->apellidos}}
                                                  </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                    <div class="col-sm-10">
                                      <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
