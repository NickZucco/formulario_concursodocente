<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
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

        //dd($perfiles_seleccionados);

        $data = array(
            "perfiles_seleccionados" => $perfiles_seleccionados,
            "msg" => $msg
        );

        return view('ensayos', $data);
    }

    public function insertEssays() {
        $input = Input::all();
        $aspirantes_id = Auth::user()->id;

        $msg = "";

        //No lo necesitamos mas acá
        unset($input["_token"]);
        //Para cada archivo, actualizamos la entrada correspondiente
        foreach ($input as $key => $cur_value) {
            //En el nombre esta la id de perfil (TODO: Buscar una forma mas segura de tomar este dato)
            $perfiles_id = explode("_", $key);
            $perfiles_id = $perfiles_id[1];

            //Actualizamos el campo ruta_ensayo con el archivo subido
            $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id, "ENSAYO_$perfiles_id" . "_$aspirantes_id", $key, true);
            if (!is_int($ruta_adjunto)) {
                AspirantePerfil::where("aspirantes_id",$aspirantes_id)->where("perfiles_id",$perfiles_id)->update(array('ruta_ensayo' => $ruta_adjunto));
            } else {
                return $this->show_essays("Ocurrió un error agregando el archivo adjunto de documento: Resumen ejecutivo de tesis. Error: " . $ruta_adjunto);
            }
            $input['ruta_resumen_ejecutivo'] = $ruta_adjunto;
            unset($input['adjunto_resumen_ejecutivo']);
        }
        return $this->show_essays("Se adjuntaron correctamente los archivos cargados");
    }

}
