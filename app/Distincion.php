<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;

class Distincion extends Model {

    protected $table = 'distinciones_academica';
    protected $filltable = array('*');
    protected $guarded = array('_token');
    public $timestamps = false;

}
