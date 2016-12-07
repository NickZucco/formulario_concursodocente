@extends('main')

@section('form')

<div class="panel panel-default">
    @if($msg)
    <div class="alert alert-success" role="alert">
        {{$msg}}
    </div>
    @endif
    <div class="panel-heading">
        <strong>Experiencia laboral</strong>
    </div>

    <form name="registro" id="registro" method="post" action="{{ env('APP_URL') }}experiencia_laboral" class="form-horizontal" style="margin:20px 0"  enctype="multipart/form-data">     
        {!! csrf_field() !!}

        {{Form::open(array('action' => 'ExperienciaLaboralController@insert', 'method' => 'post'))}}

        <div class="panel-body">
            <div class="form-group">
                <label for="nombre_institucion" class="col-sm-12 col-md-2 control-label">Nombre de la institución/empresa</label>
                <div class="col-sm-12 col-md-5">
                    <input type="text" class="form-control" id="nombre_institucion" name="nombre_institucion" data-provide="typeahead" placeholder="Nombre de la institución/empresa">
                </div>

                <label for="tipos_vinculacion_laboral_id" class="col-sm-12 col-md-2 control-label">Tipo de vinculación laboral</label>
                <div class="col-sm-12 col-md-3">
                    <select id="tipos_vinculacion_laboral_id" name="tipos_vinculacion_laboral_id" class="form-control">
                        @foreach($tipos_vinculacion_laboral as $tvl)
                        <option value="{{$tvl->id}}">{{$tvl->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="desde" class="col-sm-12 col-md-2 control-label">Fecha de inicio de vinculación</label>
                <div class="col-sm-12 col-md-4">
                    <input type="text" class="datepicker form-control" id="desde" name="desde" placeholder="####-##-##">
                </div>
                <label for="hasta" class="col-sm-12 col-md-2 control-label">Fecha de fin de vinculación</label>
                <div class="col-sm-12 col-md-4">
                    <input type="text" class="datepicker form-control" id="hasta" name="hasta" placeholder="####-##-##">
                </div>
            </div>
            <div class="form-group">
                <label for="nombre_cargo" class="col-sm-12 col-md-2 control-label">Nombre del cargo</label>
                <div class="col-sm-12 col-md-4">
                    <input type="text" class="form-control" id="nombre_cargo" name="nombre_cargo" placeholder="Nombre del cargo desempeñado">
                </div>
                <label for="funcion_principal" class="col-sm-12 col-md-2 control-label">Función principal</label>
                <div class="col-sm-12 col-md-4">
                    <input type="text" class="form-control" id="funcion_principal" name="funcion_principal" placeholder="Funcion principal desempeñada">
                </div>
            </div>

            <div class="form-group">
                <label for="adjunto" class="col-sm-12 col-md-2 control-label">Documento de soporte: </label>
                <div class="col-sm-12 col-md-10">
                    <input id="adjunto" type="file" class="form-control" name="adjunto" required />
                    <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-success form-control">
                        <i class="fa fa-list-ul" aria-hidden="true"></i>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Adicionar experiencia laboral
                    </button>
                </div>
            </div> 


        </div>

    </form>

    <div class="panel-heading">
        <strong>Resumen de vinculaciones ingresadas</strong>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre de la institución/empresa</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Nombre del cargo</th>
                    <th>Documento adjunto</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            @forelse($experiencias_laboral as $experiencia_laboral)
            <tr>
                <td>
                    {{$experiencia_laboral->nombre_institucion}}
                </td>
                <td>
                    {{$experiencia_laboral->desde}}
                </td>
                <td>
                    {{$experiencia_laboral->hasta}}
                </td>
                <td>
                    {{$experiencia_laboral->nombre_cargo}}
                </td>
                <td>
                    <a href="{{env('APP_URL').$experiencia_laboral->ruta_adjunto}}" target="_blank">Documento adjunto</a>
                </td>
                <td>
                    <form method="post" action="{{ env('APP_URL') }}experiencia_laboral/delete" style="margin:20px 0">     
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$experiencia_laboral->id}}"/>
                        <button type="submit" data-id="{{$experiencia_laboral->id}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No se han ingresado información asociada.</td>
            </tr>
            @endforelse
        </table>
    </div>

</div>
<script>
    (function ($) {
        /**/
        var unal_places = [
            'Universidad Nacional de Colombia - Sede Bogotá',
        ];

        var unal_bh = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: unal_places
        });

        $('#nombre_institucion').typeahead(
                null,
                {
                    name: 'unal_names',
                    source: unal_bh
                }
        );
        $("#nombre_institucion").focusout(function () {
            var i = 0;
            var unal_selected = false;
            while (unal_places.length > i && !unal_selected) {
                if (unal_places[i] == $("#nombre_institucion").val()) {
                    unal_selected = true;
                }
                i++;
            }

            if (!unal_selected) {
                $("#adjunto").attr("required", "required");
            } else {
                $("#adjunto").removeAttr("required");
            }
        });
        $('#nombre_institucion').bind('typeahead:select', function (ev, suggestion) {
            unal_selected = true;
        });
        /**/
    });
</script>
@stop