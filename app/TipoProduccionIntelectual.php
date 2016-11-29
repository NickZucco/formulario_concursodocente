<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProduccionIntelectual extends Model
{
    protected $table = 'tipos_produccion_intelectual';
    protected $filltable = array('*');     
    protected $guarded = array('_token');
}
