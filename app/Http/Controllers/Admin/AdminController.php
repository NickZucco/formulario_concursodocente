<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Requests;

use App\User as User;
use App\Aspirante as Aspirante;
use App\Perfil as Perfil;
use App\AspirantePerfil as AspirantePerfil;
use App\TipoDocumento as TipoDocumento;
use App\Estudio as Estudio;
use App\Distincion as Distincion;
use App\ExperienciaLaboral as ExperienciaLaboral;
use App\TipoVinculacionLaboral as TipoVinculacionLaboral;
use App\ExperienciaDocente as ExperienciaDocente;
use App\TipoVinculacionDocente as TipoVinculacionDocente;
use App\ExperienciaInvestigativa as ExperienciaInvestigativa;
use App\ProduccionIntelectual as ProduccionIntelectual;
use App\TipoProduccionIntelectual as TipoProduccionIntelectual;
use App\IdiomaCertificado as IdiomaCertificado;
use Zipper;
use Excel;
use Dompdf\Dompdf;

use JasperPHP\JasperPHP;

class AdminController extends Controller {

    public function showCandidates(){
        $aspirantes = Aspirante::where('id','<>',0)->get()->keyBy('id');
        $perfiles = Perfil::all();
		$aspirantes_perfiles = AspirantePerfil::all()->toJson();
        $tipos_documento = TipoDocumento::all()->keyBy('id');
        
        $msg=null;
        $data = array(
            'msg' => $msg,
            'aspirantes'=>$aspirantes,
			'perfiles'=>$perfiles,
			'aspirantes_perfiles'=>$aspirantes_perfiles,
            'tipos_documento'=>$tipos_documento,
        );
        return view('admin/candidatos', $data);
    }
	
	public function getAttachments(){
		$input = Input::all();
		$id = $input['id'];
		$aspirante_info = Aspirante::find($id);
		$pathtofile = public_path() . '/file/' . $id . '/' . $aspirante_info->nombre . ' ' . $aspirante_info->apellido . '_adjuntos.zip';
		if (File::exists($pathtofile)){
			return response()->download($pathtofile);
		}
		else{
			$files = public_path() . '/file/' . $id;		
			Zipper::make($pathtofile)->add($files)->close();
			return response()->download($pathtofile);
		}
	}
	
	public function getReport(){
		$input = Input::all();
		$id = $input['id'];
		
		$aspirante = Aspirante::join('tipos_documento', 'aspirantes.tipo_documento_id', '=', 'tipos_documento.id')
			->join('paises as p1', 'aspirantes.pais_nacimiento', '=', 'p1.id')
			->join('paises as p2', 'aspirantes.pais_residencia', '=', 'p2.id')
			->join('estados_civil', 'aspirantes.estado_civil_id', '=', 'estados_civil.id')
			->select(
				'aspirantes.id as id',
				'aspirantes.documento as documento',
				'tipos_documento.nombre as tipo_documento',
				'aspirantes.ciudad_expedicion_documento as ciudad_documento',
				'aspirantes.nombre as nombre',
				'aspirantes.apellido as apellido',
				'aspirantes.fecha_nacimiento as fecha_nacimiento',
				'p1.nombre as pais_nacimiento',
				'p2.nombre as pais_residencia',
				'aspirantes.direccion_residencia as direccion',
				'aspirantes.correo as correo',
				'aspirantes.created_at as fecha_registro',
				'aspirantes.updated_at as fecha_actualizacion',
				'estados_civil.nombre as estado_civil',
				'aspirantes.ciudad_aplicante as ciudad_aplicante',
				'aspirantes.telefono_fijo as telefono_fijo',
				'aspirantes.telefono_movil as celular'
			)->where('aspirantes.id', '=', $id)->get();
		$aspirante = $aspirante[0];
		
		$perfiles = Perfil::join('aspirantes_perfiles', 'perfiles_id', '=', 'id')
			->select(
				'perfiles.identificador as identificador',
				'perfiles.area_desempeno as area'
			)->where('aspirantes_id', '=', $id)->get();
			
		$nombre_aspirante = $aspirante->nombre . ' ' . $aspirante->apellido;
		//Generar un string con los perfiles seleccionados separados con una coma
		$perfiles_string = '';
		foreach ($perfiles as $perfil) {
			$perfiles_string = $perfiles_string . $perfil->identificador . ', ';
		}
			
		//Remover la última coma y espacio del string
		if (strlen($perfiles_string) > 0) {
			$perfiles_string = substr($perfiles_string, 0, strlen($perfiles_string) - 2);
		}
		
		$pathtofile = public_path() . '/file/' . $id . '/' . $nombre_aspirante . '_HV.pdf';
		/*if (File::exists($pathtofile)){
			return response()->download($pathtofile);
		}
		else{*/
			$estudios = Estudio::join('paises', 'estudios.paises_id', '=', 'paises.id')
			->select(
				'estudios.titulo as titulo',
				'estudios.institucion as institucion',
				'estudios.fecha_inicio as fecha_inicio',
				'estudios.fecha_finalizacion as fecha_finalizacion',
				'estudios.en_curso as en_curso',
				'paises.nombre as pais'
			)->where('aspirantes_id', '=', $id)->get();
		
			$distinciones = Distincion::where('aspirantes_id', '=', $id)->get();
			
			$experiencia_laboral = ExperienciaLaboral::join('tipos_vinculacion_laboral', 
				'experiencias_laboral.tipos_vinculacion_laboral_id', '=', 'tipos_vinculacion_laboral.id')
				->select(
					'experiencias_laboral.nombre_cargo as cargo',
					'tipos_vinculacion_laboral.nombre as tipo_vinculacion',
					'experiencias_laboral.nombre_institucion as institucion',
					'experiencias_laboral.funcion_principal as funcion',
					'experiencias_laboral.fecha_inicio as fecha_inicio',
					'experiencias_laboral.fecha_finalizacion as fecha_finalizacion',
					'experiencias_laboral.en_curso as en_curso'
				)->where('aspirantes_id', '=', $id)
				->orderBy('experiencias_laboral.fecha_inicio', 'asc')->get();
				
			$experiencia_docente = ExperienciaDocente::join('tipos_vinculacion_docente',
				'experiencias_docente.dedicacion', '=', 'tipos_vinculacion_docente.id')
				->select(
					'experiencias_docente.nombre_institucion as institucion',
					'tipos_vinculacion_docente.nombre as dedicacion',
					'experiencias_docente.fecha_inicio as fecha_inicio',
					'experiencias_docente.fecha_finalizacion as fecha_finalizacion',
					'experiencias_docente.en_curso as en_curso',
					'experiencias_docente.area_trabajo as area',
					'experiencias_docente.info_asignaturas as asignaturas'
				)->where('aspirantes_id', '=', $id)
				->orderBy('experiencias_docente.fecha_inicio', 'asc')->get();
				
			$experiencia_investigativa = ExperienciaInvestigativa::join('paises', 
				'experiencias_investigativa.paises_id', '=', 'paises.id')
				->select(
					'experiencias_investigativa.nombre_proyecto as proyecto',
					'experiencias_investigativa.institucion as institucion',
					'experiencias_investigativa.area_proyecto as area_proyecto',
					'experiencias_investigativa.funcion_principal as funcion_principal',
					'experiencias_investigativa.fecha_inicio as fecha_inicio',
					'experiencias_investigativa.fecha_finalizacion as fecha_finalizacion',
					'experiencias_investigativa.en_curso as en_curso',
					'paises.nombre as pais'
				)->where('aspirantes_id', '=', $id)
				->orderBy('experiencias_investigativa.fecha_inicio', 'asc')->get();
				
			$produccion_intelectual = ProduccionIntelectual::join('paises', 
				'produccion_intelectual.paises_id', '=', 'paises.id', 'left outer')
				->join('idiomas', 'produccion_intelectual.idiomas_id', '=', 'idiomas.id')
				->join('tipos_produccion_intelectual', 'produccion_intelectual.tipos_produccion_intelectual_id',
					'=', 'tipos_produccion_intelectual.id')
				->select(
					'produccion_intelectual.nombre as nombre_produccion',
					'produccion_intelectual.publicacion_titulo as revista',
					'produccion_intelectual.publicacion_autor as autor',
					'produccion_intelectual.paginas as paginas',
					'produccion_intelectual.año as año',
					'produccion_intelectual.ISSN as ISSN',
					'produccion_intelectual.nombre_editorial as editorial',
					'produccion_intelectual.nombre_libro as nombre_libro',
					'produccion_intelectual.tipo as tipo_articulo',
					'produccion_intelectual.volumen as volumen_revista',
					'produccion_intelectual.clasificacion_revista as clasificacion_revista',
					'produccion_intelectual.ISBN as ISBN',
					'produccion_intelectual.descripcion as descripcion_patente',
					'produccion_intelectual.numero_patente as numero_patente',
					'produccion_intelectual.tipo_patente as tipo_patente',
					'produccion_intelectual.entidad_patente as entidad_patente',
					'paises.nombre as pais',
					'idiomas.nombre as idioma',
					'tipos_produccion_intelectual.nombre as tipo_produccion'
				)->where('aspirantes_id', '=', $id)
				->orderBy('produccion_intelectual.año', 'asc')->get();
				
			$idiomas_certificados=IdiomaCertificado::join('idiomas', 'idiomas_certificado.idiomas_id',
				'=', 'idiomas.id')
				->select(
					'idiomas.nombre as idioma',
					'idiomas_certificado.nativo as nativo',
					'idiomas_certificado.nombre_certificado as certificado',
					'idiomas_certificado.puntaje as puntaje'
				)
				->where('aspirantes_id','=',$id)->get();
			
			$data = array(
				'aspirante' => $aspirante,
				'perfiles' => $perfiles,
				'estudios' => $estudios,
				'distinciones' => $distinciones,
				'experiencia_laboral' => $experiencia_laboral,
				'experiencia_docente' => $experiencia_docente,
				'experiencia_investigativa' => $experiencia_investigativa,
				'produccion_intelectual' => $produccion_intelectual,
				'idiomas_certificados' => $idiomas_certificados
			);
			
			$pdf = \App::make('dompdf.wrapper');
			$pdf->loadView('admin/reporte', $data);
			$pdf->output();
			$dom_pdf = $pdf->getDomPDF();
			$canvas = $dom_pdf ->get_canvas();
			$canvas->page_text(15, 15, 'Página {PAGE_NUM} de {PAGE_COUNT} - ' . $nombre_aspirante . ' - ' 
								. $perfiles_string, null, 8, array(0, 0, 0));
			$pdf->save($pathtofile);
			return response()->download($pathtofile);
		/*
		}
		*/
	}
	
	public function excel(){
		// Ejecutar la consulta para obtener los datos de los aspirantes.
		// Se deben realizar los siguientes joins:
		// -- con la tabla tipos_documento para obtener el nombre del documento (Cédula de ciudadanía, etc)
		// -- con la tabla países con un alias p1 para el país de nacimiento
		// -- con la tabla países con un alias p2 para el país de residencia
		// -- con la tabla estados_civil para conocer el nombre del estado civil (Soltero, Casado, etc)
		$aspirantes = Aspirante::join('tipos_documento', 'aspirantes.tipo_documento_id', '=', 'tipos_documento.id')
			->join('paises as p1', 'aspirantes.pais_nacimiento', '=', 'p1.id')
			->join('paises as p2', 'aspirantes.pais_residencia', '=', 'p2.id')
			->join('estados_civil', 'aspirantes.estado_civil_id', '=', 'estados_civil.id')
			->select(
				'aspirantes.id as id',
				'aspirantes.documento as documento',
				'tipos_documento.nombre as tipo_documento',
				'aspirantes.ciudad_expedicion_documento as ciudad_documento',
				'aspirantes.nombre as nombre',
				'aspirantes.apellido as apellido',
				'aspirantes.fecha_nacimiento as fecha_nacimiento',
				'p1.nombre as pais_nacimiento',
				'p2.nombre as pais_residencia',
				'aspirantes.direccion_residencia as direccion',
				'aspirantes.correo as correo',
				'aspirantes.created_at as fecha_registro',
				'aspirantes.updated_at as fecha_actualizacion',
				'estados_civil.nombre as estado_civil',
				'aspirantes.ciudad_aplicante as ciudad_aplicante',
				'aspirantes.telefono_fijo as telefono_fijo',
				'aspirantes.telefono_movil as celular'
			)->get();
		
		// Inicializar el array que será pasado al Excel generator
		$aspirantesArray = [];
		
		// Agregar los encabezados de la tabla
		$aspirantesArray[] = ['Documento', 'Tipo de documento', 'Ciudad de expedición', 'Nombres', 'Apellidos',
			'Fecha de nacimiento', 'País de nacimiento', 'Pais de residencia', 'Dirección', 'Correo',
			'Fecha de registro', 'Última fecha de actualización', 'Estado Civil', 'Ciudad en donde aplica', 
			'Teléfono fijo', 'Celular', 'Perfiles seleccionados'];
		
		// Convertir cada miembro de la colección retornada a array,
		// agregar los perfiles seleccionados y anexarlo al array de aspirantes.
		foreach ($aspirantes as $aspirante) {
			$id = $aspirante['id'];
			unset($aspirante['id']);
			$perfiles_seleccionados = Perfil::join('aspirantes_perfiles', 'perfiles_id', '=', 'id')
                        ->where('aspirantes_id', '=', $id)->get();
			$aspiranteArray = $aspirante->toArray();
			$perfiles_string = '';
			foreach ($perfiles_seleccionados as $perfil) {
				$perfiles_string = $perfiles_string . $perfil->identificador . ', ';
			}
			
			//Remover la última coma y espacio del string
			if (strlen($perfiles_string) > 0) {
				$perfiles_string = substr($perfiles_string, 0, strlen($perfiles_string) - 2);
				array_push($aspiranteArray, $perfiles_string);
			}
			$aspirantesArray[] = $aspiranteArray;
		}
		
		// Generar y descargar la hoja de cálculo
		Excel::create('Candidatos Concurso Docente 2017', function($excel) use ($aspirantesArray) {

			// Titulo, creador y descripción
			$excel->setTitle('Candidatos Concurso Docente 2017');
			$excel->setCreator('Universidad Nacional de Colombia')->setCompany('Universidad Nacional de Colombia');
			$excel->setDescription('Archivo con información de todos los aspirantes');

			// Construir la hoja de cálculo pasando el arreglo como parámetro
			$excel->sheet('sheet1', function($sheet) use ($aspirantesArray) {
				$sheet->fromArray($aspirantesArray, null, 'A1', false, false);
			});

		})->download('xlsx');
	}

    private static function ldapSearch($username, $password) {
        $ldap_coneccion = ldap_connect("ldaprbog.unal.edu.co", 389) or die(ldap_error());

        $ldap_base = 'ou=people,o=bogota,o=unal.edu.co';
        $ldap_criterio = 'uid=' . $username;

        $salida=null;
        $pwd = $password;
        $ldap_dn = "uid=$username,o=bogota,o=unal.edu.co";

        $ramasouLDAP = array("people", "institucional", "dependencias");
        foreach ($ramasouLDAP as $ramaActual) {
            $ldap_dn = 'uid=' . $username . ',ou=' . $ramaActual . ',o=bogota,o=unal.edu.co';
            if (@ldap_bind($ldap_coneccion, $ldap_dn, $pwd)) {
                $ldap_buscar = ldap_search($ldap_coneccion, $ldap_base, $ldap_criterio) or die(ldap_error());
                $info = ldap_get_entries($ldap_coneccion, $ldap_buscar);
                $salida = self::fetch_ldap_data($info, array('givenname', 'sn', 'uid', 'employeenumber', 'labeleduri'));
                break;
            }
        }
        return $salida;
    }

    /**
     * Funcion que devuelde los datos del LDAP procesados, dependiendo de los campos seleccionados
     * @param type $ldap_attributes: atributos retornados por ldap_get_attributes 
     * @param type $ldap_fields: arreglo con los indices del vector $ldap_attributes a procesar
     * @return 
     */
    private static function fetch_ldap_data($ldap_attributes, $ldap_fields) {
        $retorno = null;
        foreach ($ldap_fields as $field) {
            switch ($field) {
                case 'givenname':
                    $retorno[$field] = preg_replace('/\s+/', ' ', trim($ldap_attributes[0][$field][0]));
                    break;
                case 'cn':
                    $retorno[$field] = preg_replace('/\s+/', ' ', trim($ldap_attributes[0][$field][0]));
                    break;
                case 'sn':
                    $retorno[$field] = preg_replace('/\s+/', ' ', trim($ldap_attributes[0][$field][0]));
                    break;
                case 'uid':
                    $retorno[$field] = $ldap_attributes[0][$field][0];
                    $retorno["email"] = $retorno[$field] . "@unal.edu.co";            //Evita depender del campo 'email' del LDAP
                    break;
                case 'labeleduri':
                    $retorno[$field] = $ldap_attributes[0][$field][0];
                    break;
                case 'employeenumber':
                    $retorno[$field] = $ldap_attributes[0][$field][0];
                    break;
                default:
                    break;
            }
        }
        return $retorno;
    }

}
