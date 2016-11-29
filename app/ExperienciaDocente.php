<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienciaDocente extends Model
{
    protected $table = 'experiencias_docente';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    public $timestamps = false;
}
