@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Géneros  <a class="btn btn-primary" href="{{url('generos/create')}}" title="Nuevo género" role="button">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </a></div>
                <div class="card-body">
                    @include('includes.messages')
                    @include('panel.generos.delete')
                    @include('panel.generos.trash')
                    @include('panel.generos.restore')
                    <a class="btn btn-link {{strpos(Request::fullUrl(), 'generos?display=all') ? 'disabled' : ''}}" href="{{URL::action('GeneroController@index',['display'=>'all'])}}">@lang("messages.all")</a> | 
                    <a class="btn btn-link" href="{{url('generos')}}">@lang("messages.actives")</a> | 
                    <a class="btn btn-link {{strpos(Request::fullUrl(), 'generos?display=trash') ? 'disabled' : ''}}" href="{{URL::action('GeneroController@index',['display'=>'trash'])}}">@lang("messages.trash")</a>
               
                  <div class="table-responsive">
                    {{$generos->appends(Request::capture()->except('page'))->links()}}
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Nombre</th>                        
                        <th scope="col">Películas</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($generos as $gen)
                            <tr>
                                <th scope="row">{{$gen->nombre}}</th>
                                <td>
                                    <span class="badge badge-pill badge-{{$gen->peliculas_count == 0 ? 'danger' : 'info' }}">{{$gen->peliculas_count}}</span>
                                </td>
                                <td>
                                    @if ($gen->trashed())
                                        <a title="Restaurar" data-toggle="modal" data-target="#modalRestore" 
                                        data-name="{{$gen->nombre}}" href="#"
                                        data-action="{{route('generos.restore',$gen->idGenero)}}"
                                        class="btn btn-success btn-xs"><i class="fa fa-archive" aria-hidden="true"></i></a>
                                        <a title="Borrar permanentemente" data-toggle="modal" data-target="#modalDelete" 
                                        data-name="{{$gen->nombre}}" href="#"
                                        data-action="{{route('generos.destroy',$gen->idGenero)}}"
                                        class="btn btn-warning btn-xs"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
                                    @else
                                        <a title="Ver" href="{{route('generos.show',$gen->idGenero)}}" class="btn btn-info btn-xs"><i class="fa fa-folder-open" aria-hidden="true"></i></a>
                                        <a title="Editar" href="#" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a title="Enviar a papelera" data-toggle="modal" data-target="#modalTrash" 
                                        data-name="{{$gen->nombre}}" href="#"
                                        data-action="{{route('generos.trash',$gen->idGenero)}}"
                                        class="btn btn-danger btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                    {{$generos->appends(Request::capture()->except('page'))->links()}}
                </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@prepend('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('#modalTrash').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var name = button.data('name');
            var modal = $(this);
            modal.find(".modal-content #txtTrash").html("¿Está seguro de eliminar el género <b>" + name + "</b>?");
            modal.find(".modal-content form").attr('action', action);
        });
        $('#modalDelete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var name = button.data('name');
            var modal = $(this);
            modal.find(".modal-content #txtDelete").html("¿Está seguro de eliminar permanentemente el género <b>" + name + "</b>?");
            modal.find(".modal-content form").attr('action', action);
        });
        $('#modalRestore').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var name = button.data('name');
            var modal = $(this);
            modal.find(".modal-content #txtRestore").html("¿Está seguro de restaurar el género <b>" + name + "</b>?");
            modal.find(".modal-content form").attr('action', action);
        });
    });
</script>
@endprepend
