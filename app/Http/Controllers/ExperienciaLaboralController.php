<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;

use App\ExperienciaLaboral as ExperienciaLaboral;
use App\TipoVinculacionLaboral as TipoVinculacionLaboral;

class ExperienciaLaboralController extends Controller {

    var $ATTATCHMENT_FOLDER='/file/e_laboral/';
    
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
        $input['aspirantes_id'] = Auth::user()->id;

        //Efectuamos las operaciones sobre el archivo
        $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id,"EL");
        if(is_int($ruta_adjunto)){
            return $this->show_info("Ocurrió un error agregando el archivo adjunto. Error: ".$ruta_adjunto);
        }
        $input['ruta_adjunto']=$ruta_adjunto;
        unset($input['adjunto']);
        //
        
        $experiencia_laboral = ExperienciaLaboral::create($input);
        if ($experiencia_laboral->save()) {
            return $this->show_info("Se ingresó exitosamente la información de experiencia laboral.");
        }
    }
    
    public function delete(){
        $input = Input::all();
        $experiencia_laboral=ExperienciaLaboral::find($input["id"]);
        if($experiencia_laboral->delete()){
            return $this->show_info("Se borró la información de la experiencia laboral.");
        }
    }

}
