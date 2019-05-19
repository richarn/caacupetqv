<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = 'zona';
    protected $primarykey = 'idzona';
    public $timestamps = false;
    protected $fillable = [
    	'descripcion'
    ];

    protected = $guarded =[];
}
}
