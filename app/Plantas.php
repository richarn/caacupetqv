<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plantas extends Model {
    protected $table = 'plantas';
    protected $primaryKey = 'idPlanta';
    public $timestamps = true;
    protected $fillable = [
    	'nombre', 'descripcion', 'imagen', 'estado'
    ];

    protected $guarded = [];

    public function publications() {
        return $this->hasMany('App\Publicaciones', 'idPlanta');
    }
}
