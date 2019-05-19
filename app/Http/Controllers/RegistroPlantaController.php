<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistroPlantaController extends Controller
{
    public function __construct(){

    }

    public function index(){

    	return view('registro_planta.registro_planta');
    }
}
