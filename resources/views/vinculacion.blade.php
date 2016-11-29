@extends('main')

@section('form')

<div class="panel panel-default">
    @if($msg)
    <div class="alert alert-success" role="alert">
        {{$msg}}
    </div>
    @endif
    <div class="panel-heading">
        <strong>Vinculación actual</strong>
    </div>

    <form method="post" action="{{ env('APP_URL') }}vinculaciones" class="form-horizontal" style="margin:20px 0">     
        {!! csrf_field() !!}
        <div class="panel-body">
            <div class="form-group">
                <label for="tipos_vinculacion" class="col-sm-2 control-label">Tipo de vinculación</label>
                <div class="col-sm-3">
                    <select id="tipos_vinculacion" name="tipo" class="form-control">
                        <option value="PROFESOR" data-field="">PROFESOR</option>
                        <option value="ESTUDIANTE" data-field="">ESTUDIANTE</option>
                        <option value="EMPLEADO" data-field="">EMPLEADO</option>
                        <option value="INDEPENDIENTE" data-field="">INDEPENDIENTE</option>
                        <option value="OTRO" data-field="vinculacion_otro">OTRO</option>
                    </select>
                </div>
                <div id="vinculacion_otro" style="display:none">
                    <label for="tipos_vinculacion" class="col-sm-1 control-label">¿Cual?</label>
                    <div class="col-sm-12 col-md-4">
                        <input type="text" class="form-control" id="tipo_txt" name="tipo" placeholder="Nombre del tipo de vinculación">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="nombre_institucion" class="col-sm-12 col-md-2 control-label">Nombre de la institución</label>
                <div class="col-sm-12 col-md-4">
                    <input type="text" class="form-control" id="nombre_institucion" name="nombre_institucion" placeholder="Nombre de la institución">
                </div>
            </div>

            <div class="form-group">
                <label for="fecha_vinculacion" class="col-sm-12 col-md-2 control-label">Fecha de vinculación</label>
                <div class="col-sm-12 col-md-2">
                    <input type="text" class="datepicker end form-control" id="fecha_vinculacion" name="fecha_vinculacion" placeholder="####-##-##">
                </div>
                <label for="ciudad" class="col-sm-12 col-md-1 control-label">Ciudad</label>
                <div class="col-sm-12 col-md-2">
                    <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad">
                </div>
                <label for="paises_id" class="col-sm-12 col-md-2 control-label">País de vinculación</label>
                <div class="col-sm-12 col-md-3">               
                    <select id="paises_id" name="paises_id" class="form-control">
                        @foreach($paises as $pais)
                        <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="perfil_laboral" class="col-md-2 control-label">&nbsp;&nbsp;&nbsp;Descripción del perfil laboral</label>
                <div class="col-sm-12 col-md-12">
                    <textarea id="perfil_laboral" class="form-control" name="perfil_laboral" placeholder="Ingrese en un parrafo de max. 500 caracteres la descripción de su perfil"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-success form-control"><i class="glyphicon glyphicon-save-file"></i>Guardar</button>
                </div>
            </div> 
        </div>
        <input type="hidden" class="form-control" id="id" name="aspirantes_id" placeholder="" value="{{$aspirante_id}}">
    </form>  

    <div class="panel-heading">
        <strong>Resumen de vinculaciones ingresadas</strong>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre de la institución</th>
                    <th>Fecha de vinculación</th>
                    <th>País de vinculación</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            @forelse($vinculaciones_academicas as $vinculacion_academica)
            <tr>
                <td>
                    {{$vinculacion_academica->nombre_institucion}}
                </td>
                <td>
                    {{$vinculacion_academica->fecha_vinculacion}}
                </td>
                <td>
                    {{$paises[$vinculacion_academica->paises_id]->nombre}}
                </td>
                <td>
                    <form method="post" action="{{ env('APP_URL') }}vinculaciones/delete" style="margin:20px 0">     
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{$vinculacion_academica->id}}"/>
                    <button type="submit" data-id="{{$vinculacion_academica->id}}" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No se han ingresado información asociada.</td>
            </tr>
            @endforelse
        </table>
    </div>
</div>
<script>
    (function ($) {
        $("#tipos_vinculacion").on("change", function () {

            var selected_val = $(this).find("option:selected").val();
            console.log(selected_val);
            if (selected_val === "OTRO") {
                $("#vinculacion_otro").show();
                $("#tipo_txt").removeAttr("disabled");
                $("#tipo_txt").removeAttr("readonly");
            } else {
                $("#vinculacion_otro").hide();
                $("#tipo_txt").attr("disabled", true);
                $("#tipo_txt").attr("readonly", true);
            }
        });
    })(jQuery);
</script>

@stop