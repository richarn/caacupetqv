<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistroPlantacionController extends Controller
{
    public function __construct(){

    }

    public function index(){

    	return view('registro_plantacion.registro_plantacion');
    }
}
