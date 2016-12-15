@extends('main')

@section('form')

<div class="panel panel-default">
    @if($msg)
    <div class="alert alert-success" role="alert">
        {{$msg}}
    </div>
    @endif
    <div class="panel-heading">
        <strong>Experiencia docente</strong>
    </div>

    <form name="registro" id="registro" method="post" action="{{ env('APP_URL') }}experiencia_docente" class="form-horizontal" style="margin:20px 0" enctype="multipart/form-data">     
        {!! csrf_field() !!}

        <div class="panel-body">
            <div class="form-group">
                <label for="nombre_institucion" class="col-sm-12 col-md-2 control-label">Nombre de la institución</label>
                <div class="col-sm-12 col-md-5">
                    <input type="text" class="form-control" id="nombre_institucion" name="nombre_institucion" placeholder="Nombre de la institución" required>
                </div>

                <label for="dedicacion" class="col-sm-12 col-md-2 control-label">Dedicación</label>
                <div class="col-sm-12 col-md-3">
                    <select id="dedicacion" name="dedicacion" class="form-control">
                        @foreach($tipos_vinculacion_docente as $tvd)
                        <option value="{{$tvd->id}}">{{$tvd->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="fecha_inicio" class="col-sm-12 col-md-2 control-label">Fecha de inicio de vinculación</label>
                <div class="col-sm-12 col-md-4">
                    <input type="text" class="datepicker start form-control" id="fecha_inicio" name="fecha_inicio" placeholder="####-##-##" required>
                </div>
                <label for="fecha_finalizacion" class="col-sm-12 col-md-2 control-label">Fecha de finalización de vinculación</label>
                <div class="col-sm-12 col-md-4">
                    <input type="text" class="datepicker end form-control" id="fecha_finalizacion" name="fecha_finalizacion" placeholder="####-##-##" required>
                </div>
            </div>

            <div class="form-group">
                <label for="area_trabajo" class="col-sm-12 col-md-2 control-label">Áreas de trabajo</label>
                <div class="col-sm-12 col-md-10">
                    <textarea name="area_trabajo" id="area_trabajo" class="form-control"></textarea>
                </div>
            </div>

            <!---->
            <div class="form-group" id="dynamic-form">
                <label for="area_trabajo" class="col-sm-12 col-md-2 control-label">Información de asignaturas impartidas</label>
                <div class="col-sm-12 col-md-10">
                    <table id="asignaturas_form" data-rowname="asignaturas" class="dynaform table table-hover">
                        <thead>
                            <tr class="header">
                                <th>Nombre de la asignatura</th>
                                <th>Intensidad de horas por semana</th>
                                <th style="width:10px">
                                    <button class="addBtn btn btn-default" data-id="asignaturas_form" data-name="asignaturas"><span class="glyphicon glyphicon-plus"></span></button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tr" data-index="0">
                                <td>
                                    <input class="form-control" type="text" name="info_asignaturas[nombre][]" value="" required>
                                </td>
                                <td>
                                    <input class="form-control" type="number" name="info_asignaturas[intensidad][]" value="" required>
                                </td>
                                <td>
                                    <button class="addBtnRemove btn btn-default"><span class="glyphicon glyphicon-minus"></span></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12 col-md-2">
                    <label for="adjunto" class="col-sm-12 col-md-2 control-label">Documento de soporte: </label>
                </div>
                <div class="col-sm-12 col-md-10">
                    <input id="adjunto" type="file" class="form-control" name="adjunto" required />
					<em>No obligatorio para experiencia docente en la Universidad Nacional de Colombia - Sede Bogotá</em>
                    <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB.</em>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-success form-control">
                        <i class="fa fa-list-ul" aria-hidden="true"></i>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Adicionar experiencia docente
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
                    <th>Nombre de la institución/empresa</th>
                    <th>Fecha de inicio de vinculación</th>
                    <th>Fecha de fin de vinculación</th>
                    <th>Información de asignaturas impartidas</th>
                    <th>Documento de soporte adjunto</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            @forelse($experiencias_docente as $experiencia_docente)
            <tr>
                <td>
                    {{$experiencia_docente->nombre_institucion}}
                </td>
                <td>
                    {{$experiencia_docente->fecha_inicio}}
                </td>
                <td>
                    {{$experiencia_docente->fecha_finalizacion}}
                </td>
                <td>
                    <table class="toJSONTable" data-json="{{$experiencia_docente->info_asignaturas}}">

                    </table>
                </td>
				<td>
                    @if($experiencia_docente->ruta_adjunto==null)
						<em>No requerido</em>
                    @else
						<a href="{{env('APP_URL').$experiencia_docente->ruta_adjunto}}" target="_blank">Documento adjunto</a>
                    @endif

                </td>
                <td>
                    <form method="post" action="{{ env('APP_URL') }}experiencia_docente/delete" style="margin:20px 0">     
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$experiencia_docente->id}}"/>
                        <button type="submit" data-id="{{$experiencia_docente->id}}" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No se ha ingresado información de experiencia todavia.</td>
            </tr>
            @endforelse
        </table>
    </div>



</div>

<script>
    function addTableRow($button)
    {
        var name = $button.data("name");
        var id = $button.data("id");
        var $last_row = $("#" + id).find("tr:last");
        var last_row_index = $last_row.data("index");
        var next_row_index = last_row_index + 1;
        var $new_row = $last_row.clone();

        $new_row.attr("id", name + "-" + next_row_index);
        $new_row.attr("data-index", next_row_index);

        $new_row.find(".addBtnRemove").attr("data-selector", name + "-" + next_row_index);
        $new_row.find("input").val("");

        $("#" + id).append($new_row);
    }

    // Builds the HTML Table out of myList.
    function buildHtmlTable($selector) {

        var myList = $selector.data("json");
        var columns = addAllColumnHeaders(myList, $selector);

        for (var i = 0; i < myList.length; i++) {
            var row$ = $('<tr/>');
            for (var colIndex = 0; colIndex < columns.length; colIndex++) {
                var cellValue = myList[i][columns[colIndex]];

                if (cellValue == null) {
                    cellValue = "";
                }

                row$.append($('<td/>').html(cellValue));
            }
            $selector.append(row$);
        }
    }

    function addAllColumnHeaders(myList, $selector)
    {
        var columnSet = [];
        var headerTr$ = $('<tr/>');

        for (var i = 0; i < myList.length; i++) {
            var rowHash = myList[i];
            for (var key in rowHash) {
                if ($.inArray(key, columnSet) == -1) {
                    columnSet.push(key);
                    headerTr$.append($('<th/>').html(capitalizeFirstLetter(key)));
                }
            }
        }
        $selector.append(headerTr$);
        return columnSet;
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

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
        $("#dynamic-form").on('click', '.addBtn', function (e) {
            e.preventDefault();
            addTableRow($(this));
        });
        $("#dynamic-form").on('click', '.addBtnRemove', function (e) {
            e.preventDefault();
            $("#" + $(this).data("selector")).remove();
        });
        $(".toJSONTable").each(function (i, e) {
            buildHtmlTable($(this));
        });
    })(jQuery);
</script>
@stop