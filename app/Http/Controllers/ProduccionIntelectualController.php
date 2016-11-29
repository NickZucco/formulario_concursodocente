<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;

use App\Pais as Pais;
use App\Idioma as Idioma;
use App\ProduccionIntelectual as ProduccionIntelectual;
use App\TipoProduccionIntelectual as TipoProduccionIntelectual;

class ProduccionIntelectualController extends Controller {

    var $ATTATCHMENT_FOLDER='/file/p_intelectual/';
    
    public function show_info($msg = null) {
        $user_email = Auth::user()->email;
        $aspirante_id = Auth::user()->id;

        $producciones_intelectual = ProduccionIntelectual::where('aspirantes_id', '=', $aspirante_id)->get();
       
        $paises = Pais::all()->keyBy('id');
        $idiomas = Idioma::all()->keyBy('id');
        $tipos_produccion_intelectual = TipoProduccionIntelectual::all()->keyBy('id');

        $data = array(
            'aspirantes_id' => $aspirante_id,
            'paises'=>$paises,
            'idiomas'=>$idiomas,
            'tipos_produccion_intelectual' => $tipos_produccion_intelectual,
            'producciones_intelectual' => $producciones_intelectual,
            'msg' => $msg,
        );
        return view('produccion_intelectual', $data);
    }

    public function insert() {
        $input = Input::all();
        $input['aspirantes_id'] = Auth::user()->id;
        
        //Efectuamos las operaciones sobre el archivo
        $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id,"PI");
        if(is_int($ruta_adjunto)){
            return $this->show_info("Ocurrió un error agregando el archivo adjunto. Error: ".$ruta_adjunto);
        }
        $input['ruta_adjunto']=$ruta_adjunto;
        unset($input['adjunto']);
        //

        $produccion_intelectual = ProduccionIntelectual::create($input);
        if ($produccion_intelectual->save()) {
            return $this->show_info("Se ingresó la información de la producción intelectual.");
        }
    }

    public function delete() {
        $input = Input::all();
        $produccion_intelectual = ProduccionIntelectual::find($input["id"]);
        if ($produccion_intelectual->delete()) {
            return $this->show_info("Se borró la información de la  producción intelectual.");
        }
    }

}
