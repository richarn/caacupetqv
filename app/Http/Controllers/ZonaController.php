<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZonaController extends Controller
{
    public function __construct(){

    }

    public function index(){

    	return view('zona.zona');
    }

    public function StoreZona(Request $request){

    }
}
