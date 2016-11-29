@extends('main')

@section('form')

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
        </div>
        <div class="form-group">
            <label for="nombre_certificado" class="col-sm-12 col-md-2 control-label">Tipo de certificado</label>
            <div class="col-sm-12 col-md-9">
                <input type="text" class="form-control" id="nombre_certificado" name="nombre_certificado" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-12 col-md-2 control-label">
                Puntaje 
            </label>
            <div class="col-sm-12 col-md-9">
                <input type="text" class="form-control" id="nombre_certificado" name="puntaje" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="adjunto" class="col-sm-12 col-md-2 control-label">Documento de soporte: </label>
            <div class="col-sm-12 col-md-5">
                <input id="adjunto" type="file" class="form-control" name="adjunto" required />
                <br><em>Por favor, tenga en cuenta que el archivo adjunto debe estar en formato PDF y no tener un tamaño superior a 10MB</em>
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
                    {{$idioma_certificado->nombre_certificado}}
                </td>
                <td>
                    <a href="{{env('APP_URL').$idioma_certificado->ruta_adjunto}}">Documento adjunto</a>
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
@stop
