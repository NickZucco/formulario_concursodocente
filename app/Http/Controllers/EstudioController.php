<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Estudio as Estudio;
use App\Pais as Pais;
use App\Perfil as Perfil;

class EstudioController extends Controller {

    public function show_info($msg = null) {
        $user_email = Auth::user()->email;
        $aspirante_id = Auth::user()->id;

        $estudios_info = Estudio::where('aspirantes_id', '=', $aspirante_id)->get();
        $perfiles_seleccionados_info = Perfil::leftJoin('aspirantes_perfiles','perfiles.id','=','perfiles_id')
                ->leftJoin('aspirantes','aspirantes.id','=','aspirantes_id')
                ->where('aspirantes.id','=',$aspirante_id)->get();
        
        //Si no hay entrada de adjunto válida, se crea una entrada con el id de usuario, por lo tanto, cambiamos el enlace para no mostrar esta información
        foreach ($estudios_info as $cur_estudio_key=>$cur_estudio) {
            if (preg_match("/^[0-9]+$/", $cur_estudio["ruta_adjunto"])) {            //La expresión regular para los ids autonuméricos
                $estudios_info[$cur_estudio_key]["ruta_adjunto"]=null;
            }
        }
        
        $paises = Pais::orderBy('nombre')->get();

        $data = array(
            'aspirante_id' => $aspirante_id,
            'estudios' => $estudios_info,
            'perfiles_seleccionados' =>$perfiles_seleccionados_info,
            'paises' => $paises,
            'msg' => $msg
        );
        return view('estudio', $data);
    }

    public function insert() {
        $input = Input::all();
        $msg = null;
		$id = Auth::user()->id;
		
        //Quitamos el radiobutton (al tener nombre se envia con el formulario)
        unset($input['additional_attatchments']);
		
		//Verificamos si el programa está en curso para no tener en cuenta la fecha de finalización
		if ($input['en_curso']==1) {
			unset($input['fecha_finalizacion']);
		}
		
        //Efectuamos las operaciones sobre los archivos adjuntos
		//Guardamos el adjunto de soporte si existe
		if (isset($input['adjunto'])) {
			$file = Input::file('adjunto');
			$titulo = str_replace(' ', '_', $input['titulo']) . '_' . str_replace(' ', '_', $input['institucion']);
			$file->move(public_path() . '\file\\' . $id . '\estudios\\' , $titulo . '_soporte.pdf');
			
			$input['ruta_adjunto'] = 'file\\' . $id . '\estudios\\' . $titulo . '_soporte.pdf';
			unset($input['adjunto']);
		}
		
        //Guardamos el soporte de tramite ante el Min Edu si existe
        if (isset($input['adjunto_entramite_minedu'])) {
			$file = Input::file('adjunto_entramite_minedu');
			$titulo = str_replace(' ', '_', $input['titulo']);
			$file->move(public_path() . '\file\\' . $id . '\estudios\\' , $titulo . '_entramite.pdf');
			
			$input['ruta_entramite_minedu'] = 'file\\' . $id . '\estudios\\' . $titulo . '_entramite.pdf';
			unset($input['adjunto_entramite_minedu']);
        }
		
        //Guardamos la resolución de convalidación del MinEdu para el título internacional si existe
        if (isset($input['adjunto_res_convalidacion'])) {
			$file = Input::file('adjunto_res_convalidacion');
			$titulo = str_replace(' ', '_', $input['titulo']);
			$file->move(public_path() . '\file\\' . $id . '\estudios\\' , $titulo . '_convalidacion.pdf');
			
			$input['ruta_res_convalidacion'] = 'file\\' . $id . '\estudios\\' . $titulo . '_convalidacion.pdf';
			unset($input['adjunto_res_convalidacion']);
        }

        //Guardamos los datos
        $input['aspirantes_id'] = $id;
        $estudio = Estudio::create($input);
        if ($estudio->save()) {
            return $this->show_info("Se ingresó exitosamente la información de estudios.");
        }
    }

    public function delete() {
        $input = Input::all();
        $estudio = Estudio::find($input["id"]);
		
		if ($estudio->ruta_adjunto) {			
			Storage::delete($estudio->ruta_adjunto);
		}
		if ($estudio->ruta_entramite_minedu) {
			Storage::delete($estudio->ruta_entramite_minedu);
		}
		if ($estudio->ruta_res_convalidacion) {
			Storage::delete($estudio->ruta_res_convalidacion);
		}
		
        //Borramos el registro en base de datos
        if ($estudio->delete()) {
            return $this->show_info("Se borró la información de estudio.");
        }
    }
}
