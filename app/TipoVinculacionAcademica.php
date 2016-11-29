<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVinculacionAcademica extends Model {

    protected $table = 'tipos_vinculacion_academica';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    public $timestamps = false;
    
     public function tipo() {
        return $this->hasOne('App\Vinculacion');
    }

}
