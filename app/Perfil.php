<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfiles';
    protected $filltable = array('*');
    protected $guarded = array('_token');
}
