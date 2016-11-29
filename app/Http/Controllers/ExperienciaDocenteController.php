<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Auth;
use App\Pais as Pais;
use App\ExperienciaDocente as ExperienciaDocente;
use App\TipoVinculacionDocente as TipoVinculacionDocente;
use App\Nivel as Nivel;

class ExperienciaDocenteController extends Controller {

    public function show_info($msg = null) {
        $user_email = Auth::user()->email;
        $aspirante_id = Auth::user()->id;

        $experiencias_docente_info = ExperienciaDocente::where('aspirantes_id', '=', $aspirante_id)->get();
        $tipos_vinculacion_docente = TipoVinculacionDocente::all();
        $paises = Pais::all();
        $niveles = Nivel::all();

        $data = array(
            'aspirante_id' => $aspirante_id,
            'experiencias_docente' => $experiencias_docente_info,
            'tipos_vinculacion_docente' => $tipos_vinculacion_docente,
            'niveles' => $niveles,
            'paises' => $paises,
            'msg' => $msg
        );
        return view('experiencia_docente', $data);
    }

    public function insert() {
        $input = Input::all();
        $input['aspirantes_id'] = Auth::user()->id;

        //Efectuamos las operaciones sobre el archivo
        $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id, "ED");
        if (is_int($ruta_adjunto)) {
            return $this->show_info("Ocurrió un error agregando el archivo adjunto. Error: " . $ruta_adjunto);
        }
        $input['ruta_adjunto'] = $ruta_adjunto;
        unset($input['adjunto']);
        //
        //adaptamos el campo info_asignaturas (es un array, lo volvemos JSON y lo guardamos en la BD)

        $input['info_asignaturas'] = json_encode(self::transpose($input['info_asignaturas']));
        $experiencia_docente = ExperienciaDocente::create($input);
        if ($experiencia_docente->save()) {
            return $this->show_info("Se ingresó exitosamente la información de experiencia docente.");
        }
    }

    public function delete() {
        $input = Input::all();
        $vinculacion = ExperienciaDocente::find($input["id"]);
        if ($vinculacion && $vinculacion->delete()) {
            return $this->show_info("Se borró la información de la experiencia docente.");
        } else {
            return $this->show_info();
        }
    }

    //Solo para PHP 5.6+
    private static function transpose($array) {
        $out = array();
        foreach ($array as $key => $subarr) {
            foreach ($subarr as $subkey => $subvalue) {
                $out[$subkey][$key] = $subvalue;
            }
        }
        return $out;
    }

}
