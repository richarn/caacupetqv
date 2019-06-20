<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicaciones extends Model {
    protected $table = 'publicaciones';
    public $timestamps = false;
    protected $fillable = [
    	'idUsuario',
    	'idPlanta',
    	'idZona',
    	'fecha',
    	'estado'
    ];

    protected $guarded = [];

    function usuarios() {
    	return $this->belongsToMany('App\User');
    }

    function plantas() {
    	return $this->belongsToMany('App\Plantas');
    }

    function zonas() {
    	return $this->belongsToMany('App\Zona');
    }
}
