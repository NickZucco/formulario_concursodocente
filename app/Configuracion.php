<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    public $timestamps = false;
}
