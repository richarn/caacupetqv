<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model {
    protected $table = 'zona';
    protected $primaryKey = 'idZona';
    public $timestamps = false;
    protected $fillable = [
    	'descripcion'
    ];

    protected $guarded = [];

}
