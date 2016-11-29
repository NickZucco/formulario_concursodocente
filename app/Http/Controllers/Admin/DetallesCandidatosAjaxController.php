<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Vinculacion as Vnculacion;

class DetallesCandidatosAjaxController extends Controller
{
    function vinculaciones($aspirantes_id){
        $msg=null;
        
        if ($request->isMethod('post')){ 
            $vinculaciones=Vinculacion::where('aspirantes_id','=',$aspirantes_id)->get()->keyBy('id');
        }
        $data = array(
            'msg' => $msg,
            'vinculaciones'=>  response()->json($vinculaciones)
        );
        return $data;
    }
}
