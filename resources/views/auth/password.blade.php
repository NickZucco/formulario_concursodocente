@extends('unal')

@section('content')
<div class="row">
    <div class="col-sm-12   col-md-6 col-md-offset-3" style="border-radius: 5px 5px 5px 5px; box-shadow: 3px 3px 10px #888888; padding: 3px; background-color:#E4F5FA">    

        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1"><br> 
            <div class="escudocabecera"><img src="{{env('APP_URL')}}images/logosimbolo_central_2c.png" width="40%"></div>
            <h4 align="center" class="Estilo12">Reestablecimiento de contraseña - {{env("APP_NAME")}}</h4>
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @elseif(isset($msg))
            <div class="alert alert-success">
                <ul>
                    <li>{{$msg}}</li>
                </ul>
            </div>
            @endif

            <form name="registro" id="registro" method="post" action="{{ env('APP_URL') }}password/email" class="form-horizontal" style="margin:20px 0">     
                {!! csrf_field() !!}
                <div class="form-group"> 
                    <label for="email" class="control-label col-sm-5">Correo electrónico</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="email" name="email" id="email" class="form-control" placeholder="micorreo@miproveedor.com" value="{{ old('email') }}">    
                    </div>
                </div>
                <div class="form-group">
                    <center><a href="{{ env('APP_URL') }}auth/register"><b>¿No se ha registrado?. Registrese aquí</b></a></center>
                </div>
				<div class="form-group"> 
                    <p align="center"><b>&nbsp;Si tiene usuario y contraseña, por favor ingrese <a href="{{ env('APP_URL') }}auth/login">aquí</a>.</b></p>
                </div>
                <div class="form-group"> 
                    <center><input class="form-control"  type="submit" name="envio" value="Reiniciar contraseña"></center>
                </div>
            </form>          
        </div>
    </div>
</div>

@stop

