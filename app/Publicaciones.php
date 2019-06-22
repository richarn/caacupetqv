<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicaciones extends Model {
    protected $table = 'publicaciones';
    protected $primaryKey = 'idPublicacion';
    public $timestamps = true;
    protected $fillable = [
    	'idUsuario',
    	'idPlanta',
    	'idZona',
    	'descripcion',
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
    	return $this->belongsToMany('App\Zonas');
    }
}
