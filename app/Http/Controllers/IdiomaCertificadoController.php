<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

use App\Idioma as Idioma;
use App\IdiomaCertificado as IdiomaCertificado;
use Auth;


class IdiomaCertificadoController extends Controller
{
    public function show_info($msg = null) {
        $aspirante_id = Auth::user()->id;

        $idiomas = Idioma::all()->keyBy('id');
        $idiomas_certificados=IdiomaCertificado::where('aspirantes_id','=',$aspirante_id)->get()->keyBy('id');
       
        $data = array(
            'aspirante_id' => $aspirante_id,
            'idiomas'=>$idiomas,
            'idiomas_certificados'=>$idiomas_certificados,
            'msg' => $msg,
        );
        return view('idiomas', $data);
    }

    public function insert() {
        $input = Input::all();
        $input['aspirantes_id'] = Auth::user()->id;
        
        //Efectuamos las operaciones sobre el archivo
        $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id,"ID");
        if(is_int($ruta_adjunto)){
            return $this->show_info("Ocurrió un error agregando el archivo adjunto. Error: ".$ruta_adjunto);
        }
        $input['ruta_adjunto']=$ruta_adjunto;
        unset($input['adjunto']);
        //

        $idiomas_certificado = IdiomaCertificado::create($input);
        if ($idiomas_certificado->save()) {
            return $this->show_info("Se ingresó la información de idioma.");
        }
    }
    
    public function delete(){
        $input = Input::all();
        $idiomas_certificado=IdiomaCertificado::find($input["id"]);
        if($idiomas_certificado->delete()){
            return $this->show_info("Se borró la información de idioma.");
        }
    }
}
