<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienciaLaboral extends Model {

    protected $table = 'experiencias_laboral';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    public $timestamps = false;

}
