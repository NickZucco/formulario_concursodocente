<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    protected $table = 'idiomas';
    protected $filltable = array('*');
    protected $guarded = array('_token');
}
