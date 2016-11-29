<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudio extends Model {

    protected $table = 'estudios';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    
    public $timestamps = false;

}
