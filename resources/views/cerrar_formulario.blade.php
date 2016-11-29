@extends('main')

@section('form')

<div class="panel panel-default">
    @if($msg)
    <div class="alert alert-success" role="alert">
        {{$msg}}
    </div>
    @endif
    <div class="panel-heading">
        <strong>Cierre del formulario</strong>
    </div>

    <form name="registro" id="registro" method="post" action="{{ env('APP_URL') }}perfiles/ensayos" class="form-horizontal" style="margin:20px 0"  enctype="multipart/form-data">     
        {!! csrf_field() !!}
        <div class="panel-body">
            Por implementar
            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-success form-control">
                        <i class="fa fa-book" aria-hidden="true"></i>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Adicionar ensayos
                    </button>
                </div>
            </div> 
        </div>
    </form>
    
</div>
@stop

