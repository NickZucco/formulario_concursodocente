@extends('unal')
@section('content')

<div class="row">
    <div class="col-md-0  toppad  pull-right col-md-offset-3 ">
        <a href="/admin/logout" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1 toppad" >
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Información personal del candidato</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center"> 
                        <img alt="Foto del aspirante" src="{{ env('APP_URL') }}images/dummy.png" class="img-responsive"> 
                    </div>
                    <div class=" col-md-9 col-lg-9 "> 
                        <table class="table table-user-information">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        Fecha de último ingreso: {{$aspirante->updated_at}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nombres:</td>
                                    <td>{{$aspirante->nombre}}</td>
                                </tr>
                                <tr>
                                    <td>Apellidos:</td>
                                    <td>{{$aspirante->apellido}}</td>
                                </tr>
                                <tr>
                                    <td>Documento:</td>
                                    <td>{{$tipos_documento[$aspirante->tipo_documento_id]->sigla}} {{$aspirante->documento}}</td>
                                </tr>
                                <tr>
                                    <td>Dirección:</td>
                                    <td>{{$aspirante->direccion_residencia}}</td>
                                </tr>
                                <tr>
                                    <td>Correo electrónico:</td>
                                    <td><a href="{{$aspirante->correo}}"></a>{{$aspirante->correo}}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <a href="#" data-id="{{$aspirante->id}}" class="btn btn-primary"><span class="glyphicon glyphicon-lock"></span> Vinculación actual</a>
                        <a href="{{$aspirante->id}}/reporte" data-id="{{$aspirante->id}}" class="btn btn-primary"><span class="glyphicon glyphicon-lock"></span>Descargar hoja de vida en formato </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {
        $('.ajax').on('click',function(e){
            e.preventDefault();
            console.log("Consultando...");
            $.post('/admin/candidato/'+$(this).data("method")+'/'+$(this).data("id"), function(response){ 
                console.log(response);
            });
        });
    });
</script>

@stop
