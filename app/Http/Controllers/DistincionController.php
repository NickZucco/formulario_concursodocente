<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Auth;
use App\Pais as Pais;
use App\Distincion as Distincion;

class DistincionController extends Controller {

    var $ATTATCHMENT_FOLDER = '/file/distinciones/';

    public function show_info($msg = null) {
        $user_email = Auth::user()->email;
        $aspirante_id = Auth::user()->id;

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
        );
        return view('distincion', $data);
    }

    public function insert() {
        $input = Input::all();
        $input['aspirantes_id'] = Auth::user()->id;

        //Efectuamos las operaciones sobre el archivo
        $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id, "DI_");
        if (is_int($ruta_adjunto)) {
            return $this->show_info("Ocurrió un error agregando el archivo adjunto. Error: " . $ruta_adjunto);
        }
        $input['ruta_adjunto'] = $ruta_adjunto;
        unset($input['adjunto']);
        //

        $distincion = Distincion::create($input);
        if ($distincion->save()) {
            return $this->show_info("Se ingresó la información de la distinción académica");
        }
    }

    public function delete() {
        $input = Input::all();
        $distincion = Distincion::find($input["id"]);
        if ($distincion->delete()) {
            return $this->show_info("Se borró la información de la distincion académica.");
        }
    }

}
