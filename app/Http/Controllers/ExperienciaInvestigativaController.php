<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Auth;
use DB;
use App\Configuracion as Configuracion;
use App\Pais as Pais;
use App\ExperienciaInvestigativa as ExperienciaInvestigativa;

class ExperienciaInvestigativaController extends Controller {
    
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
			
			//Contamos cuantos ensayos han sido subidos
			$ensayos = DB::table('aspirantes_perfiles')->where('aspirantes_id', $aspirante_id)->get();
			foreach($ensayos as $ensayo) {
				if (!$ensayo->ruta_ensayo==null) $count['ensayos'] += 1;
			}
			
			$user_email = Auth::user()->email;

			$experiencia_investigativa = ExperienciaInvestigativa::where('aspirantes_id', '=', $aspirante_id)->get();
			$paises = Pais::orderBy('nombre')->get();

			$data = array(
				'aspirante_id' => $aspirante_id,
				'experiencias_investigativa' => $experiencia_investigativa,
				'paises' => $paises,
				'msg' => $msg,
				'count' => $count
			);
			return view('experiencia_investigativa', $data);
		}
		else{
			$data = array(
				'limit_date' => $configuracion['valor']
			);
			return view('auth/timeout', $data);
		}
    }

    public function insert() {
        $input = Input::all();
        $id = Auth::user()->id;

		//Verificamos si el programa está en curso para no tener en cuenta la fecha de finalización
		if ($input['en_curso']==1) {
			unset($input['fecha_finalizacion']);
		}
        
		$aleatorio = rand(111111, 999999);
		$titulo = substr($input['nombre_proyecto'], 0, 12);
		$titulo = $titulo . $aleatorio;
		$titulo = str_replace(' ', '_', $titulo);
        //Guardamos el archivo de soporte adjunto si existe
		if (isset($input['adjunto'])) {
			$file = Input::file('adjunto');
			//$titulo = str_replace(' ', '_', $input['nombre_proyecto']);
			$file->move(public_path() . '/file/' . $id . '/experiencia_investigativa/' , $titulo . '.pdf');
			
			$input['ruta_adjunto'] = 'file/' . $id . '/experiencia_investigativa/' . $titulo . '.pdf';
			unset($input['adjunto']);		
		}
		
		$input['aspirantes_id'] = $id;
        $experiencia_investigativa = ExperienciaInvestigativa::create($input);
        if ($experiencia_investigativa->save()) {
            return $this->show_info("Se ingresó exitosamente la información de experiencia investigativa.");
        }
    }
    
    public function delete() {
        $input = Input::all();
        $experiencia_investigativa = ExperienciaInvestigativa::find($input["id"]);
		
		if ($experiencia_investigativa->ruta_adjunto) {			
			Storage::delete($experiencia_investigativa->ruta_adjunto);
		}
        if ($experiencia_investigativa->delete()) {
            return $this->show_info("Se borró la información de la experiencia investigativa.");
        }else{
            return $this->show_info();
        }
    }

}
