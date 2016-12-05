@extends('unal')

@section('content')
<div class="row">
    <div class="col-sm-12   col-md-6 col-md-offset-3" style="border-radius: 5px 5px 5px 5px; box-shadow: 3px 3px 10px #888888; padding: 3px; background-color:#DBF2D8">    

        <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1"><br> 
            <div class="escudocabecera"><img src="{{env('APP_URL')}}images/logosimbolo_central_2c.png" width="40%"></div>
            <h4 align="center" class="Estilo12">Formulario de actualización de contraseña - {{env("APP_NAME")}}</h4>
            <form method="POST" action="{{env("APP_URL")}}password/reset" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">

                @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                <br>
                <div class="form-group">
                    <label for="email" class="control-label col-sm-5">Correo electrónico</label>
                    <div class="col-md-7">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="control-label col-sm-5">Contraseña</label>
                    <div class="col-md-7">
                        <input type="password" name="password" value="{{ old('email') }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="control-label col-sm-5">Confirmar contraseña</label>
                    <div class="col-md-7">
                        <input type="password" name="password_confirmation" value="{{ old('email') }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit"  class="form-control">
                        Reiniciar contraseña
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@stop