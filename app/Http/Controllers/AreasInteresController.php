<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;

use App\AreasInteres as AreasInteres;

class AreasInteresController extends Controller
{
    public function show_info($msg = null) {
        $user_email = Auth::user()->email;
        $aspirante_id = Auth::user()->id;

        $areas_interes = AreasInteres::where('aspirantes_id','=',$aspirante_id)->get();

        $data = array(
            'aspirante_id' => $aspirante_id,
            'areas_interes'=>$areas_interes,
            'msg' => $msg,
        );
        return view('areas_interes', $data);
    }

    public function insert() {
        $input = Input::all();
        $input['aspirantes_id'] = Auth::user()->id;

        $areas_interes = AreasInteres::create($input);
        if ($areas_interes->save()) {
            return $this->show_info("Se ingresó la información del área de interes.");
        }
    }
    
    public function delete(){
        $input = Input::all();
        $areas_interes=AreasInteres::find($input["id"]);
        if($$areas_interes->delete()){
            return $this->show_info("Se borró la información del área de interes.");
        }
    }
}
