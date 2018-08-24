@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        <b>Películas:</b> {{$peliculas}}
                    </div>
                    <div class="alert alert-success" role="alert">
                        <b>Géneros:</b> {{$generos}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
