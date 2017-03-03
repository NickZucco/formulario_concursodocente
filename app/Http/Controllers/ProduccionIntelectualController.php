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
use App\Idioma as Idioma;
use App\ProduccionIntelectual as ProduccionIntelectual;
use App\TipoProduccionIntelectual as TipoProduccionIntelectual;

class ProduccionIntelectualController extends Controller {
    
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
			
			$user_email = Auth::user()->email;

			$producciones_intelectual = ProduccionIntelectual::where('aspirantes_id', '=', $aspirante_id)->get();
			
			$paises = Pais::orderBy('nombre')->get();
			$idiomas = Idioma::all()->keyBy('id');
			$tipos_produccion_intelectual = TipoProduccionIntelectual::all()->keyBy('id');

			$data = array(
				'aspirantes_id' => $aspirante_id,
				'paises'=>$paises,
				'idiomas'=>$idiomas,
				'tipos_produccion_intelectual' => $tipos_produccion_intelectual,
				'producciones_intelectual' => $producciones_intelectual,
				'msg' => $msg,
				'count' => $count
			);
			return view('produccion_intelectual', $data);
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
        
        //Efectuamos las operaciones sobre el archivo
		$aleatorio = rand(111111, 999999);
		$titulo = substr($input['nombre'], 0, 12);
		$titulo = $titulo . $aleatorio;
		$titulo = str_replace(' ', '_', $titulo);
		$file = Input::file('adjunto');
		switch($input['tipos_produccion_intelectual_id']){
			case 1:
				if ($input['volumen']=='') {
					unset($input['volumen']);
				}
				if ($input['clasificacion_revista']=='') {
					unset($input['clasificacion_revista']);
				}
				$titulo = 'Revista_' . $titulo;
				break;
			case 2:
				if ($input['isbn']=='') {
					unset($input['isbn']);
				}
				$titulo = 'Libro_' . $titulo;
				break;
			case 3:
				if ($input['isbn']=='') {
					unset($input['isbn']);
				}
				$titulo = 'Capitulo_' . $titulo;			
				break;
			case 4:
				$titulo = 'Patente_' . $titulo;
				break;
		}
		//dd($input);
		$file->move(public_path() . '/file/' . $id . '/produccion_intelectual/' , $titulo . '.pdf');	
		$input['ruta_adjunto'] = 'file/' . $id . '/produccion_intelectual/' . $titulo . '.pdf';
		unset($input['adjunto']);
		
		$input['aspirantes_id'] = $id;
        $produccion_intelectual = ProduccionIntelectual::create($input);
        if ($produccion_intelectual->save()) {
            return $this->show_info("Se ingresó la información de la producción intelectual.");
        }
    }

    public function delete() {
        $input = Input::all();
        $produccion_intelectual = ProduccionIntelectual::find($input["id"]);
		
		if ($produccion_intelectual->ruta_adjunto) {		
			Storage::delete($produccion_intelectual->ruta_adjunto);
		}
        if ($produccion_intelectual->delete()) {
            return $this->show_info("Se borró la información de la  producción intelectual.");
        }
    }
}
