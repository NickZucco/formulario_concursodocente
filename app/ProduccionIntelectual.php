<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduccionIntelectual extends Model
{
    protected $table = 'produccion_intelectual';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    public $timestamps = false;
}
