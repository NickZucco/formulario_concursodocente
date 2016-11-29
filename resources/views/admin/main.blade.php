@extends('unal')

@section('content')

<div class="row">
    <p>Bienvenido/a {{Auth::user()->name}}
     <br>
</div>

<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<a class="navbar-brand" href="#">Menú Principal</a>-->
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{ env('APP_URL') }}datos" data-path="datos">Datos personales</a></li>
                
                <li><a href="{{ env('APP_URL') }}auth/logout"><i class="glyphicon glyphicon-log-out"></i>&nbsp;Cerrar sesión</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="col-sm-12 col-md-12" style="border-radius: 5px 5px 5px 5px; box-shadow: 3px 3px 10px #888888; padding: 3px; background-color:#E4F5FA">   
    @yield('form')
</div>


@stop
