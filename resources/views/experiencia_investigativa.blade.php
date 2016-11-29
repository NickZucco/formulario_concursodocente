@extends('main')

@section('form')

<div class="panel panel-default">
    @if($msg)
    <div class="alert alert-success" role="alert">
        {{$msg}}
    </div>
    @endif
    <div class="panel-heading">
        <strong>Experiencia en investigación</strong>
    </div>

    <form name="registro" id="registro" method="post" action="{{ env('APP_URL') }}experiencia_investigativa" class="form-horizontal" style="margin:20px 0" enctype="multipart/form-data">     
        {!! csrf_field() !!}

        <div class="panel-body">
            <div class="form-group">
                <label for="nombre_proyecto" class="col-sm-12 col-md-3 control-label">Nombre del proyecto</label>
                <div class="col-sm-12 col-md-9">
                    <input type="text" class="form-control" id="nombre_proyecto" name="nombre_proyecto" placeholder="Nombre del proyecto">
                </div>
            </div>

            <div class="form-group">
                <label for="area_proyecto" class="col-sm-12 col-md-3 control-label">Área del proyecto</label>
                <div class="col-sm-12 col-md-9">
                    <input type="text" class="form-control" id="area_proyecto" name="area_proyecto" placeholder="Área del proyecto">
                </div>
            </div>
            <div class="form-group">
                <label for="funcion_principal" class="col-sm-12 col-md-3 control-label">Funciones principales</label>
                <div class="col-sm-12 col-md-9">
                    <textarea name="funcion_principal" id="funcion_principal" class="form-control" placehoder="Funciones principales"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="fecha_inicio" class="col-sm-12 col-md-3 control-label">Fecha de inicio de la vinculación</label>
                <div class="col-sm-12 col-md-2">
                    <input type="text" class="start datepicker form-control" id="fecha_inicio" name="fecha_inicio" placeholder="####-##-##">
                </div>
                <label for="fecha_fin" class="col-sm-12 col-md-3 control-label">Fecha de finalización de la vinculación</label>
                <div class="col-sm-12 col-md-2" id="fecha_fin">
                    <input type="text" class="end datepicker form-control"  name="fecha_fin" placeholder="####-##-##">
                </div>
                <label for="en_curso" class="col-sm-12 col-md-1 control-label">¿En curso?</label>
                <div class="col-md-1">
                    <label class="radio-inline">
                        <input type="radio" name="en_curso" data-id="fecha_fin" value="1">Si
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="en_curso" data-id="fecha_fin" value="0">No
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="paises_id" class="col-sm-12 col-md-3 control-label">País</label>
                <div class="col-sm-3">
                    <select id="paises_id" name="paises_id" class="form-control">
                        @foreach($paises as $pais)
                        <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="adjunto" class="col-sm-12 col-md-3 control-label">Documento de soporte: </label>
                <div class="col-sm-12 col-md-9">
                    <input id="adjunto" type="file" class="form-control" name="adjunto" required />
                    <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-success form-control">
                        <i class="fa fa-list-ul" aria-hidden="true"></i>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Agregar experiencia investigativa
                    </button>
                </div>
            </div>     
        </div>

    </form>

    <div class="panel-heading">
        <strong>Resumen de experiencia</strong>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre del proyecto</th>
                    <th>Área del proyecto</th>
                    <th>Inicio de vinculacion</th>
                    <th>Fin de vinculacion</th>
                    <th>Documento adjunto</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            @forelse($experiencias_investigativa as $experiencia_investigativa)
            <tr>
                <td>
                    {{$experiencia_investigativa->nombre_proyecto}}
                </td>
                <td>
                    {{$experiencia_investigativa->area_proyecto}}
                </td>
                <td>
                    {{$experiencia_investigativa->fecha_inicio}}
                </td>
                <td>
                    {{$experiencia_investigativa->fecha_fin}}
                </td>
                <td>
                    <a href="{{env('APP_URL').$experiencia_investigativa->ruta_adjunto}}">Documento adjunto</a>
                </td>
                <td>
                    <form method="post" action="{{ env('APP_URL') }}experiencia_investigativa/delete" style="margin:20px 0">     
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$experiencia_investigativa->id}}"/>
                        <button type="submit" data-id="{{$experiencia_investigativa->id}}" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No se han ingresado información asociada.</td>
            </tr>
            @endforelse
        </table>
    </div>

</div>
<script>
    (function ($) {
        $("input[name='en_curso']").on("change", function () {
            var $this = $(this);
            if ($this.val() == 0) {
                $("#" + $(this).data("id")).show();
                $("#" + $(this).data("id") + " input").removeAttr("disabled");
            } else {
                $("#" + $(this).data("id")).hide();
                $("#" + $(this).data("id") + " input").attr("disabled");
            }
        });
    })(jQuery);
</script>

@stop
