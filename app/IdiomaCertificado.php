<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdiomaCertificado extends Model
{
    protected $table = 'idiomas_certificado';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    public $timestamps = false;
}
