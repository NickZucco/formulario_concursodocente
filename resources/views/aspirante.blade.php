@extends('main')

@section('form')

<div class="alert alert-warning alert-dismissible" role="alert">
  <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <strong>Nota: </strong>Por favor, tenga en cuenta que toda la información que digite en el formulario, debe registrarse únicamente en español
</div>

<div class="panel panel-default">
	@if(session()->has('message'))
		<div class="alert alert-danger" role="alert">
			{{ session()->get('message') }}
		</div>
	@endif
    
    <div class="panel-heading">
        <strong>Datos personales</strong>
    </div>
    <form method="post" action="{{ env('APP_URL') }}datos" class="form-horizontal" style="margin:20px 0"  enctype="multipart/form-data">
        
        {!! csrf_field() !!}
        
        <div class="panel-body">
            <div class="form-group">
                <label for="apellido" class="col-sm-2 control-label">Apellidos completos</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="" value="{{$candidate_info->apellido}}" required/>
                </div>
            </div>
            <div class="form-group">
                <label for="nombre" class="col-sm-2 control-label">Nombres completos</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="" value="{{$candidate_info->nombre}}" required/>
                </div>
            </div>
            <div class="form-group">
                <label for="tipo_documento" class="col-md-2 col-sm-12 control-label">Tipo de documento de identidad</label>
                <div class="col-md-2">
                    <select id="tipo_documento" name="tipo_documento_id" class="form-control" required>
                        @foreach($tipos_documento as $tipo_documento)
                        <option value="{{$tipo_documento->id}}"
                                @if($tipo_documento->id == $candidate_info->tipo_documento_id)
									selected
                                @endif
                                >{{$tipo_documento->nombre}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <label for="documento" class="col-md-2 col-sm-12 control-label">Número de documento</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="documento" name="documento" placeholder="##########" value="{{$candidate_info->documento}}" required/>
                </div>
                <label for="ciudad_expedicion_documento" class="col-md-2 col-sm-12 control-label">Ciudad de expedición</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="ciudad_expedicion_documento" name="ciudad_expedicion_documento" placeholder="" value="{{$candidate_info->ciudad_expedicion_documento}}" required/>
                </div>
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento" class="col-md-2 control-label">Fecha de nacimiento</label>
                <div class="col-md-2">
                    <input type="text" class=" datepicker2 maxToday form-control" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="####-##-##" value="{{$candidate_info->fecha_nacimiento}}" required/>
                </div>
                <label for="pais_nacimiento" class="col-md-2 control-label">País de nacimiento</label>
                <div class="col-md-2">
                    <select id="pais_nacimiento" class="form-control" name="pais_nacimiento" required>
                        @foreach($paises as $pais)
                        <option value="{{$pais->id}}"
                                @if($pais->id == $candidate_info->pais_nacimiento)
                                selected
                                @endif
                                >{{$pais->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="pais_residencia" class="col-md-2 control-label">País de residencia</label>
                <div class="col-md-2">
                    <select id="pais_residencia" class="form-control" name="pais_residencia" required>
                        @foreach($paises as $pais)
                        <option value="{{$pais->id}}"
                                @if($pais->id == $candidate_info->pais_residencia)
                                selected
                                @endif
                                >{{$pais->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="estado_civil" class="col-md-2 control-label">Estado civil</label>
                <div class="col-md-2">
                    <select id="estado_civil" class="form-control" name="estado_civil_id" required>
                        @foreach($estados_civiles as $estado_civil)
                        <option value="{{$estado_civil->id}}"
                                @if($candidate_info->estado_civil == $estado_civil->nombre)
                                selected
                                @endif
                                >{{$estado_civil->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="direccion_residencia" class="col-md-2 control-label">Dirección de residencia</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="direccion_residencia" name="direccion_residencia" placeholder="" value="{{$candidate_info->direccion_residencia}}" required>
                </div>
                <label for="ciudad_aplicante" class="col-md-2 control-label">Ciudad desde la cual aplica</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="ciudad_aplicante" name="ciudad_aplicante" placeholder="" value="{{$candidate_info->ciudad_aplicante}}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="telefono_fijo" class="col-sm-2 control-label">Teléfono fijo</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="telefono_fijo" name="telefono_fijo" placeholder="#######" value="{{$candidate_info->telefono_fijo}}" required>
                </div>
                 <label for="telefono_movil" class="col-sm-2 control-label">Teléfono movil</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="telefono_movil" name="telefono_movil" placeholder="#######" value="{{$candidate_info->telefono_movil}}">
                </div>
            </div>
            <div class="form-group">
                <label for="correo" class="col-sm-2 control-label">Correo electrónico</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="_correo" name="_correo" placeholder="" value="{{$correo}}" readonly disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="adjunto" class="col-sm-12 col-md-2 control-label">Documento de identidad (obligatorio): </label>
                <div class="col-sm-12 col-md-4">
                    <input id="adjunto" type="file" class="form-control" name="adjunto_documento" required>
                    <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
                </div>
                <div class="col-md-6">
                    @if($candidate_info->ruta_adjunto_documento)
                    Archivo cargado previamente: <a href="{{env('APP_URL').$candidate_info->ruta_adjunto_documento}}" target="_blank">Documento</a>
                    <br><em>Por favor, tenga en cuenta que al cargar un nuevo archivo, se actualizará el archivo previamente cargado</em>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="adjunto" class="col-sm-12 col-md-2 control-label">Tarjeta profesional (opcional): </label>
                <div class="col-sm-12 col-md-4">
                    <input id="adjunto" type="file" class="form-control" name="adjunto_tarjetaprofesional" />
                    <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
                </div>
                <div class="col-md-6">
                    @if($candidate_info->ruta_adjunto_tarjetaprofesional)
                    Archivo cargado previamente: <a href="{{env('APP_URL').$candidate_info->ruta_adjunto_tarjetaprofesional}}" target="_blank">Tarjeta profesional</a>
                    <br><em>Por favor, tenga en cuenta que al cargar un nuevo archivo, se actualizará el archivo previamente cargado</em>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-success form-control">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;Guardar datos personales
                    </button>
                </div>
            </div>
        </div>

        <input type="hidden" class="form-control" id="correo" name="correo" value="{{$correo}}">
        <input type="hidden" class="form-control" id="id" name="id" value="{{$id}}">
    </form>
    
</div>

<script>
    
    (function ($) {

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

@endsection

