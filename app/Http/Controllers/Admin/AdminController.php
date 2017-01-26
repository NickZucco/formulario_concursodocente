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
use App\Programa as Programa;
use Zipper;
use Excel;

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
	
	public function excel(){
		Debugbar::info("Intentamos descargar Excel");
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
			
			//Remover la última coma del string
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
