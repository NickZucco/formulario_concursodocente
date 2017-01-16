<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Auth;
use App\ExperienciaDocente as ExperienciaDocente;
use App\Pais as Pais;
use App\ExperienciaInvestigativa as ExperienciaInvestigativa;

class ExperienciaInvestigativaController extends Controller {
    
    public function show_info($msg = null) {
        $user_email = Auth::user()->email;
        $aspirante_id = Auth::user()->id;

        $experiencia_investigativa = ExperienciaInvestigativa::where('aspirantes_id', '=', $aspirante_id)->get();
        $paises = Pais::orderBy('nombre')->get();

        $data = array(
            'aspirante_id' => $aspirante_id,
            'experiencias_investigativa' => $experiencia_investigativa,
            'paises' => $paises,
            'msg' => $msg
        );
        return view('experiencia_investigativa', $data);
    }

    public function insert() {
        $input = Input::all();
        $id = Auth::user()->id;

		//Verificamos si el programa está en curso para no tener en cuenta la fecha de finalización
		if ($input['en_curso']==1) {
			unset($input['fecha_finalizacion']);
		}
        
        //Guardamos el archivo de soporte adjunto si existe
		if (isset($input['adjunto'])) {
			$file = Input::file('adjunto');
			$titulo = str_replace(' ', '_', $input['nombre_proyecto']);
			$file->move(public_path() . '\file\\' . $id . '\experiencia_investigativa\\' , $titulo . '.pdf');
			
			$input['ruta_adjunto'] = 'file\\' . $id . '\experiencia_investigativa\\' . $titulo . '.pdf';
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
