@extends('main')

@section('form')

<div class="alert alert-warning alert-dismissible" role="alert">
  <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <strong>Nota: </strong>Por favor, tenga en cuenta que toda la información que digite en el formulario, debe registrarse únicamente en español
</div>

<div class="panel panel-default">
    @if($msg)
    <div class="alert alert-success" role="alert">
        {{$msg}}
    </div>
    @endif

    <div class="panel-heading">
        <strong>Distinciones académicas</strong>
    </div>

    <form name="registro" id="registro" method="post" action="{{ env('APP_URL') }}distinciones" class="form-horizontal" style="margin:20px 0" enctype="multipart/form-data">     
        {!! csrf_field() !!}

        <div class="panel-body">
            <div class="form-group">
                <label for="nombre" class="col-sm-12 col-md-2 control-label">Nombre de la distinción</label>
                <div class="col-sm-12 col-md-10">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Premio ######/Mención honorífica ######/Distinción #####/ Galardón #####/Condecoración ####" required>
                </div>

            </div>
            <div class="form-group">
                <label for="institucion" class="col-sm-12 col-md-2 control-label">Nombre de la institución</label>
                <div class="col-sm-12 col-md-6">
                    <input type="text" class="form-control typeahead" id="institucion" name="institucion" data-provide="typeahead" placeholder="Nombre de la institución" autocomplete="off" required>
                </div>
                <label for="fecha_entrega" class="col-sm-12 col-md-2 control-label">Fecha en que se otorgó</label>
                <div class="col-sm-12 col-md-2">
                    <input type="text" class="maxToday datepicker form-control" id="fecha_entrega" name="fecha_entrega" placeholder="####-##-##" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-md-2 ">
                    <label for="adjunto" class="control-label">Documento de soporte: </label>
                </div>
                <div class="col-sm-12 col-md-9">
                    <input id="adjunto" type="file" class="form-control" name="adjunto" required />
					<em>No obligatorio para distinciones otorgadas por la Universidad Nacional de Colombia - Sede Bogotá</em>
                    <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-success form-control">
                    <i class="fa fa-trophy" aria-hidden="true"></i>
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Adicionar distinción
                </button>
            </div>
        </div>
    </form>

    <div class="panel-heading">
        <strong>Resumen de distinciones académicas ingresadas</strong>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre de la distinción</th>
                    <th>Nombre de la institución</th>
                    <th>Fecha de entrega</th>
                    <th>Archivo de soporte adjunto</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            @forelse($distinciones as $distincion)
            <tr>
                <td>{{$distincion->nombre}}</td>
                <td>{{$distincion->institucion}}</td>
                <td>{{$distincion->fecha_entrega}}</td>
                <td>
                    @if($distincion->ruta_adjunto==null)
                    <em>No requerido</em>
                    @else
                    <a href="{{env('APP_URL').$distincion->ruta_adjunto}}" target="_blank">Documento adjunto</a>
                    @endif

                </td>
                <td>
                    <form name="registro" id="registro" method="post" action="{{ env('APP_URL') }}distinciones/delete" class="form-horizontal" style="margin:20px 0">     
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$distincion->id}}"/>
                        <button type="submit" data-id="{{$distincion->id}}" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center">No se han ingresado información asociada.</td>
            </tr>
            @endforelse
        </table>
    </div>
</div>
<script>
    (function ($) {

        var unal_places = [
            'Universidad Nacional de Colombia - Sede Bogotá',
        ];

        var unal_bh = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: unal_places
        });

        $('#institucion').typeahead(
                null,
                {
                    name: 'unal_names',
                    source: unal_bh
                }
        );

        $("#institucion").focusout(function () {
            var i = 0;
            var unal_selected = false;
            while (unal_places.length > i && !unal_selected) {
                if (unal_places[i] == $("#institucion").val()) {
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
        $('#institucion').bind('typeahead:select', function (ev, suggestion) {
            unal_selected = true;
        });
    })(jQuery);
</script>
@stop