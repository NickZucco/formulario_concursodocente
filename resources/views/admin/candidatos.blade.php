@extends('unal')

@section('content')
<div class="panel-heading">
    Seleccione uno o varios perfiles para ver los candidatos inscritos.   
</div>
<div class="panel-body">
    <div class="form-group">
        <div class="col-md-8">
            <select id="profile_list" multiple="multiple" class="form-control">
                @foreach($perfiles as $perfil)
                <option value="{{$perfil->id}}">{{$perfil->identificador}}</option>
                @endforeach
            </select>
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
                <th>Documento de identidad</th>
                <th>Nombres y apellidos</th>
                <th>Correo</th>
                <th>Fecha de registro</th>
				<th>Fecha de última actualización</th>
				<th>Hoja de vida</th>
                <th>Adjuntos</th>
            </tr>
        </thead>
        <tbody>
			<tr id="not_selected_profile">
				<td colspan="8"> No se ha seleccionado ningun perfil todavia. Por favor, seleccione al menos un perfil para mostrar la lista de candidatos inscritos.</td>
			</tr>
            @foreach($aspirantes as $aspirante)
            <tr data-id="{{$aspirante->id}}" class="candidate_row">
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
                    {{$aspirante->created_at}}
                </td>
				<td>
                    {{$aspirante->updated_at}}
                </td>
				<td>
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fa fa-clone" aria-hidden="true"></i>
                    </button>
                </td>
                <td>
                    <button type="submit"  class="btn btn-danger btn-sm">
                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                    </button>
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
				$.each(selected_profile_ids, function (index, item) {
					$.each(aspirantes_perfiles, function (spids_index, spids_item) {
						if (spids_item.perfiles_id == item) {
							$("#candidates .candidate_row[data-id='" + spids_item.aspirantes_id + "']").show();
						}
					});
				});
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
