<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JasperPHP\JasperPHP;

use \App\Aspirante as Aspirante;
use \App\Estudio as Estudio;
use \App\Distincion as Distincion;
use \App\ExperienciaLaboral as ExperienciaLaboral;
use \App\ExperienciaDocente as ExperienciaDocente;
use \App\ExperienciaInvestigativa as ExperienciaInvestigativa;

class ReporteController extends Controller {

    public function reportePrueba($id) {
        
        $aspirante = Aspirante::leftJoin('vinculaciones', 'aspirantes.id', '=', 'vinculaciones.aspirantes_id')
                ->leftJoin('estudios', 'aspirantes.id', '=', 'estudios.aspirantes_id')
                ->leftJoin('distinciones_academica', 'aspirantes.id', '=', 'distinciones_academica.aspirantes_id')
                ->leftJoin('experiencias_laboral', 'aspirantes.id', '=', 'experiencias_laboral.aspirantes_id')
                ->leftJoin('experiencias_docente', 'aspirantes.id', '=', 'experiencias_docente.aspirantes_id')
                ->leftJoin('experiencias_investigativa', 'aspirantes.id', '=', 'experiencias_investigativa.aspirantes_id')
                ->select('aspirantes.nombre as aspirante_nombre', 'aspirantes.*','estudios.*')
                ->where('aspirantes.id', '=', $id)
                ->get();

        $aspirante=Aspirante::where('id', '=', $id)->first()->toArray();
        $aspirante_estudios=Estudio::where('aspirantes_id', '=', $id)->get()->toArray();
        $aspirante_distinciones_academicas=Distincion::where('aspirantes_id', '=', $id)->get();
        $aspirante_experiencias_laborales=ExperienciaLaboral::where('aspirantes_id', '=', $id)->get();
        $aspirante_experiencias_docente=ExperienciaDocente::where('aspirantes_id', '=', $id)->get();
        $aspirante_experiencias_investigativa=ExperienciaInvestigativa::where('aspirantes_id', '=', $id)->get();

        dd($aspirante);

        $output = public_path() . '/report/jrxml' . md5($id) . '';
        $report = new JasperPHP;
        $report->process(
                public_path() . '/report/jrxml/hello_world_params.jrxml',
                $output,
                array('pdf'),
                array(
                    "personal_info"=>$aspirante,
                    
                    ), 
                array(), 'es_CO' //locale  
        )->execute();

        //PDF file is stored under project/public/download/info.pdf
        $headers = array(
            'Content-Type: application/pdf',
        );
        return response()->download($output.".pdf", date("Y-m-d H_i_s").'.pdf', $headers);
    }

}

