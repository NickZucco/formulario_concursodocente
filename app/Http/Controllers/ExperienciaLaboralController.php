<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Auth;
use DB;

use App\ExperienciaLaboral as ExperienciaLaboral;
use App\TipoVinculacionLaboral as TipoVinculacionLaboral;

class ExperienciaLaboralController extends Controller {
    
    public function show_info($msg = null) {
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
		
        $user_email = Auth::user()->email;

        $experiencias_laboral_info = ExperienciaLaboral::where('aspirantes_id', '=', $aspirante_id)->get();
        $tipos_experiencia_laboral = TipoVinculacionLaboral::all();

        $data = array(
            'aspirante_id' => $aspirante_id,
            'experiencias_laboral' => $experiencias_laboral_info,
            'tipos_vinculacion_laboral'=>$tipos_experiencia_laboral,
            'msg' => $msg,
			'count' => $count
        );
        return view('experiencia_laboral', $data);
    }

    public function insert() {
        $input = Input::all();
        $id = Auth::user()->id;
		
		//Verificamos si la vinculación está en curso para no tener en cuenta la fecha de finalización
		if ($input['en_curso']==1) {
			unset($input['fecha_finalizacion']);
		}
		
		$aleatorio = rand(111111, 999999);
		$titulo = substr($input['nombre_institucion'], 0, 12);
		$titulo = $titulo . $aleatorio;
		$titulo = str_replace(' ', '_', $titulo);
        //Guardamos el archivo de soporte de experiencia laboral si existe
		if (isset($input['adjunto'])){
			$file = Input::file('adjunto');
			//$titulo = str_replace(' ', '_', $input['nombre_institucion']) . '_' . $input['fecha_inicio'];
			$file->move(public_path() . '/file/' . $id . '/experiencia_laboral/' , $titulo . '.pdf');
			
			$input['ruta_adjunto'] = 'file/' . $id . '/experiencia_laboral/' . $titulo . '.pdf';
			unset($input['adjunto']);			
		}
        
		$input['aspirantes_id'] = $id;
        $experiencia_laboral = ExperienciaLaboral::create($input);
        if ($experiencia_laboral->save()) {
            return $this->show_info("Se ingresó exitosamente la información de experiencia laboral.");
        }
    }
    
    public function delete(){
        $input = Input::all();
        $experiencia_laboral=ExperienciaLaboral::find($input["id"]);
		
		if ($experiencia_laboral->ruta_adjunto) {			
			Storage::delete($experiencia_laboral->ruta_adjunto);
		}
        if($experiencia_laboral->delete()){
            return $this->show_info("Se borró la información de la experiencia laboral.");
        }
    }

}
