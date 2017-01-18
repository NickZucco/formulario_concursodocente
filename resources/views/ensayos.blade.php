@extends('main')

@section('form')

<div class="panel panel-default">
    @if($msg)
    <div class="alert alert-success" role="alert">
        {{$msg}}
    </div>
    @endif
    <div class="panel-heading">
        <strong>Componente escrito por perfil</strong>
    </div>

    @if($perfiles_seleccionados->isEmpty())
    <div class="alert alert-warning" role="alert">
        No se encontraron perfiles seleccionados. Por favor, seleccione primero a que perfiles desea aplicar en la opción <a href="{{ env('APP_URL') }}perfiles" data-path="perfiles" class="alert-link"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;Perfiles</a> e intentelo nuevamente.
    </div>
    @else
    <form name="registro" id="registro" method="post" action="{{ env('APP_URL') }}perfiles/ensayos" class="form-horizontal" style="margin:20px 0"  enctype="multipart/form-data">     
        {!! csrf_field() !!}
        <div class="panel-body">
            @foreach($perfiles_seleccionados as $perfil_seleccionado)
            <div class="well">
                <div class="form-group">
                    <label for="adjunto_{{$perfil_seleccionado->id}}" class="col-sm-12 col-md-3 control-label">Componente escrito para el perfil {{$perfil_seleccionado->identificador}} - {{$perfil_seleccionado->departamento}}: </label>
                    <div class="col-sm-12 col-md-5">
                        <input id="adjunto_{{$perfil_seleccionado->id}}" type="file" class="form-control" name="adjunto_{{$perfil_seleccionado->id}}" required/>
                        <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato Word (.docx) y no tener un tamaño superior a 1MB</em>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        @if($perfil_seleccionado->ruta_ensayo)
                        Archivo cargado previamente: <a href="{{env('APP_URL').$perfil_seleccionado->ruta_ensayo}}" target="_blank">Ensayo</a>
                        <br><em>Por favor, tenga en cuenta que al cargar un nuevo archivo, se actualizará el archivo previamente cargado</em>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-success form-control">
                        <i class="fa fa-book" aria-hidden="true"></i>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Adicionar ensayos
                    </button>
                </div>
            </div> 
        </div>
    </form>
    @endif
</div>

<script>
    
    (function ($) {

		$("input[type='file']").fileinput({
            language: 'es',
            showUpload: false,
            maxFileSize: 1024,
            allowedFileExtensions: ["docx"],
            initialPreviewConfig: {
                width: '100%'
            }
        });
		
		})(jQuery);
		
</script>

@stop