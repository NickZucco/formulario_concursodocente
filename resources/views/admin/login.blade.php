@extends('unal')

@section('content')

<div class="row">
    <div class="col-sm-12   col-md-6 col-md-offset-3" style="border-radius: 5px 5px 5px 5px; box-shadow: 3px 3px 10px #888888; padding: 3px; background-color:#E4F5FA">    

        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1"><br> 
            <div class="escudocabecera">
                <img src="{{env('APP_URL')}}images/logosimbolo_central_2c.png" width="40%">
            </div>
            <h4 align="center" class="Estilo12">Ingreso a la interfaz de consulta</h4>

            @if($msg)
            <div class="alert alert-danger" role="alert">
                {{$msg}}
            </div>
            @endif

            <form name="login" id="login" method="post" action="{{ env('APP_URL') }}admin/login" class="form-horizontal" style="margin:20px 0">     
                {!! csrf_field() !!}
                <div class="form-group"> 
                    <label for="usernames" class="control-label col-sm-5">Usuario de correo electrónico institucional ('sin @unal.edu.co')</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="text" name="username" id="username" class="form-control" placeholder="micorreo">    
                    </div>
                </div>

                <div class="form-group"> 
                    <label for="password" class="control-label col-sm-5">Contraseña</label>
                    <div class="col-sm-12 col-md-7">
                        <input class="form-control" type="password" name="password" id="password" placeholder="Clave de ingreso">    
                    </div>
                </div>

                <div class="form-group"> 
                    <center><input class="form-control" type="submit" name="envio" value="Ingresar"></center>
                </div>
            </form>

        </div>
    </div>
</div>

@stop