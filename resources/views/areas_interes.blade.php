@extends('main')

@section('form')

<div class="panel panel-default">
    @if($msg)
    <div class="alert alert-success" role="alert">
        {{$msg}}
    </div>
    @endif

    <div class="panel-heading">
        <strong>Áreas de interés</strong>
    </div>
    <form method="post" action="{{ env('APP_URL') }}areas_interes" class="form-horizontal" style="margin:20px 0">     
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="area" class="col-sm-12 col-md-3 control-label">Área del tema propuesto</label>
            <div class="col-sm-12 col-md-9">
                <input type="text" class="form-control" id="area" name="area" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="posible_director" class="col-sm-12 col-md-3 control-label">Posible director</label>
            <div class="col-sm-12 col-md-9">
                <input type="text" class="form-control" id="posible_director" name="posible_director" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="fuente_financiacion" class="col-sm-12 col-md-3 control-label">Fuente de financiación</label>
            <div class="col-sm-12 col-md-9">
                <input type="text" class="form-control" id="fuente_financiacion" name="fuente_financiacion" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="comentarios" class="col-sm-12 col-md-3 control-label">Comentarios</label>
            <div class="col-sm-12 col-md-9">
                <textarea name="comentarios" class="form-control"></textarea>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-success form-control"><i class="glyphicon glyphicon-save-file"></i>Guardar</button>
            </div>
        </div> 
    </form>    

    <div class="panel-heading">
        <strong>Resumen de áreas de interes</strong>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Área</th>
                    <th>Posible director</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            @forelse($areas_interes as $area_interes)
            <tr>
                <td>
                    {{$area_interes->area}}
                </td>
                <td>
                    {{$area_interes->posible_director}}
                </td>
                <td>
                    <form method="post" action="{{ env('APP_URL') }}areas_interes/delete" style="margin:20px 0">     
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$area_interes->id}}"/>
                        <button type="submit" data-id="{{$area_interes->id}}" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No se han ingresado información asociada.</td>
            </tr>
            @endforelse
        </table>
    </div>
</div>
@stop
