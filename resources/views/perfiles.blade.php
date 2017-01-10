@extends('main')

@section('form')

@if($msg)
<div class="alert alert-success" role="alert">
    {{$msg}}
</div>
@endif

<div class="panel panel-default">
    <div class="panel-heading">
        Información de programas académicos a los cuales puede acceder cada perfil    
    </div>
    <div class="panel-body">

        <div class="form-group">
            <label for="nombre_plan" class="col-md-2 control-label">Títulos de pregrado obtenidos</label>
            <div class="col-md-8">
                <select id="plan_list" multiple="multiple" class="form-control">
                    @foreach($programas_pregrado_info as $programa_pregrado)
                    <option value="{{$programa_pregrado->id}}">{{$programa_pregrado->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <!--<button id="clean_plan_list" class="btn btn-warning"><span class="glyphicon glyphicon-trash"></span> Limpiar seleccion</button>-->
        </div>

    </div>
    <div class="panel-heading">
        Información de programas académicos a los cuales puede acceder cada perfil    
    </div>
    <form method="post" action="{{ env('APP_URL') }}perfiles" class="form-horizontal" style="margin:20px 0">
        <div class="panel-body">
            <p>
                A continuación, se monstrarán habilitados los títulos de pregrado requeridos para cadaa perfil seleccionado. Tenga en cuenta que, dependiendo de los títulos de pregrado seleccionados se habilitarán los perfiles del concurso a los cuales puede aplicar.
            </p>

            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="panel-heading">
                        <h4>Lista completa de perfiles disponibles</h4>
                    </div>
                    <div class="panel-body">
                        <table id="profiles" class="table table-striped table-hover"> 
                            <thead>
                                <tr>
                                    <th width="10%">Identificador</th>
                                    <th width="15%" class="hidden-xs hidden-sm">Dedicación</th>
                                    <th width="12%" class="hidden-xs hidden-sm">Cargos</th>
                                    <th width="12%" class="hidden-xs hidden-sm">Área de desempeño</th>
                                    <th width="12%" class="hidden-xs hidden-sm">Requisitos mínimos de posgrado</th>
                                    <th width="12%" class="hidden-xs hidden-sm">Requisitos mínimos de experiencia</th>
                                    <th width="12%" class="hidden-xs hidden-sm">Departamento</th>
                                    <th width="15%">¿Seleccionar?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="not_selected_plan">
                                    <td colspan="8"> No se ha seleccionado ningun programa de pregrado todavia. Por favor, seleccione al menos un programa para mostrar la lista de perfiles asociados a dicho programa.</td>
                                </tr>
                                @foreach($perfiles_info as $perfil)
                                <tr data-id="{{$perfil->id}}" class="profile_row">
                                    <td>{{$perfil->identificador}}</td>
                                    <td class="hidden-xs hidden-sm">{{$perfil->dedicacion}}</td>
                                    <td class="hidden-xs hidden-sm">{{$perfil->cargos}}</td>
                                    <td class="hidden-xs hidden-sm">{{$perfil->area_desempeno}}</td>
                                    <td class="hidden-xs hidden-sm">{{$perfil->requisitos_posgrado}}</td>
                                    <td class="hidden-xs hidden-sm">{{$perfil->requisitos_experiencia}}</td>
                                    <td class="hidden-xs hidden-sm">{{$perfil->departamento}}</td>
                                    <td>
                                        <input id="profile-{{$perfil->id}}" data-id="{{$perfil->id}}" class="profile" name="profile" type="checkbox" value="{{$perfil->id}}" class="checkbox">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class="col-sm-12 col-md-12">
                    <div>
                        <div class="panel-heading">
                            <h4>Lista de perfiles guardados previamente</h4>
                        </div>
                        <div>
                            <ul>
                                @forelse($perfiles_seleccionados as $perfil)
                                <li>{{$perfil->identificador}} - {{$perfil->area_desempeno}}</li>
                                @empty
                                <div class="alert alert-warning" role="alert">
                                    No se encontraron perfiles seleccionados. Por favor, seleccione primero a que perfiles desea aplicar de la tabla <b>Lista completa de perfiles disponibles</b> y de clic en el botón <a href="#" data-path="perfiles" class="alert-link"><i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i>&nbsp;Guardar perfiles seleccionados</a> .
                                </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-success form-control">
                    <i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i>&nbsp;Guardar perfiles seleccionados
                </button>
            </div>
        </div>
        <input id="selected_profile_ids" name="selected_profile_ids" type="hidden" value="">
        {!! csrf_field() !!}

    </form>
</div>


<script type="text/javascript">
    (function ($) {
        var selectable_profiles_ids = {!!$perfiles_programas_pregrado_info!!};		
        var selected_plan_ids = [];
        var selected_profile_ids = [];

        $("#profiles .profile_row").hide();

        function updateSelectableProfiles(index, isAppend) {
            $("#not_selected_plan").hide();
            $("#profiles .profile_row").hide();
            $(".profile:checked").removeAttr("checked");

            var checkEngineer = false;
            if (!isAppend) {				
                var itr = selected_plan_ids.indexOf(index);				
                if (index > -1) {
                    selected_plan_ids.splice(itr, 1);
                }
            } else {
                if (index === "engineer") {
                    checkEngineer = true;
                } else {
                    selected_plan_ids.push(index);
                }
            }
            
            if(selected_plan_ids.length<=0){
                $("#not_selected_plan").show();
            }
			else {                
				$.each(selected_plan_ids, function (index, item) {
					$.each(selectable_profiles_ids, function (spids_index, spids_item) {						
						if (spids_item.programas_pregrado_id == item) {
							$("#profiles .profile_row[data-id='" + spids_item.perfiles_id + "']").show();
						}
					});
				});
            }
            
        }
		
        $('#plan_list').multiselect({
            nSelectedText: 'seleccionados',
            nonSelectedText: 'No hay elementos seleccionados',
            numberDisplayed: 5,
            onChange: function (option, checked, select) {
                /*
                if (!updateSelectableProfiles($(option).val(), checked)) {
                    option.removeAttr("selected");
                }
                */
				updateSelectableProfiles($(option).val(), checked);
            }
        });
		
        $(".profile").on("change", function (e) {
            selected_profile_ids = [];

            if ($(".profile:checked").length > 3) {
                alert("No se permite seleccionar mas de tres perfiles. \n\nPor favor, verifíque los perfiles a los cuales desea aspirar.");
                $(this).removeAttr("checked");
            } else {
                $(".profile:checked").each(function (i, e) {
                    selected_profile_ids.push($(this).data("id"));
                });
                $("#selected_profile_ids").val(selected_profile_ids.join(","));
            }
        });

        $("#clean_plan_list").on("click", function (e) {
            e.preventDefault();
            $("#profiles option:selected").removeAttr("selected");
            selected_plan_ids = [];
            $("#profiles .profile_row").hide();
        });
    })(jQuery);

</script>

@stop