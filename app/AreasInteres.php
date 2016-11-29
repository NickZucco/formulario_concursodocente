<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreasInteres extends Model
{
    protected $table = 'areas_interes';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    public $timestamps = false;
}
