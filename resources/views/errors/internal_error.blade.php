@extends('unal')

@section('content')

<div class="row">
    <div class="col-sm-12   col-md-6 col-md-offset-3" style="border-radius: 5px 5px 5px 5px; box-shadow: 3px 3px 10px #888888; padding: 3px; background-color:#E4F5FA">    

        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1"><br> 
            <div class="escudocabecera">
                <img src="{{env('APP_URL')}}images/logosimbolo_central_2c.png" width="40%">
            </div>
            <h4 align="center" class="Estilo12"> 2017-I</h4>

            @if (count($errors) > 0)
            <div class="row">
                <p>Ocurrió un error procesando su solicitud: </p>
            </div>

            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="row">
                <p>En caso de que el error persista, por favor, comuniquelo a la Unidad de TIC de la Facultad de Ingeniería, al correo <a href="mailto:untic_fibog@unal.edu.co">untic_fibog@unal.edu.co</a>, adjuntando una captura de pantalla con este mensaje</p>
            </div>

            <div class="form-group"> 
                <center><input class="form-control" type="submit" name="envio" value="Ingresar"></center>
            </div>



        </div>
    </div>
</div>

@stop