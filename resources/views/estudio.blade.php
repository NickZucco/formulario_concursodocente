@extends('main')

@section('form')

<div class="panel panel-default">
    @if($msg)
    <div class="alert alert-success" role="alert">
        {{$msg}}
    </div>
    @endif
    <div class="panel-heading">
        <strong>Estudios</strong>
    </div>
    <form method="post" action="{{ env('APP_URL') }}estudios" class="form-horizontal" style="margin:20px 0" enctype="multipart/form-data">
        {!! csrf_field() !!}

        <div class="panel-body">
            <div class="form-group">
                <label for="titulo" id="titulo" class="col-sm-12 col-md-2 control-label">Título académico obtenido</label>
                <div class="col-sm-12 col-md-9">
                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Nombre del título académico obtenido" required>
                </div>
            </div>
            <div class="form-group">
                <label for="institucion" class="col-sm-12 col-md-2 control-label">Nombre de la institución</label>
                <div class="col-sm-12 col-md-9">
                    <input type="text" class="form-control typeahead" id="institucion" name="institucion" placeholder="Nombre de la institución" data-provide="typeahead"  autocomplete="off" value="" required>
                </div>
            </div>

            <div class="form-group">
                <label for="fecha_inicio" class="col-sm-12 col-md-2 control-label">Fecha de inicio de vinculación</label>
                <div class="col-sm-12 col-md-2">
                    <input type="text" class="datepicker start maxToday form-control" id="fecha_inicio" name="fecha_inicio" placeholder="####-##-##" required>
                </div>
                <div class="col-md-4">
                    <div id="fecha_finalizacion">
                        <label for="fecha_finalizacion" class="col-sm-12 col-md-6 control-label">Fecha de finalización de vinculación</label>
                        <div class="col-sm-12 col-md-6">
                            <input type="text"  class="datepicker end maxToday form-control" name="fecha_finalizacion" placeholder="####-##-##">
                        </div>
                    </div>
                </div>

                <label for="en_curso" class="col-sm-12 col-md-2 control-label">¿En curso?</label>
                <label class="radio-inline">
                    <input type="radio" name="en_curso" data-id="fecha_finalizacion" value="1" required>Si
                </label>
                <label class="radio-inline">
                    <input type="radio" name="en_curso" data-id="fecha_finalizacion" value="0">No
                </label>
            </div>

            <div class="form-group">
                <label for="paises_id" class="col-sm-12 col-md-3 control-label">País donde realizó los estudios </label>
                <div class="col-sm-12 col-md-3">
                    <select id="paises_id" name="paises_id" class="form-control">
                        @foreach($paises as $pais)
                        <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12 col-md-2 ">
                    <label for="adjunto" class="control-label">Documento de soporte: </label>
                </div>
                <div class="col-sm-12 col-md-9">
                    <input id="adjunto" type="file" class="form-control" name="adjunto" required/>
                    <em>No obligatorio para estudios en la Universidad Nacional de Colombia - Sede Bogotá</em>
                    <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
                </div>
            </div>

            <div class="form-group">

                <div class="col-sm-12 col-md-6">
                    <input type="radio" name="additional_attatchments" value="adjunto_entramite_minedu">¿Desea adjuntar documento que manifieste se encuentra en trámite ante el Ministerio de Educación la convalidación de título obtenido en el exterior?<br>
                    <label for="adjunto_entramite_minedu" class="col-sm-12 col-md-12">Documento que manifieste se encuentra en trámite ante el Ministerio de Educación: </label>
                    <div class="col-md-12">
                        <input id="adjunto_entramite_minedu" type="file" class="form-control" name="adjunto_entramite_minedu" disabled/>
                        <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <input type="radio" name="additional_attatchments" value="adjunto_res_convalidacion"> ¿o desea adjuntar resolución de convalidación?<br>
                    <label for="adjunto_res_convalidacion" class="col-sm-12 col-md-12">Resolución de convalidación: </label>
                    <div class="col-sm-12 col-md-12">
                        <input id="adjunto_res_convalidacion" type="file" class="form-control" name="adjunto_res_convalidacion" disabled/>
                        <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-success form-control">
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                    <i class="fa fa-plus" aria-hidden="true"></i>                    
                    Adicionar información de estudios
                </button>
            </div>
        </div>   

    </form>

    <div class="panel-heading">
        <strong>Resumen de estudios ingresados</strong>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre de la institución</th>
                    <th>Título</th>
                    <th>Fecha de inicio de vinculación</th>
                    <th>Fecha de fin de vinculación</th>
                    <th>Documento de soporte</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            @forelse($estudios as $estudio)
            <tr>
                <td>
                    {{$estudio->institucion}}
                </td>
                <td>
                    {{$estudio->titulo}}
                </td>
                <td>
                    {{$estudio->fecha_inicio}}
                </td>
                <td>
					@if(!$estudio->fecha_finalizacion==null)
						{{$estudio->fecha_finalizacion}}
                    @else
						En curso
                    @endif
                </td>
                <td>
                    @if(!$estudio->ruta_adjunto==null)
						<a href="{{env('APP_URL').$estudio->ruta_adjunto}} " target="_blank">Documento de soporte</a><br>
                    @else
						No requerido
                    @endif                 
                    @if($estudio->ruta_entramite_minedu)
						<a href="{{env('APP_URL').$estudio->ruta_entramite_minedu}}" target="_blank">Documento de manifiesto: En trámite ante MinEdu</a><br>
                    @endif
                    @if($estudio->ruta_res_convalidacion)
						<a href="{{env('APP_URL').$estudio->ruta_res_convalidacion}}" target="_blank">Resolución de convalidación</a><br>
                    @endif
                    @if($estudio->ruta_resumen_ejecutivo)
						<a href="{{env('APP_URL').$estudio->ruta_resumen_ejecutivo}}">Resumen ejecutivo</a><br>
                    @endif
                </td>
                <td>
                    <form method="post" action="{{ env('APP_URL') }}estudios/delete" class="form-horizontal" style="margin:20px 0">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$estudio->id}}"/>
                        <button type="submit" data-id="{{$estudio->id}}" class="btn btn-danger btn-sm">
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
	$( document ).ready(function() {
 		$("input[name='additional_attatchments']").attr("required", "required");
 	});

    (function ($) {
        $("input[name='en_curso']").on("change", function () {
            var $this = $(this);
            if ($this.val() == 0) {
                $("#" + $(this).data("id")).show();
                $("#" + $(this).data("id") + " input").removeAttr("disabled");
				$("#" + $(this).data("id") + " input").attr("required", "required");
            } else {
                $("#" + $(this).data("id")).hide();
                $("#" + $(this).data("id") + " input").attr("disabled");
				$("#" + $(this).data("id") + " input").removeAttr("required");
            }
        });
		
        $("input[name='additional_attatchments']").on("change", function () {
            var pais = $("#paises_id").val();
            var id = $(this).val();
            var name = $(this).attr("name");
            
            $("input[name='" + name + "']").each(function (i, e) {
             
                $("#" + $(this).val()).fileinput("disable");
                $("#" + $(this).val()).removeAttr("required");
            });
            $("#" + id).fileinput("enable");
            if (pais != 57) {
                $("#" + id).attr("required", "required");
            }
        });
		
        var unal_places = [
            'Universidad Nacional de Colombia - Sede Bogotá',
        ];
		
        var unal_bh = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: unal_places
        });
		
        $('#institucion').typeahead(
                null, {
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
                $("#paises_id").val('57').change();
            }
        });

        $('#institucion').bind('typeahead:select', function (ev, suggestion) {
            unal_selected = true;
        });

        $('#paises_id').on("change", function () {
            var $selected=$(this).find("option:selected");
            
            if ($.trim($selected.text().toLowerCase()) != 'colombia') {
                //console.log($.trim($selected.text().toLowerCase())+"!="+'colombia');
                $("input[name='additional_attatchments']").attr("required", "required");
            } else {
                //console.log("colombia");
                $("input[name='additional_attatchments']").removeAttr("required");
				$("input[name='additional_attatchments']").prop('checked', false);
                $("input[name='additional_attatchments']").each(function (i, e) {
                    $("#" + $(this).val()).removeAttr("required");
                });
            }

        });
    })(jQuery);
</script>
@stop