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
    	'estado'
    ];

    protected $guarded = [];

    function usuario() {
    	return $this->belongsTo('App\User', 'idUsuario');
    }

    function planta() {
    	return $this->belongsTo('App\Plantas', 'idPlanta');
    }

    function zona() {
    	return $this->belongsTo('App\Zonas', 'idZona');
    }
}
