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

use JasperPHP\JasperPHP;

class AdminController extends Controller {

    public function getLogin() {
        $data = array(
            'msg' => null
        );
        return view('admin/login', $data);
    }
    public function getLogout(){
        
        $data = array(
            'msg' => "Se ha cerrado la sesión exitosamente"
        );
        
        return view('admin/login', $data);
    }
    public function postLogin(Request $request) {
        $input = Input::all();
        $msg = null;
        $ldap_data = null;
        $admin_user=null;
        
        $redirect_to='admin/login';

        $ldap_data = AdminController::ldapSearch($input['email'], $input['password']);
        
        if ($ldap_data) {
            $admin_user=User::where('email','=',$input['email'])
                    ->where('isadmin','=',1)
                    ->where('id','<>',0)                           //La primera entrada vacia de la base de datos es un comodin
                    ->get()
                    ->keyBy('id');
            if($admin_user){
                //Guardamos nuestra sesión
                //$request->session->put('admin_session',$admin_user);
                return $this->showCandidates();
            }else{
                $msg="Actualmente usted no cuenta con permisos de consulta sobre este módulo.";
            }
        }else{
            $msg="No se encontró el usuario/password en el sistema de autenticación institucional.";
        }
        $data = array(
            'msg' => $msg,
            'user_info'=>$admin_user,
        );
        return view($redirect_to,$data);
    }

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
        return view('admin/candidatos',$data);
    }
	
	public function getAttachments(){
		$input = Input::all();
		$id = $input['id'];
		$aspirante_info = Aspirante::find($id);
		$pathtofile = public_path() . '\file\\' . $id . '\\' . $aspirante_info->nombre . ' ' . $aspirante_info->apellido . '_adjuntos.zip';
		if (File::exists($pathtofile)){
			return response()->download($pathtofile);
		}
		else{
			$files = public_path() . '\file\\' . $id;		
			Zipper::make($pathtofile)->add($files)->close();
			return response()->download($pathtofile);
		}
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
