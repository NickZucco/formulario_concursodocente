@extends('unal')

@section('content')

 @if (Session::has('status'))
<div class="alert alert-success">
    {{ Session::get('status') }}
</div>
@endif

<div class="row">
    <p>Bienvenido/a {{Auth::user()->name}}
    <br>
    <div style="display:inline-block;float:right">
        El formulario se cerrará en&nbsp;<span id="countdown" style="float:right"> </span>
    </div>
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
                <li><a href="{{ env('APP_URL') }}datos" data-path="datos"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;Datos personales</a></li>
                @if(App\Aspirante::where('correo', '=', Auth::user()->email)->first())
                
                <li><a href="{{ env('APP_URL') }}perfiles" data-path="perfiles"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;Perfiles</a></li>
                
                @if(App\Perfil::join('aspirantes_perfiles', 'perfiles_id', '=', 'id')->where('aspirantes_id', '=', Auth::user()->id)->first())
					<li><a href="{{ env('APP_URL') }}estudios" data-path="estudios"><i class="fa fa-graduation-cap" aria-hidden="true"></i>&nbsp;Estudios universitarios</a></li>
					<li><a href="{{ env('APP_URL') }}distinciones" data-path="distinciones"><i class="fa fa-trophy" aria-hidden="true"></i>&nbsp;Distinciones académicas</a></li>
					<li><a href="{{ env('APP_URL') }}experiencia_laboral" data-path="experiencia_laboral"><i class="fa fa-list-ul" aria-hidden="true"></i>&nbsp;Experiencia laboral</a></li>
					<li><a href="{{ env('APP_URL') }}experiencia_docente" data-path="experiencia_docente"><i class="fa fa-list-ul" aria-hidden="true"></i>&nbsp;Experiencia docente</a></li>
					<li><a href="{{ env('APP_URL') }}experiencia_investigativa" data-path="experiencia_investigativa"><i class="fa fa-list-ul" aria-hidden="true"></i>&nbsp;Experiencia investigativa</a></li>
					<li><a href="{{ env('APP_URL') }}produccion_intelectual" data-path="produccion_intelectual"><i class="fa fa-lightbulb-o" aria-hidden="true"></i>&nbsp;Producción intelectual</a></li>
					<li><a href="{{ env('APP_URL') }}idiomas" data-path="idiomas"><i class="fa fa-language" aria-hidden="true"></i>&nbsp;Idiomas</a></li>
					<li><a href="{{ env('APP_URL') }}perfiles/ensayos" data-path="perfiles/ensayos"><i class="fa fa-book" aria-hidden="true"></i>&nbsp;Ensayos</a></li>
                @else
					<li><a href="#" disabled>
                    <i class="hidden-xs hidden-sm fa fa-arrow-left" aria-hidden="true"></i>
                     Debe seleccionar y guardar al menos un <i class="fa fa-user" style="color:#95d072" aria-hidden="true"></i> perfil al cual aspirar antes de poder diligenciar los demas campos.</a></li>
                @endif
                
                @else
                <li><a href="#" disabled>Las demas opciones se habilitarán una vez seleccione la información del perfil y sus datos personales.</a></li>
                @endif
                <li><a href="{{ env('APP_URL') }}auth/logout"><i class="glyphicon glyphicon-log-out"></i>&nbsp;Cerrar sesión</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="col-sm-12 col-md-12" style="border-radius: 5px 5px 5px 5px; box-shadow: 3px 3px 10px #888888; padding: 3px; background-color:#E4F5FA">   
    @yield('form')
</div>

<script>
    
    
    (function ($) {
        /**/
        var today=new Date();
        var limit_date = new Date('{{App\Configuracion::where('llave', '=', 'limit_date')->first()["valor"]}}');
        var time_remaining = (limit_date.getTime()-today.getTime())/1000;              //En segundos
        var $display = $('#countdown');
        
        function startTimer(display) {
            var days,minutes, seconds;
            setInterval(function () {
                days=parseInt(time_remaining/(3600*24),10);
                hours=parseInt((time_remaining-(days*3600*24))/3600,10);
                minutes=parseInt((time_remaining-(days*3600*24)-(hours*3600))/60,10);
                seconds=parseInt(time_remaining%60,10);

                display.text(" "+days+" dias ,"+hours+" horas, "+minutes + " minutos y " + seconds+" segundos");

                time_remaining-=1;
                
            }, 1000);
        }
        startTimer($display);
        /**/
        $('.datepicker').each(function () {
            var str = $(this).val();
            if (!str || str === "0000-00-00" || 0 === str.length || /^\s*$/.test(str)) {
                $(this).val('<?php echo date("Y-m-d"); ?>');
            }
        });

        $('a[data-path="{{Request::path()}}"]').parent().addClass('active');

        var now = new Date();
        var default_end = now;
        default_end.setHours(23);
        default_end.setMinutes(59);
		
		$('.datepicker2').datetimepicker({
            defaultDate: now,
            format: 'YYYY-MM-DD',
            locale: 'es',
            maxDate: now
        });
        $('.datepicker').datetimepicker({
            defaultDate: now,
            format: 'YYYY-MM-DD',
            locale: 'es',
			minDate: '2006-01-01',
            maxDate: now
        });
        $('.start').datetimepicker({
            defaultDate: new Date(),
            format: 'YYYY-MM-DD',
            locale: 'es',
            maxDate: now
        });
        $('.end').datetimepicker({
            defaultDate: default_end,
            format: 'YYYY-MM-DD',
            locale: 'es',
            maxDate: now
        });
        $(".maxToday").datetimepicker({
            defaultDate: default_end,
            format: 'YYYY-MM-DD',
            locale: 'es',
            maxDate: now
        });
        $(".start").on("dp.change", function (e) {
            $('.end').data("DateTimePicker").minDate(e.date);
        });
        $(".end").on("dp.change", function (e) {
            $('.start').data("DateTimePicker").maxDate(e.date);
        });
        
        /**/
        $("input[required],select[required],textaarea[required]").css("border-left","4px solid red");
        var list = document.querySelectorAll('input,select,textarea');
               var config = { attributes: true, childList: true, characterData: true }
               console.log(list);
                
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        $target=$(mutation.target);
                        console.log($target.attr("required"));
                        if(mutation.attributeName=='required'){
                            if($target.attr("required")=='required'){
                                $(mutation.target).parent().css("border-left","4px solid red");
                            }else{
                                $(mutation.target).parent().css("border-left","");
                            }   
                        }
                    });
                });
                
                for(var cur_key in list){
                    if(list[cur_key] instanceof Node){
                        observer.observe(list[cur_key], config);
                    }else{
                        console.log("No se escucha a "+list[cur_key]);
                    }
                }
        /**/
       
    })(jQuery);

</script>
@stop
