<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Auth;
use App\Estudio as Estudio;
use App\Pais as Pais;
use App\Perfil as Perfil;

class EstudioController extends Controller {
    
    var $ATTATCHMENT_FOLDER='/file/estudios/';

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
        
        //dd($perfiles_seleccionados_info);
        
        $paises = Pais::all();

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
        //Quitamos el radiobutton (al tener nombre se envia con el formulario ¬¬)
        unset($input['additional_attatchments']);
        //Efectuamos las operaciones sobre el archivo
        //adjunto_entramite_minedu
        if (isset($input['adjunto_entramite_minedu'])) {
            $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id, "A_MINEDU", "adjunto_entramite_minedu", true);
            if (is_int($ruta_adjunto)) {
                return $this->show_info("Ocurrió un error agregando el archivo adjunto de documento: En trámite ante el ministerio de educación. Error: " . $ruta_adjunto);
            }
            $input['ruta_entramite_minedu'] = $ruta_adjunto;
            unset($input['adjunto_entramite_minedu']);
        }
        //adjunto_res_convalidacion
        if (isset($input['adjunto_res_convalidacion'])) {
            $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id, "A_RESCONV", "adjunto_res_convalidacion", false);
            if (is_int($ruta_adjunto)) {
                return $this->show_info("Ocurrió un error agregando el archivo adjunto de documento: Resolución de convalidación. Error:" . $ruta_adjunto);
            }
            $input['ruta_res_convalidacion'] = $ruta_adjunto;
            unset($input['adjunto_res_convalidacion']);
        }
        //adjunto_resumen_ejecutivo
        if (isset($input['adjunto_resumen_ejecutivo'])) {
            $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id, "A_RESEJEC", "adjunto_resumen_ejecutivo", true);
            if (is_int($ruta_adjunto)) {
                return $this->show_info("Ocurrió un error agregando el archivo adjunto de documento: Resumen ejecutivo de tesis. Error: " . $ruta_adjunto);
            }
            $input['ruta_resumen_ejecutivo'] = $ruta_adjunto;
            unset($input['adjunto_resumen_ejecutivo']);
        }
        //adjunto de estudios
        $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id,"ES");
        if(is_int($ruta_adjunto)){
            return $this->show_info("Ocurrió un error agregando el archivo adjunto. Error: ".$ruta_adjunto);
        }
        $input['ruta_adjunto']=$ruta_adjunto;
        unset($input['adjunto']);
        //
        
        
        
        //Guardamos los datos
        $input['aspirantes_id'] = Auth::user()->id;
        $estudio = Estudio::create($input);
        if ($estudio->save()) {
            return $this->show_info("Se ingresó exitosamente la información de estudios.");
        }
    }

    public function delete() {
        $input = Input::all();
        $estudio = Estudio::find($input["id"]);
        $this->deleteAttatchmentFile($estudio->ruta_adjunto);
        //Borramos el registro en base de datos
        if ($estudio->delete()) {
            return $this->show_info("Se borró la información de estudio.");
        }
    }
}
