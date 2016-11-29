<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;

use App\Aspirante as Aspirante;
use App\Tiponivel as Tiponivel;
use App\Nivel as Nivel;
use App\Programa as Programa;
use App\TipoDocumento as TipoDocumento;
use App\TipoVinculacionAcademica as TipoVinculacionAcademica;
use App\Vinculacion as Vinculacion;
use App\Pais as Pais;

class VinculacionController extends Controller {

    public function show_info($msg = null) {
        $user_email = Auth::user()->email;
        $aspirante_id = Auth::user()->id;

        $tipos_vinculacion_academica = TipoVinculacionAcademica::all();
        $vinculaciones_academicas = Vinculacion::where('aspirantes_id', '=', $aspirante_id)->get();
        $paises = Pais::all()->keyBy('id');

        $data = array(
            'aspirante_id' => $aspirante_id,
            'correo' => $user_email,
            'paises' => $paises,
            'tipos_vinculacion_academica' => $tipos_vinculacion_academica,
            'vinculaciones_academicas' => $vinculaciones_academicas,
            'msg' => $msg,
        );
        return view('vinculacion', $data);
    }

    public function insert() {
        $input = Input::all();
        $input['aspirantes_id'] = Auth::user()->id;
        
        $vinculacion=Vinculacion::create($input);
        if ($vinculacion->save()) {
            return $this->show_info("Se ingresó la información de la vinculación");
        } 
    }
    public function delete(){
        $input = Input::all();
        $vinculacion=Vinculacion::find($input["id"]);
        if($vinculacion->delete()){
            return $this->show_info("Se borró la información de la vinculación.");
        }
    }

}
