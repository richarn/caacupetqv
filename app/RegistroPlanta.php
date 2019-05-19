<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroPlanta extends Model
{
    protected $table = 'registro_planta';
    protected $primarykey = 'idusuario';
    public $timestamps = false;
    protected $fillable = [
    	'idplantas', 'idzona',
    	'fecha', 'ubicacion'
    ];

    protected = $guarded =[];
}
}
