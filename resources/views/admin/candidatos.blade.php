@extends('unal')

@section('content')
<div class="panel-heading">
    <strong>Resumen de aspirantes registrados</strong>
</div>
<div class="panel-body">
    <table class="datatable table table-striped">
        <thead>
            <tr>
                <th>Documento de identidad</th>
                <th>Nombres y apellidos</th>
                <th>Correo</th>
                <th>Fecha de registro</th>
                <th>Fecha de última actualización</th>
                <th>Mostrar información</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aspirantes as $aspirante)
            <tr>
                <td>
                    {{$aspirante->documento}}
                </td>
                <td>
                    {{$aspirante->nombre}} {{$aspirante->apellido}}
                </td>
                <td>
                    {{$aspirante->correo}}
                </td>
                <td>
                    {{$aspirante->updated_at}}
                </td>
                <td>
                    {{$aspirante->created_at}}
                </td>
                <td>
                    <a href="/admin/candidato/{{$aspirante->id}}" type="button" class="btn">
                        Ver detalles
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No se han encontrado datos de aspirantes</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
<div class='row'>
    <div class='col-sm-12 col-md-4 col-md-offset-4'>

    </div>
</div>

@stop
