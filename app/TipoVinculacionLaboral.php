<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;

use Illuminate\Database\Eloquent\Model;

class TipoVinculacionLaboral extends Model
{
     protected $table = 'tipos_vinculacion_laboral';
     protected $filltable = array('*');     
     protected $guarded = array('_token');
}
