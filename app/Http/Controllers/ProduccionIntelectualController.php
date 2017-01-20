<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Auth;

use App\Pais as Pais;
use App\Idioma as Idioma;
use App\ProduccionIntelectual as ProduccionIntelectual;
use App\TipoProduccionIntelectual as TipoProduccionIntelectual;

class ProduccionIntelectualController extends Controller {
    
    public function show_info($msg = null) {
        $user_email = Auth::user()->email;
        $aspirante_id = Auth::user()->id;

        $producciones_intelectual = ProduccionIntelectual::where('aspirantes_id', '=', $aspirante_id)->get();
        
        $paises = Pais::orderBy('nombre')->get();
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
        $id = Auth::user()->id;
        
        //Efectuamos las operaciones sobre el archivo
		$file = Input::file('adjunto');
		switch($input['tipos_produccion_intelectual_id']){
			case 1:
				$titulo = 'Revista_' . str_replace(' ', '_', $input['nombre']);
				break;
			case 2:
				$titulo = 'Libro_' . str_replace(' ', '_', $input['nombre']);
				break;
			case 3:
				$titulo = 'Capitulo_' . str_replace(' ', '_', $input['nombre']);			
				break;
			case 4:
				$titulo = 'Patente_' . str_replace(' ', '_', $input['nombre']);
				break;
		}
		$file->move(public_path() . '/file/' . $id . '/produccion_intelectual/' , $titulo . '.pdf');	
		$input['ruta_adjunto'] = 'file/' . $id . '/produccion_intelectual/' . $titulo . '.pdf';
		unset($input['adjunto']);
		
		$input['aspirantes_id'] = $id;
        $produccion_intelectual = ProduccionIntelectual::create($input);
        if ($produccion_intelectual->save()) {
            return $this->show_info("Se ingresó la información de la producción intelectual.");
        }
    }

    public function delete() {
        $input = Input::all();
        $produccion_intelectual = ProduccionIntelectual::find($input["id"]);
		
		if ($produccion_intelectual->ruta_adjunto) {		
			Storage::delete($produccion_intelectual->ruta_adjunto);
		}
        if ($produccion_intelectual->delete()) {
            return $this->show_info("Se borró la información de la  producción intelectual.");
        }
    }
}
