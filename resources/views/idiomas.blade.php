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
        <strong>Idiomas</strong>
    </div>
    <form method="post" action="{{ env('APP_URL') }}idiomas" class="form-horizontal" style="margin:20px 0" enctype="multipart/form-data">     
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="idiomas_id" class="col-sm-12 col-md-2 control-label">Idioma </label>
            <div class="col-sm-12 col-md-5">
                <select id="idiomas_id" name="idiomas_id" class="form-control">
                    @foreach($idiomas as $idioma)
                    <option value="{{$idioma->id}}">{{$idioma->nombre}}</option>
                    @endforeach
                </select>
            </div>
			
			<label for="nativo" class="col-sm-12 col-md-2 control-label">¿Es su idioma nativo?</label>
                <label class="radio-inline">
                    <input type="radio" name="nativo" value="1" required>Si
                </label>
                <label class="radio-inline">
                    <input type="radio" name="nativo" value="0">No
                </label>
        </div>		
		
        <div class="form-group">
			<div id="nombre_certificado">
				<label for="nombre_certificado" class="col-sm-12 col-md-2 control-label">Nombre del certificado</label>
				<div class="col-sm-12 col-md-9">
					<input type="text" id="nombre_certificado_input" class="form-control" name="nombre_certificado" placeholder="">
				</div>
			</div>            
        </div>
		
        <div class="form-group">
			<div id="puntaje">
				<label for="" class="col-sm-12 col-md-2 control-label">Puntaje</label>
				<div class="col-sm-12 col-md-9">
					<input type="text" id="puntaje_input" class="form-control" name="puntaje" placeholder="">
				</div>
			</div>            
        </div>
		
        <div class="form-group">
			<div id="adjunto">
				<label for="adjunto" class="col-sm-12 col-md-2 control-label">Documento de soporte:</label>
				<div class="col-sm-12 col-md-5">
					<input type="file" id="adjunto_input" class="form-control" name="adjunto">
					<br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
				</div>
			</div>            
        </div>
		
        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-success form-control">
                    <i class="fa fa-language" aria-hidden="true"></i>
                    <i class="fa fa-plus" aria-hidden="true"></i>                    
                    Adicionar información de idioma
                </button>
            </div>
        </div>  

    </form>    

    <div class="panel-heading">
        <strong>Resumen de idiomas dominados</strong>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Idioma</th>
					<th>Nativo</th>
                    <th>Tipo de certificación</th>
                    <th>Documento de soporte</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            @forelse($idiomas_certificados as $idioma_certificado)
            <tr>
                <td>
                    {{$idiomas[$idioma_certificado->idiomas_id]->nombre}}
                </td>
				<td>
					@if($idioma_certificado->nativo == 1)
						Si
					@else
						No
					@endif
                </td>
                <td>
					@if($idioma_certificado->nativo == 1)
						No requerido
					@else
						{{$idioma_certificado->nombre_certificado}}
					@endif                    
                </td>
                <td>
					@if($idioma_certificado->nativo == 1)
						No requerido
					@else
						<a href="{{env('APP_URL').$idioma_certificado->ruta_adjunto}}" target="_blank">Documento adjunto</a>
					@endif                    
                </td>
                <td>
                    <form method="post" action="{{ env('APP_URL') }}idiomas/delete" style="margin:20px 0">     
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$idioma_certificado->id}}"/>
                        <button type="submit" data-id="{{$idioma_certificado->id}}" class="btn btn-danger btn-sm">
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
        $("input[name='nativo']").on("change", function () {			
            if ($(this).val() == 0) {				
                $("#nombre_certificado, #puntaje, #adjunto").show();
				$("#nombre_certificado_input, #adjunto_input").attr("required", "required");
            } else {  
                $("#nombre_certificado, #puntaje, #adjunto").hide();
				$("#nombre_certificado_input, #adjunto_input").removeAttr("required");
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
