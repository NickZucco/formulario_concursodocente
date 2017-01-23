<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;
use App\Pais as Pais;
use App\Distincion as Distincion;

class DistincionController extends Controller {

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

        $paises = Pais::all();
        $distinciones = Distincion::where('aspirantes_id', '=', $aspirante_id)->get();

        //Si no hay entrada de adjunto válida, se crea una entrada con el id de usuario, por lo tanto, cambiamos el enlace para no mostrar esta información
        foreach ($distinciones as $cur_distincion_key=>$cur_distincion) {
            if (preg_match("/^[0-9]+$/", $cur_distincion["ruta_adjunto"])) {            //La expresión regular para los ids autonuméricos
                $distinciones[$cur_distincion_key]["ruta_adjunto"]=null;
            }
        }

        $data = array(
            'aspirante_id' => $aspirante_id,
            'distinciones' => $distinciones,
            'msg' => $msg,
			'count' => $count
        );
        return view('distincion', $data);
    }

    public function insert() {
        $input = Input::all();
		$id = Auth::user()->id;
        
		$aleatorio = rand(111111, 999999);
		$nombre = substr($input['nombre'], 0, 12);
		$nombre = $nombre . $aleatorio;
		$nombre = str_replace(' ', '_', $nombre);
        //Efectuamos las operaciones sobre el archivo adjunto si existe
		if (isset($input['adjunto'])) {
			$file = Input::file('adjunto');
			//$nombre = str_replace(' ', '_', $input['nombre']) . '_' . $input['fecha_entrega'];
			$file->move(public_path() . '/file/' . $id . '/distinciones_academicas/' , $nombre . '.pdf');
			
			$input['ruta_adjunto'] = 'file/' . $id . '/distinciones_academicas/' . $nombre . '.pdf';
			unset($input['adjunto']);
		}
        
		$input['aspirantes_id'] = $id;
        $distincion = Distincion::create($input);
        if ($distincion->save()) {
            return $this->show_info("Se ingresó la información de la distinción académica");
        }
    }

    public function delete() {
        $input = Input::all();
        $distincion = Distincion::find($input["id"]);
		
		if ($distincion->ruta_adjunto) {			
			Storage::delete($distincion->ruta_adjunto);
		}
        if ($distincion->delete()) {
            return $this->show_info("Se borró la información de la distincion académica.");
        }
    }

}
