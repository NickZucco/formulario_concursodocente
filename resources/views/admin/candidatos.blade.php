@extends('unal')

@section('content')
<div class="panel-heading">
    <p>Bienvenido {{Auth::user()->name}}</p>
    <p>Seleccione uno o varios perfiles para ver los candidatos inscritos.   </p>
</div>

<div class="panel-body">
    <div class="form-group">
        <div class="col-md-3">
            <select id="profile_list" multiple="multiple" class="form-control">
                <option value="0">Todos los perfiles</option>
                @foreach($perfiles as $perfil)
                <option value="{{$perfil->id}}">{{$perfil->identificador}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <form method="get" action="{{ env('APP_URL') }}admin/candidatos/excel">     
                {!! csrf_field() !!}
                <button type="submit" class="btn btn-info">
                    Exportar a Excel
                </button>
                
            </form>
        </div>
		<div class="col-md-3">
            <form method="get" action="{{ env('APP_URL') }}auth/logout">     
                {!! csrf_field() !!}
                <button type="submit" class="btn btn-danger">
                    Cerrar sesión
                </button>
                
            </form>
        </div>
    </div>
</div>

<div class="panel-heading">
    <strong>Resumen de aspirantes registrados</strong>
</div>
<div class="panel-body">
    <table id="candidates" class="datatable table table-striped">
        <thead>
            <tr>
				<th style="text-align: center">Número</th>
                <th style="text-align: center">Documento de identidad</th>
                <th style="text-align: center">Nombres y apellidos</th>
                <th style="text-align: center">Correo</th>
                <th style="text-align: center">Fecha de registro</th>
                <th style="text-align: center">Fecha de última actualización</th>
                <th style="text-align: center">Hoja de vida</th>
                <th style="text-align: center">Adjuntos</th>
            </tr>
        </thead>
        <tbody>
            <tr id="not_selected_profile">
                <td colspan="8"> No se ha seleccionado ningun perfil todavia. Por favor, seleccione al menos un perfil para mostrar la lista de candidatos inscritos.</td>
            </tr>
			<?php $numero_candidatos = 1; ?>
            @foreach($aspirantes as $aspirante)
            <tr data-id="{{$aspirante->id}}" class="candidate_row">
				<td style="text-align: center">
                    <strong>{{$numero_candidatos}}</strong>
					<?php $numero_candidatos++; ?>
                </td>
                <td style="text-align: center"> 
                    {{$aspirante->documento}}
                </td>
                <td style="text-align: center">
                    {{$aspirante->nombre}} {{$aspirante->apellido}}
                </td>
                <td style="text-align: center">
                    {{$aspirante->correo}}
                </td>
                <td style="text-align: center">
                    {{$aspirante->created_at}}
                </td>
                <td style="text-align: center">
                    {{$aspirante->updated_at}}
                </td>
                <td style="text-align: center">
                    <form method="get" action="{{ env('APP_URL') }}admin/candidatos/reporte" style="margin:20px 0">     
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$aspirante->id}}"/>
                        <button type="submit" data-id="{{$aspirante->id}}" class="btn btn-danger btn-sm">
                            <i class="fa fa-clone" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
                <td style="text-align: center">
                    <form method="get" action="{{ env('APP_URL') }}admin/candidatos/adjuntos" style="margin:20px 0">     
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$aspirante->id}}"/>
                        <button type="submit" data-id="{{$aspirante->id}}" class="btn btn-danger btn-sm">
                            <i class="fa fa-folder-open" aria-hidden="true"></i>
                        </button>
                    </form> 
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

<script type="text/javascript">
    (function ($) {
		var aspirantes_perfiles = {!!$aspirantes_perfiles!!};
        var selected_profile_ids = [];

        $("#candidates .candidate_row").hide();

        function updateCandidates(index, checked) {
			$("#not_selected_profile").hide();
            $("#candidates .candidate_row").hide();
						
			if (!checked) {
				var itr = selected_profile_ids.indexOf(index);
				if (index > -1) {
					selected_profile_ids.splice(itr, 1);
				}
			}
			else {
				selected_profile_ids.push(index);
			}
			
			if(selected_profile_ids.length<=0){
				$("#not_selected_profile").show();
			}
			else {
				if ($.inArray('0', selected_profile_ids) != -1) {
					$("#candidates .candidate_row").show();
				}
				else {
					$.each(selected_profile_ids, function (index, item) {
						$.each(aspirantes_perfiles, function (spids_index, spids_item) {
							if (spids_item.perfiles_id == item) {
								$("#candidates .candidate_row[data-id='" + spids_item.aspirantes_id + "']").show();
							}
						});
					});
				}
			}          
        }
		
        $('#profile_list').multiselect({			
            nSelectedText: 'seleccionados',
            nonSelectedText: 'No hay elementos seleccionados',
            numberDisplayed: 10,
            onChange: function (option, checked, select) {
                updateCandidates($(option).val(), checked);
            }
        });
        
    })(jQuery);

</script>

@stop
