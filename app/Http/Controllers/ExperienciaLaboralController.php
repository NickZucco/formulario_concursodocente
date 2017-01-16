<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Auth;

use App\ExperienciaLaboral as ExperienciaLaboral;
use App\TipoVinculacionLaboral as TipoVinculacionLaboral;

class ExperienciaLaboralController extends Controller {
    
    public function show_info($msg = null) {
        $user_email = Auth::user()->email;
        $aspirante_id = Auth::user()->id;

        $experiencias_laboral_info = ExperienciaLaboral::where('aspirantes_id', '=', $aspirante_id)->get();
        $tipos_experiencia_laboral = TipoVinculacionLaboral::all();

        $data = array(
            'aspirante_id' => $aspirante_id,
            'experiencias_laboral' => $experiencias_laboral_info,
            'tipos_vinculacion_laboral'=>$tipos_experiencia_laboral,
            'msg' => $msg
        );
        return view('experiencia_laboral', $data);
    }

    public function insert() {
        $input = Input::all();
        $id = Auth::user()->id;

        //Guardamos el archivo de soporte de experiencia laboral si existe
		if (isset($input['adjunto'])){
			$file = Input::file('adjunto');
			$titulo = str_replace(' ', '_', $input['nombre_institucion']) . '_' . $input['fecha_inicio'];
			$file->move(public_path() . '\file\\' . $id . '\experiencia_laboral\\' , $titulo . '.pdf');
			
			$input['ruta_adjunto'] = 'file\\' . $id . '\experiencia_laboral\\' . $titulo . '.pdf';
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
