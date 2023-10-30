<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Tb_preguntas_financieraController extends Controller
{
    protected $table = 'tb_preguntas_financiera';

    protected $fillable = ['pregunta'];

    public $timestamps = false;
}
