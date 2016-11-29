<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vinculacion extends Model {

    protected $table = 'vinculaciones';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    public $timestamps = false;

    public function tipo() {
        return $this->belongsTo('App\TipoVinculacionAcademica');
    }

}
