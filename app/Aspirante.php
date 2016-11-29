<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estudio as Estudio;

class Aspirante extends Model
{
     protected $table = 'aspirantes';
     protected $filltable = array('*');     
     protected $guarded = array('_token');
     
     public function estudios(){
         return $this->hasMany('App\Estudio');
     }
}
