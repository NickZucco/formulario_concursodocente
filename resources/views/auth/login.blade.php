@extends('unal')

@section('content')

<div class="row">
    <div class="col-sm-12   col-md-6 col-md-offset-3" style="border-radius: 5px 5px 5px 5px; box-shadow: 3px 3px 10px #888888; padding: 3px; background-color:#E4F5FA">    

        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1"><br> 
            <div class="escudocabecera">
                <img src="{{env('APP_URL')}}images/logosimbolo_central_2c.png" width="40%">
            </div>
            <h3 align="center" class="Estilo12">{{env("APP_NAME")}}</h3>
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (Session::has('status'))
            <div class="alert alert-success">
                {{ Session::get('status') }}
            </div>
            @endif
            @if (Session::has('warning'))
            <div class="alert alert-warning">
                {{ Session::get('warning') }}
            </div>
            @endif

            <form name="login" id="login" method="post" action="{{ env('APP_URL') }}auth/login" class="form-horizontal" style="margin:20px 0">     
                {!! csrf_field() !!}
                <div class="form-group"> 
                    <label for="email" class="control-label col-sm-5">Correo electrónico</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="email" name="email" id="email" class="form-control" placeholder="micorreo@miproveedor.com">    
                    </div>
                </div>

                <div class="form-group"> 
                    <label for="password" class="control-label col-sm-5">Contraseña</label>
                    <div class="col-sm-12 col-md-7">
                        <input class="form-control" type="password" name="password" id="password" placeholder="Clave de ingreso">    
                    </div>
                </div>

                <div class="form-group">
                    <center><a href="{{ env('APP_URL') }}password/email">¿Olvidó su contraseña?</a></center>
                </div>
                <div class="form-group">
                    <center><a href="register"><b>No se ha registrado. Registrese aquí</b></a></center>
                </div>

                <div class="form-group"> 
                    <center><input class="form-control" type="submit" name="envio" value="Ingresar"></center>
                </div>

            </form>

        </div>
    </div>
</div>

@stop