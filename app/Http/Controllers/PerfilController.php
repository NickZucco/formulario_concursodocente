<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;
use App\Configuracion as Configuracion;
use App\Perfil as Perfil;
use App\ProgramaPregrado as ProgramaPregrado;
use App\PerfilProgramaPregrado as PerfilProgramaPregrado;
use App\AspirantePerfil as AspirantePerfil;

class PerfilController extends Controller {

    public function show_info($msg = null) {
		$configuracion = Configuracion::where('llave', '=', 'limit_date')->first();
		if (strtotime($configuracion['valor']) > time() || Auth::user()->isAdmin()) {
			$aspirante_id = Auth::user()->id;
			//Contamos la cantidad de registros de cada tipo de formulario para visualizarlos en las pestañas
			//de la plantilla (main.blade.php)
			$count = array();
			$count['estudio'] = DB::table('estudios')->where('aspirantes_id', $aspirante_id)->count();
			$count['distincion'] = DB::table('distinciones_academica')->where('aspirantes_id', $aspirante_id)->count();
			$count['laboral'] = DB::table('experiencias_laboral')->where('aspirantes_id', $aspirante_id)->count();
			$count['docente'] = DB::table('experiencias_docente')->where('aspirantes_id', $aspirante_id)->count();
			$count['investigativa'] = DB::table('experiencias_investigativa')->where('aspirantes_id', $aspirante_id)->count();
			$count['produccion'] = DB::table('produccion_intelectual')->where('aspirantes_id', $aspirante_id)->count();
			$count['idioma'] = DB::table('idiomas_certificado')->where('aspirantes_id', $aspirante_id)->count();
			$count['perfiles'] = DB::table('aspirantes_perfiles')->where('aspirantes_id', $aspirante_id)->count();
			$count['ensayos'] = 0;
			
			$ensayos = DB::table('aspirantes_perfiles')->where('aspirantes_id', $aspirante_id)->get();
			foreach($ensayos as $ensayo) {
				if (!$ensayo->ruta_ensayo==null) $count['ensayos'] += 1;
			}
			
			//Inicializamos la información del formulario
			$msg = "";
			$perfiles_info = Perfil::all();
			$programas_pregrado_info = ProgramaPregrado::all();
			$perfiles_programas_pregrado_info = PerfilProgramaPregrado::all()->toJson();

			$perfiles_seleccionados = Perfil::join('aspirantes_perfiles', 'perfiles_id', '=', 'id')
							->where('aspirantes_id', '=', $aspirante_id)->get();


			$data = array(
				"perfiles_info" => $perfiles_info,
				"perfiles_seleccionados" => $perfiles_seleccionados,
				"programas_pregrado_info" => $programas_pregrado_info,
				"perfiles_programas_pregrado_info" => $perfiles_programas_pregrado_info,
				'msg' => $msg,
				'count' => $count
			);
			return view('perfiles', $data);
		}
		else{
			$data = array(
				'limit_date' => $configuracion['valor']
			);
			return view('auth/timeout', $data);
		}
    }

    public function insert() {
        $msg = "";
        $input = Input::all();
        $id = Auth::user()->id;
		
		//Borramos los ensayos anteriores
		$perfiles_seleccionados = DB::table('aspirantes_perfiles')->where('aspirantes_id', $id)->get();
		foreach ($perfiles_seleccionados as $perfil) {
			Storage::delete($perfil->ruta_ensayo);
        }
		
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
		
		return redirect('estudios');
    }

    public function show_essays($msg = null) {
		$configuracion = Configuracion::where('llave', '=', 'limit_date')->first();
		if (strtotime($configuracion['valor']) > time() || Auth::user()->isAdmin()) {
			$aspirante_id = Auth::user()->id;
			//Contamos la cantidad de registros de cada tipo de formulario para visualizarlos en las pestañas
			//de la plantilla (main.blade.php)
			$count = array();
			$count['estudio'] = DB::table('estudios')->where('aspirantes_id', $aspirante_id)->count();
			$count['distincion'] = DB::table('distinciones_academica')->where('aspirantes_id', $aspirante_id)->count();
			$count['laboral'] = DB::table('experiencias_laboral')->where('aspirantes_id', $aspirante_id)->count();
			$count['docente'] = DB::table('experiencias_docente')->where('aspirantes_id', $aspirante_id)->count();
			$count['investigativa'] = DB::table('experiencias_investigativa')->where('aspirantes_id', $aspirante_id)->count();
			$count['produccion'] = DB::table('produccion_intelectual')->where('aspirantes_id', $aspirante_id)->count();
			$count['idioma'] = DB::table('idiomas_certificado')->where('aspirantes_id', $aspirante_id)->count();
			$count['perfiles'] = DB::table('aspirantes_perfiles')->where('aspirantes_id', $aspirante_id)->count();
			$count['ensayos'] = 0;
			
			$ensayos = DB::table('aspirantes_perfiles')->where('aspirantes_id', $aspirante_id)->get();
			foreach($ensayos as $ensayo) {
				if (!$ensayo->ruta_ensayo==null) $count['ensayos'] += 1;
			}
			
			//Inicializamos la información del formulario
			$msg = "";

			$perfiles_seleccionados = Perfil::join('aspirantes_perfiles', 'perfiles_id', '=', 'id')
							->where('aspirantes_id', '=', $aspirante_id)->get();
			
			$data = array(
				"perfiles_seleccionados" => $perfiles_seleccionados,
				"msg" => $msg,
				"count" => $count
			);

			return view('ensayos', $data);
		}
		else{
			$data = array(
				'limit_date' => $configuracion['valor']
			);
			return view('auth/timeout', $data);
		}
    }

    public function insertEssays() {
        $input = Input::all();
        $id = Auth::user()->id;
		
		$perfiles_seleccionados = DB::table('aspirantes_perfiles')->where('aspirantes_id', $id)->get();
        
        //Para cada archivo, actualizamos la entrada correspondiente
        foreach ($perfiles_seleccionados as $perfil) {
			if (isset($input['adjunto_' . $perfil->perfiles_id])) {
				$file = Input::file('adjunto_' . $perfil->perfiles_id);
				$perfil_info = Perfil::find($perfil->perfiles_id);
				
				$titulo = 'ensayo_perfil_' . $perfil_info->identificador;
				$file->move(public_path() . '/file/' . $id . '/ensayos/' , $titulo . '.doc');
				$ruta_adjunto = 'file/' . $id . '/ensayos/' . $titulo . '.doc';
				AspirantePerfil::where("aspirantes_id",$perfil->aspirantes_id)->where("perfiles_id",$perfil->perfiles_id)->update(array('ruta_ensayo' => $ruta_adjunto));
			}
        }
        return $this->show_essays("Se adjuntaron correctamente los archivos cargados");
    }

}
