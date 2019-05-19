<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plantas extends Model
{
    protected $table = 'plantas';
    protected $primarykey = 'idplantas';
    public $timestamps = false;
    protected $fillable = [
    	'nombre', 'descripcion', 'imagen'
    ];

    protected = $guarded =[];
}
