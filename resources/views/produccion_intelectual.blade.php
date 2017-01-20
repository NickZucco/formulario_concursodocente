@extends('main')

@section('form')

<div class="alert alert-warning alert-dismissible" role="alert">
  <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <strong>Nota: </strong>En relación con la experiencia y 
	la valoración de productividad académica, se tendrán en cuenta los cinco (5) años recientes en el caso de los 
	perfiles de dedicación exclusiva y tiempo completo. En los perfiles de dedicación cátedra, se tendrán en cuenta 
	los diez (10) años recientes.
</div>

@if($msg)
<div class="alert alert-success" role="alert">
    {{$msg}}
</div>
@endif
<form name="registro" id="registro" method="post" action="{{ env('APP_URL') }}produccion_intelectual" class="form-horizontal" style="margin:20px 0"  enctype="multipart/form-data">     
    {!! csrf_field() !!}

    <div class="panel panel-default">


        <div class="panel-heading">
            <strong>Producción intelectual</strong>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="tipos_produccion_intelectual_id" class="col-sm-12 col-md-2 control-label">Tipo de producción intelectual</label>
                <div class="col-sm-12 col-md-3">
                    <select id="tipos_publicacion" name="tipos_produccion_intelectual_id" class="form-control">
                        <option value="">--Seleccione una opción--</option>
                        @foreach($tipos_produccion_intelectual as $tipo_produccion_intelectual)
                        <option value="{{$tipo_produccion_intelectual->id}}">{{$tipo_produccion_intelectual->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> 

        <div class="panel-heading">
            <div style="font-weight: bold">Datos de la producción: <span id="tipo_produccion_lbl"></span></div>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <div id="msg_form" style="text-align: center">
                        Por favor, seleccione un tipo de publicación para ver el formulario asociado.
                    </div>
                    <!--revistas indexadas-->
                    <div id="1" class="publication_form">    
                        <div class="form-group">
                            <label for="tipo" class="control-label col-sm-12 col-md-2">Tipo de publicacion</label>
                            <div class="col-sm-3">
                                <select id="tipo" name="tipo" data-form="2" class="form-control">
                                    <option value="INTERNACIONAL">Internacional</option>
                                    <option value="NACIONAL">Nacional</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre" class="col-sm-12 col-md-2 control-label">Título de la revista</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="publicacion_titulo" name="publicacion_titulo" >
                            </div>
                        </div>
						<div class="form-group">
                            <label for="nombre" class="col-sm-12 col-md-2 control-label">Nombre del artículo</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="publicacion_autor" class="col-sm-12 col-md-2 control-label">Autor(es) como aparece en el artículo</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="publicacion_autor" name="publicacion_autor">
                            </div>
                        </div>
                        <div class="form-group">
                             <label for="clasificacion_revista" class="col-sm-12 col-md-2 control-label">Clasificación de la revista (según Colciencias)</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="clasificacion_revista" name="clasificacion_revista">
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label for="volumen" class="col-sm-12 col-md-2 control-label">Volumen</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="volumen" name="volumen">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paginas" class="col-sm-12 col-md-2 control-label">Número de páginas</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="paginas" name="paginas">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paginas" class="col-sm-12 col-md-2 control-label">Año</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="number" class="form-control" id="año" name="año">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="issn" class="col-sm-12 col-md-2 control-label">ISSN</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="issn" name="issn">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idiomas_id" class="col-sm-12 col-md-2 control-label">Idioma </label>
                            <div class="col-sm-12 col-md-5">
                                <select id="idiomas_id" name="idiomas_id" class="form-control">
                                    @foreach($idiomas as $idioma)
                                    <option value="{{$idioma->id}}">{{$idioma->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--Libro-->
                    <div id="2" class="publication_form">
                        <div class="form-group">
                            <label for="nombre" class="col-sm-12 col-md-2 control-label">Título del libro</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="año" class="col-sm-12 col-md-2 control-label">Año</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="number" class="form-control" id="año" name="año">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paginas" class="col-sm-12 col-md-2 control-label">Número de páginas</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="paginas" name="paginas">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre_editorial" class="col-sm-12 col-md-2 control-label">Nombre de la editorial</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="nombre_editorial" name="nombre_editorial">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="publicacion_autor" class="col-sm-12 col-md-2 control-label">Autor(es) como aparece en el libro</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="publicacion_autor" name="publicacion_autor">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="isbn" class="col-sm-12 col-md-2 control-label">ISBN</label>
                            <div class="col-md-5 col-sm-12">
                                <input type="text" class="form-control" id="isbn" name="isbn">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idiomas_id" class="col-sm-12 col-md-2 control-label">Idioma </label>
                            <div class="col-sm-12 col-md-5">
                                <select id="idiomas_id" name="idiomas_id" class="form-control">
                                    @foreach($idiomas as $idioma)
                                    <option value="{{$idioma->id}}">{{$idioma->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--Capitulo-->
                    <div id="3" class="publication_form">
                        <div class="form-group">
                            <label for="nombre" class="col-sm-12 col-md-2 control-label">Título del capítulo</label>
                            <div class="col-md-10 col-sm-12">
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre_libro" class="col-sm-12 col-md-2 control-label">Nombre del libro</label>
                            <div class="col-md-10 col-sm-12">
                                <input type="text" class="form-control" id="nombre_libro" name="nombre_libro">
                            </div>
                        </div>						
                        <div class="form-group">
                            <label for="año" class="col-sm-12 col-md-2 control-label">Año</label>
                            <div class="col-md-10 col-sm-10">
                                <input type="number" class="form-control" id="año" name="año">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paginas" class="col-sm-12 col-md-2 control-label">Número de páginas</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="paginas" name="paginas">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre_editorial" class="col-sm-12 col-md-2 control-label">Nombre de la editorial</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="nombre_editorial" name="nombre_editorial">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="isbn" class="col-sm-12 col-md-2 control-label">ISBN</label>
                            <div class="col-md-10 col-sm-12">
                                <input type="text" class="form-control" id="isbn" name="isbn">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idiomas_id" class="col-sm-12 col-md-2 control-label">Idioma </label>
                            <div class="col-sm-12 col-md-5">
                                <select id="idiomas_id" name="idiomas_id" class="form-control">
                                    @foreach($idiomas as $idioma)
                                    <option value="{{$idioma->id}}">{{$idioma->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--Patente-->
                    <div id="4" class="publication_form">
                        <div class="form-group">
                            <label for="tipo_patente" class="col-sm-12 col-md-2 control-label">Tipo de patente</label>
                            <div class="col-sm-10 col-md-4">
                                <select id="tipo_patente" name="tipo_patente" class="form-control">
                                    <option value="PATENTE">Patente</option>
                                    <option value="SOFTWARE">Software</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre" class="col-sm-12 col-md-2 control-label">Nombre de la patente</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre_libro" class="col-sm-12 col-md-2 control-label">Descripción</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="numero_patente" class="col-sm-12 col-md-2 control-label">Número de patente</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="numero_patente" name="numero_patente">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre_editorial" class="col-sm-12 col-md-2 control-label">Entidad que la registra</label>
                            <div class="col-sm-12 col-md-9">
                                <input type="text" class="form-control" id="entidad_patente" name="entidad_patente">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="año" class="col-sm-12 col-md-2 control-label">Año</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="año" name="año">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paises_id" class="col-sm-12 col-md-2 control-label">País</label>
                            <div class="col-sm-12 col-md-7">
                                <select id="paises_id" name="paises_id" class="form-control">
                                    @foreach($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idiomas_id" class="col-sm-12 col-md-2 control-label">Idioma </label>
                            <div class="col-sm-12 col-md-5">
                                <select id="idiomas_id" name="idiomas_id" class="form-control">
                                    @foreach($idiomas as $idioma)
                                    <option value="{{$idioma->id}}">{{$idioma->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                <div id="additional_fields">
                    <div class="row">
                        <label for="adjunto" class="col-sm-12 col-md-2 control-label">Documento de soporte: </label>
                        <div class="col-sm-12 col-md-9">
                            <input id="adjunto" type="file" class="form-control" name="adjunto" required />
                            <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <button id="submitBtn" type="submit" class="btn btn-success form-control">
                                <i class="fa fa-list-ul" aria-hidden="true"></i>
                                <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                                Adicionar producción intelectual
                            </button>
                        </div>
                    </div>   

                </div>

                  
            </div>
        </div>

    </div>
</form>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Resumen de productos intelectuales</strong>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tipo de producción</th>
                    <th>Nombre</th>
                    <th>Documento de soporte</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            @forelse($producciones_intelectual as $produccion_intelectual)
            <tr>
                <td>
                    {{$tipos_produccion_intelectual[$produccion_intelectual->tipos_produccion_intelectual_id]->nombre}}
                </td>
                <td>
                    {{$produccion_intelectual->nombre}} 
					@if ($produccion_intelectual->tipos_produccion_intelectual_id == 1 || $produccion_intelectual->tipos_produccion_intelectual_id == 2) 
						- {{$produccion_intelectual->publicacion_autor}}
					@endif
                </td>
                <td>
                    <a href="{{env('APP_URL').$produccion_intelectual->ruta_adjunto}}" target="_blank">Documento adjunto</a>
                </td>
                <td>
                    <form method="post" action="{{ env('APP_URL') }}produccion_intelectual/delete" style="margin:20px 0">     
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$produccion_intelectual->id}}"/>
                        <button  type="submit" data-id="{{$produccion_intelectual->id}}" class="btn btn-danger btn-sm">
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
        $(".publication_form").hide();
        $("#additional_fields").hide();
        $("#tipos_publicacion").change(function () {
            //
            $(".publication_form").hide();
            $(".publication_form").find("input,select,textarea").attr("disabled","disabled");
            $(".publication_form").find("input,select,textarea").attr("readonly","readonly");
            $(".publication_form").find("input,select,textarea").removeAttr("required","required");
            //
            var id = $("#tipos_publicacion option:selected").val();
            $("#" + id).show();
            $("#" + id).find("input,select,textarea").removeAttr("disabled");
            $("#" + id).find("input,select,textarea").attr("required","required");
            $("#" + id).find("input,select,textarea").removeAttr("readonly");
            $("#tipo_produccion_lbl").text($("#tipos_publicacion option:selected").text());
            $("#msg_form").hide();
            $("#additional_fields").show();
        });
		
		$("#año").change(function(){
			if(parseInt(this.value) < 2006 || parseInt(this.value) > 2017){
				this.value = '';
				alert('En relación con la experiencia y la valoración de productividad académica, ' +
				'se tendrán en cuenta los cinco (5) años recientes en el caso de los perfiles de dedicación ' +
				'exclusiva y tiempo completo. En los perfiles de dedicación cátedra, se tendrán en cuenta ' +
				'los diez (10) años recientes.')
			} 
        });
		
		$("input[type='file']").fileinput({
            language: 'es',
            showUpload: false,
            maxFileSize: 10240,
            allowedFileExtensions: ["pdf"],
            initialPreviewConfig: {
                width: '100%'
            }
        });
    })(jQuery);
</script>

@stop