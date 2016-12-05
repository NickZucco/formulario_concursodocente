@extends('unal')

@section('content')


<div class="row">
    <div class="col-sm-12   col-md-6 col-md-offset-3" style="border-radius: 5px 5px 5px 5px; box-shadow: 3px 3px 10px #888888; padding: 3px; background-color:#DBF2D8">    

        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1"><br> 
            <div class="escudocabecera"><img src="{{env('APP_URL')}}images/logosimbolo_central_2c.png" width="40%"></div>
            <h4 align="center" class="Estilo12">Registro al formulario de aspirantes - {{env("APP_NAME")}}</h4>

            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form name="registro" id="registro" method="post" action="{{ env('APP_URL') }}auth/register" class="form-horizontal" style="margin:20px 0" onSubmit = "validate()">
                {!! csrf_field() !!}
                <div class="form-group"> 
                    <label for="name" class="control-label col-sm-5">Nombres y apellidos</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control" name="name" id="name" placeholder="nombres apellidos">
                    </div>
                </div>

                <div class="form-group"> 
                    <label for="email" class="control-label col-sm-5">Correo electrónico</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control" name="email" id="email" placeholder="micorreo@miproveedor.com">
                    </div>
                </div>

                <div class="form-group"> 
                    <label for="password" class="control-label col-sm-5">Contraseña</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="password" class="form-control" name="password" id="password" placeholder="********">
                    </div>
                </div>
                <div class="form-group"> 
                    <label for="password_confirmation" class="control-label col-sm-5">Confirmar contraseña</label>
                    <div class="col-sm-12 col-md-7">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="********">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="g-recaptcha-response" class="control-label col-sm-5">CAPTCHA</label>
                    <div class="col-sm-12 col-md-7">
                        {!! Recaptcha::render() !!}
                    </div>
                </div>
				
				<div for="agree" class="form-group">					
                    <center><label align="center" for="name" class="control-label">{{ Form::checkbox('agree', 1, null) }}&nbsp;&nbsp;&nbsp;He leído y acepto los términos y condiciones de la <a href='#'>convocatoria</a>.</label></center>
                </div>    
                
                <div class="form-group">
                    <div class="form-group"> 
                        <p align="center"><b>&nbsp;Si tiene usuario y contraseña, por favor ingrese <a href="login">aquí</a>.</b></p>
                    </div>

                    <div class="form-group"> 
                        <center><input class="form-control" type="submit" name="envio" value="Continuar"></center>
                    </div>
                </div>
            </form>
			
			{{var_dump($errors)}}
			
			<script type=text/javascript>
			function validate(){
				var agreeBox = document.getElementsByName('agree');
				console.log(agreeBox[0]);
				if (!agreeBox[0].checked){
					alert('Debe aceptar los términos y condiciones de la convocatoria para registrarse.');
					return false;
				}
			}
			</script>
			
        </div>
    </div>
</div>

@stop