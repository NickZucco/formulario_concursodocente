<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
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
		$id = Auth::user()->id;
		
		//Validar si la cédula ingresada ya se encuentra en la base de datos_personales
		$aspirante_cedula = Aspirante::where('documento', $input['documento'])->get();
		$aspirante_cedula = $aspirante_cedula->toArray();
		//dd($aspirante_cedula);
		if(!empty($aspirante_cedula)){
			if ($id != $aspirante_cedula['0']['id']) {
				return redirect()->back()->with('message', 'El número de documento ingresado ya se encuentra en la base de datos');
			}
		}
        
        $input['id'] = $id;
        $record = Aspirante::find($id);

        if ($record) {
			//Efectuamos las operaciones sobre los archivos adjuntos
			//Borramos y guardamos nuevamente el soporte del documento de identidad
			Storage::delete($record->ruta_adjunto_documento);
			
			$file = Input::file('adjunto_documento');
			$file->move(public_path() . '\file\\' . $id . '\datos_personales\\' , 'documento_identidad.pdf');
			
			$input['ruta_adjunto_documento'] = 'file\\' . $id . '\datos_personales\\' . 'documento_identidad.pdf';
			unset($input['adjunto_documento']);
			
			//Borramos y guardamos nuevamente el soporte de la tarjeta profesional
			if (isset($input['adjunto_tarjetaprofesional'])) {
				if ($record->ruta_adjunto_tarjetaprofesional){					
					Storage::delete($record->ruta_adjunto_tarjetaprofesional);
				}
				$file = Input::file('adjunto_tarjetaprofesional');
				$file->move(public_path() . '\file\\' . $id . '\datos_personales\\' , 'tarjeta_profesional.pdf');
				
				$input['ruta_adjunto_tarjetaprofesional'] = 'file\\' . $id . '\datos_personales\\' . 'tarjeta_profesional.pdf';
				unset($input['adjunto_tarjetaprofesional']);
			}
			
            $record->fill($input);
            $record->save();
            return $this->show_info("Se actualizó la información personal");
        }
		else {
			//Efectuamos las operaciones sobre los archivos adjuntos
			//Guardamos el soporte del documento de identidad (es obligatorio)
			$file = Input::file('adjunto_documento');
			$file->move(public_path() . '\file\\' . $id . '\datos_personales\\' , 'documento_identidad.pdf');
			
			$input['ruta_adjunto_documento'] = 'file\\' . $id . '\datos_personales\\' . 'documento_identidad.pdf';
			unset($input['adjunto_documento']);
			
			//Guardamos el documento de soporte de la tarjeta profesional si existe
			if (isset($input['adjunto_tarjetaprofesional'])) {
				$file = Input::file('adjunto_tarjetaprofesional');
				$file->move(public_path() . '\file\\' . $id . '\datos_personales\\' , 'tarjeta_profesional.pdf');
				
				$input['ruta_adjunto_tarjetaprofesional'] = 'file\\' . $id . '\datos_personales\\' . 'tarjeta_profesional.pdf';
				unset($input['adjunto_tarjetaprofesional']);
			}
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
