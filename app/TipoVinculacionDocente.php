<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVinculacionDocente extends Model
{
    protected $table = 'tipos_vinculacion_docente';
    protected $filltable = array('*');     
    protected $guarded = array('_token');
}
