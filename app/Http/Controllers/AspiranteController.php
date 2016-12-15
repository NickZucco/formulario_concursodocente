<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Auth;
use App\Aspirante as Aspirante;
use App\Tiponivel as Tiponivel;
use App\Nivel as Nivel;
use App\Programa as Programa;
use App\TipoDocumento as TipoDocumento;
use App\Pais as Pais;
use App\EstadoCivil as EstadoCivil;

class AspiranteController extends Controller {

    public function show_info($msg = null) {
        $data = array();

        try {
            $user_email = Auth::user()->email;
            $aspirante_id = Auth::user()->id;

            $candidate_info = Aspirante::where('correo', '=', $user_email)->first();

            $tiponiveles = Tiponivel::all();
            $niveles = Nivel::all();
            $programas = Programa::all();
            $tipos_documento = TipoDocumento::all();
            $paises = Pais::orderBy('nombre')->get();
            $estados_civiles = EstadoCivil::all();

            if (!$candidate_info) {
                $candidate_info = Aspirante::where('id', '=', 0)->first();
            }
        } catch (ErrorException $e) {
            $msg = "Ocurrió un error recopilando su información personal. Se recomienda cerrar sesión y abrirla nuevamente.";
        } finally {

            $data = array(
                'id' => $aspirante_id,
                'correo' => $user_email,
                'candidate_info' => $candidate_info,
                'tiponiveles' => $tiponiveles,
                'niveles' => $niveles,
                'programas' => $programas,
                'tipos_documento' => $tipos_documento,
                'paises' => $paises,
                'estados_civiles' => $estados_civiles,
                'msg' => $msg
            );
            return view('aspirante', $data);
        }
    }

    public function insert() {
        $input = Input::all();

        //Efectuamos las operaciones sobre los archivos adjuntos
        //Guardamos el soporte del documento de identidad (es obligatorio)
        $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id, "A_D", "adjunto_documento", true);
        if (is_int($ruta_adjunto)) {
            return $this->show_info("Ocurrió un error agregando el archivo adjunto de documento. Error: " . $ruta_adjunto);
        }
        $input['ruta_adjunto_documento'] = $ruta_adjunto;
        unset($input['adjunto_documento']);
		
        //Guardamos el documento de soporte de latarjeta profesional si existe
        if (isset($input['adjunto_tarjetaprofesional'])) {
            $ruta_adjunto = $this->moveAttatchmentFile(Auth::user()->id, "A_TP", "adjunto_tarjetaprofesional", false);
            if (is_int($ruta_adjunto)) {
                return $this->show_info("Ocurrió un error agregando el archivo adjunto tarjeta profesional. Error: " . $ruta_adjunto);
            }
            $input['ruta_adjunto_tarjetaprofesional'] = $ruta_adjunto;
            unset($input['adjunto_tarjetaprofesional']);
        }

        $id = Auth::user()->id;
        $input['id'] = $id;
        $record = Aspirante::find($id);

        if ($record) {
            $record->fill($input);
            $record->save();
            return $this->show_info("Se actualizó la información personal");
        } else {
            Aspirante::create($input);
            return $this->show_info("Se agregò exitosamente la información personal");
        }
    }

    public function show_close_form() {
        $msg=null; 
        
        $data = array(
            'msg' => $msg
        );
        return view('cerrar_formulario', $data);
    }

    public function close_form() {
       
    }

}
