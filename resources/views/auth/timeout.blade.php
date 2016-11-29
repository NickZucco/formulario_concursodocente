@extends('unal')

@section('content')

<div class="row">
    <div class="col-sm-12   col-md-6 col-md-offset-3" style="border-radius: 5px 5px 5px 5px; box-shadow: 3px 3px 10px #888888; padding: 3px; background-color:#E4F5FA">    

        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1"><br> 
            <div class="escudocabecera">
                <img src="{{env('APP_URL')}}images/logosimbolo_central_2c.png" width="40%">
            </div>
            <h4 align="center" class="Estilo12">{{env('APP_NAME')}}</h4>
            <div style='margin:20px;'>
                <p>Estimado aspirante:</p>
                <p>Le informamos que se ha vencido el plazo para acceder al formulario. La fecha limite de diligenciamiento del formulario es: {{$limit_date}}</p>
            </div>
            <div class="form-group"> 
                <center><input class="form-control" type="button" name="envio" onclick="window.history.back();" value="Regresar"></center>
            </div>
        </div>
    </div>
</div>

@stop