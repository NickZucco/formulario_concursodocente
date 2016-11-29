<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

/**///
use Illuminate\Support\Facades\Input;
use Request;

class Controller extends BaseController {

    use AuthorizesRequests,
        AuthorizesResources,
        DispatchesJobs,
        ValidatesRequests;

    var $ATTATCHMENT_FOLDER = '/file/sink/';
    var $CREATE_FOLDER_ERROR = 1;
    var $NOT_WRITTABLE_FOLDER_ERROR = 2;
    var $ATTATCHMENT_NOT_FOUND_ERROR = 3;

    protected function moveAttatchmentFile($folder_name,$prefix="DOC",$file_inputname=null,$mandatory=true) {
        //Crea un subdirectorio (si no existe) con nombre el id 
        $doc_folder = $this->getUploadFolderPath() . $folder_name;
        if (!file_exists($doc_folder)) {
            if (!mkdir($doc_folder, 0757, true) && !is_dir($doc_folder)) {
                return $this->CREATE_FOLDER_ERROR;
            }
        }
        if (!$this->isUploadFolderWrittable()) {
            return $this->NOT_WRITTABLE_FOLDER_ERROR;
        }
        
        if($file_inputname){
            $file = Request::file($file_inputname);
        }else{
            $file = Request::file('adjunto');
        }
        if (!$file && $mandatory) {
            return $this->ATTATCHMENT_NOT_FOUND_ERROR.$file_inputname;
        }
        
        $destination_filename = $prefix . base64_encode(sha1(rand(11111, 99999))) . "." . $file->getClientOriginalExtension();
        //Movemos (al fin) el archivo y lo nombramos con el nombre del archivo despues de mover
        $file->move($doc_folder, $destination_filename);
        $retorno = "$doc_folder/$destination_filename";
        
        //Escribe un archivo index para evitar el acceso directo
        file_put_contents($doc_folder . "/index.php", '<?php header("Location: ../../");die();?>');
        return $this->getUriFromFile($retorno);
    }

    protected function getUploadFolderPath() {
        return public_path() . $this->ATTATCHMENT_FOLDER;
    }

    protected function isUploadFolderWrittable() {
        return (is_writable($this->getUploadFolderPath())) ? true : false;
    }

    protected function getUriFromFile($file) {
        $path = $file;
        
        $pos = strpos($path, 'public/');
        if ($pos !== false) {
            $path = substr($path, $pos+7);          //+7 caracteres de "public/"
        }
        return $path;
    }

    protected function deleteAttatchmentFile($file_path) {
        //Borramos el archivo asociado
        if ($file_path) {
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
    }

}
