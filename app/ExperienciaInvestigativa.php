<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienciaInvestigativa extends Model
{
    protected $table = 'experiencias_investigativa';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    public $timestamps = false;
}
