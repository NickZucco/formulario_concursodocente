<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;
use App\ExperienciaDocente as ExperienciaDocente;
use App\Pais as Pais;
use App\ExperienciaInvestigativa as ExperienciaInvestigativa;

class ExperienciaInvestigativaController extends Controller {

    var $ATTATCHMENT_FOLDER='/file/e_investigativa/';
    
    public function show_info($msg = null) {
        $user_email = Auth::user()->email;
        $aspirante_id = Auth::user()->id;

        $experiencia_investigativa = ExperienciaInvestigativa::where('aspirantes_id', '=', $aspirante_id)->get();
        $paises = Pais::all();

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
        $input['aspirantes_id'] = Auth::user()->id;
        
        //Efectuamos las operaciones sobre el archivo
        $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id,"EI");
        if(is_int($ruta_adjunto)){
            return $this->show_info("Ocurrió un error agregando el archivo adjunto. Error: ".$ruta_adjunto);
        }
        $input['ruta_adjunto']=$ruta_adjunto;
        unset($input['adjunto']);
        //

        $experiencia_docente = ExperienciaInvestigativa::create($input);
        if ($experiencia_docente->save()) {
            return $this->show_info("Se ingresó exitosamente la información de experiencia investigativa.");
        }
    }
    
    public function delete() {
        $input = Input::all();
        $experiencia_docente = ExperienciaInvestigativa::find($input["id"]);
        if ($experiencia_docente && $experiencia_docente->delete()) {
            return $this->show_info("Se borró la información de la experiencia investigativa.");
        }else{
            return $this->show_info();
        }
    }

}
