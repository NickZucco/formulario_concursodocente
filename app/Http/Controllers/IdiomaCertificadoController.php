<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Configuracion as Configuracion;
use App\Idioma as Idioma;
use App\IdiomaCertificado as IdiomaCertificado;
use Auth;

class IdiomaCertificadoController extends Controller
{
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

			$idiomas = Idioma::all()->keyBy('id');
			$idiomas_certificados=IdiomaCertificado::where('aspirantes_id','=',$aspirante_id)->get()->keyBy('id');
		   
			$data = array(
				'aspirante_id' => $aspirante_id,
				'idiomas'=>$idiomas,
				'idiomas_certificados'=>$idiomas_certificados,
				'msg' => $msg,
				'count' => $count
			);
			return view('idiomas', $data);
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
		
		$idioma = Idioma::find($input['idiomas_id']);
		
		//Verificamos si es idioma nativo del candidato
		if ($input['nativo']==1) {
			unset($input['nombre_certificado']);
			unset($input['puntaje']);
		}
        
		$aleatorio = rand(111111, 999999);
		$titulo = $idioma->nombre . $aleatorio;
        //Guardamos el archivo de soporte de experiencia laboral si existe
		if (isset($input['adjunto'])){
			$file = Input::file('adjunto');
			//$titulo = str_replace(' ', '_', $input['nombre_certificado']) . '_' . str_replace(' ', '_', $input['puntaje']);
			$file->move(public_path() . '/file/' . $id . '/idiomas/' , $titulo . '.pdf');
			
			$input['ruta_adjunto'] = 'file/' . $id . '/idiomas/' . $titulo . '.pdf';
			unset($input['adjunto']);			
		}

		$input['aspirantes_id'] = $id;
        $idiomas_certificado = IdiomaCertificado::create($input);
        if ($idiomas_certificado->save()) {
            return $this->show_info("Se ingresó la información de idioma.");
        }
    }
    
    public function delete(){
        $input = Input::all();
        $idiomas_certificado=IdiomaCertificado::find($input["id"]);
		
		if ($idiomas_certificado->ruta_adjunto) {			
			Storage::delete($idiomas_certificado->ruta_adjunto);
		}
        if($idiomas_certificado->delete()){
            return $this->show_info("Se borró la información de idioma.");
        }
    }
}
