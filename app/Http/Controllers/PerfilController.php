<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Perfil as Perfil;
use App\ProgramaPregrado as ProgramaPregrado;
use App\PerfilProgramaPregrado as PerfilProgramaPregrado;
use App\AspirantePerfil as AspirantePerfil;

class PerfilController extends Controller {

    public function show_info($msg = null) {
        //Inicializamos la información del formulario
        $msg = "";
        $perfiles_info = Perfil::all();
        $programas_pregrado_info = ProgramaPregrado::all();
        $perfiles_programas_pregrado_info = PerfilProgramaPregrado::all()->toJson();

        $id = Auth::user()->id;
        $perfiles_seleccionados = Perfil::join('aspirantes_perfiles', 'perfiles_id', '=', 'id')
                        ->where('aspirantes_id', '=', $id)->get();


        $data = array(
            "perfiles_info" => $perfiles_info,
            "perfiles_seleccionados" => $perfiles_seleccionados,
            "programas_pregrado_info" => $programas_pregrado_info,
            "perfiles_programas_pregrado_info" => $perfiles_programas_pregrado_info,
            'msg' => $msg
        );
		//dd($data);
        return view('perfiles', $data);
    }

    public function insert() {
        $msg = "";
        $input = Input::all();
        $id = Auth::user()->id;

        //Borramos los anteriores registros
        AspirantePerfil::where("aspirantes_id", "=", $id)->delete();

        //Procesamos la lista de perfiles y preparamos los datos para el insert 
        $insert_data = null;
        $profile_ids = explode(",", $input["selected_profile_ids"]);
        //dd($profile_ids);
        if (!empty($profile_ids) &&
                $profile_ids[0] != "") {//TODO: Revisar porque siempre hay al menos un elemento vacio en el arreglo
            foreach ($profile_ids as $cur_profile_id) {
                $insert_data[] = array("aspirantes_id" => $id, "perfiles_id" => $cur_profile_id);
            }
            AspirantePerfil::insert($insert_data);
            $msg = "Se agregaron exitosamente los perfiles seleccionados.";
        } else {
            $msg = "No se seleccionaron perfiles. Por favor, tenga en cuenta que debe seleccionar al menos un perfil.";
        }

        //Refrescamos la información del formulario
        $perfiles_info = Perfil::all();
        $programas_pregrado_info = ProgramaPregrado::all();
        $perfiles_programas_pregrado_info = PerfilProgramaPregrado::all()->toJson();
        $perfiles_seleccionados = Perfil::join('aspirantes_perfiles', 'perfiles_id', '=', 'id')
                        ->where('aspirantes_id', '=', $id)->get();
        $data = array(
            'msg' => $msg,
            "perfiles_seleccionados" => $perfiles_seleccionados,
            'perfiles_info' => $perfiles_info,
            "programas_pregrado_info" => $programas_pregrado_info,
            "perfiles_programas_pregrado_info" => $perfiles_programas_pregrado_info,
        );


        return view('perfiles', $data);
    }

    public function show_essays($msg = null) {
        //Inicializamos la información del formulario
        $msg = "";

        $id = Auth::user()->id;
        $perfiles_seleccionados = Perfil::join('aspirantes_perfiles', 'perfiles_id', '=', 'id')
                        ->where('aspirantes_id', '=', $id)->get();
		
        $data = array(
            "perfiles_seleccionados" => $perfiles_seleccionados,
            "msg" => $msg
        );

        return view('ensayos', $data);
    }

    public function insertEssays() {
        $input = Input::all();
        $id = Auth::user()->id;
		
		$perfiles_seleccionados = AspirantePerfil::all()->where('aspirantes_id', $id);
        
        //Para cada archivo, actualizamos la entrada correspondiente
        foreach ($perfiles_seleccionados as $perfil) {
			$file = Input::file('adjunto_' . $perfil->perfiles_id);
			$perfil_info = Perfil::find($perfil->perfiles_id);
			
			$titulo = 'ensayo_perfil_' . $perfil_info->identificador;
			$file->move(public_path() . '\file\\' . $id . '\ensayos\\' , $titulo . '.pdf');
			$ruta_adjunto = 'file\\' . $id . '\ensayos\\' . $titulo . '.pdf';
			AspirantePerfil::where("aspirantes_id",$perfil->aspirantes_id)->where("perfiles_id",$perfil->perfiles_id)->update(array('ruta_ensayo' => $ruta_adjunto));
        }
        return $this->show_essays("Se adjuntaron correctamente los archivos cargados");
    }

}
